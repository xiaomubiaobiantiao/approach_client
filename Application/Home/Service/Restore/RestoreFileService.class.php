<?php
/**
 * 路径处理系统 - 负责文件遍历后对比目录与文件结构得出最后可操作的文件结果集
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Service\Restore;

use Home\Service\Restore\RestoreLogService as Log;
//use Home\Common\Utility\DetectionUtility as Detection;

class RestoreFileService
{

	//初始化备份包文件 与 原有文件 的数组结构
	public $fileOperation = array(
		'backUp'=>array( 
			'root_dir' =>array(), //备份文件所在路径
			'files'    =>array(), //备份文件路径列表 - 更新时备份的真实存在的文件
			'all_log'  =>array(), //全部日志路径列表 - 追加/备份日志列表 - 不包括删除日志
			'add_log'  =>array(), //追加日志路径列表 - 更新时追加的文件列表
			'back_log' =>array(), //备份日志路径列表 - 更新时备份的文件路径列表
			'del_log'  =>array()  //删除日志路径列表 - 更新时删除的文件
		),

		'old'=>array( 'root_dir'=>array(), 'files'=>array(), 'dirs'=>array() )

	);

	//初始化用来存储备份包里面的日志信息
	public $logs = array();

	//备份包根目录与程序根目录的路径 参数为 2 个, 第1个是备份包的路径, 第2个是需要替换的程序的路径
	public $dirArr = array();

	//初始化路径最终结果集
	public $lastResult = array( 
		'backUpLogFileList'=>array(),		//全部日志内的所有文件列表 (不包括删除日志)
		'backUpFileList'=>array(),			//需要恢复的文件列表 (结束后会被垃圾回收清除)
		'backUpFilePathList'=>array(),		//需要恢复的文件路径 (不包括文件名 创建目录的时候用)
		'mustBackUpFileList'=>array(),		//必须备份的文件列表 (最后会被压缩成zip文件备份 并写到备份日志里面)
		'mustBackUpFilePathList'=>array(),	//必须备份的文件路径 (不包括文件名 创建目录的时候用)
		'addFileList'=>array(),				//需要追加的文件列表 (写到删除日志里面)
		'deleteFileList'=>array()			//需要删除的文件列表 (写到删除日志里面)
	);

	//备份 - 追加文件列表的日志路径
	public $addLogFilePath = '';

	//备份 - 记录被替换文件列表的日志路径
	public $backUpLogFilePath = '';

	//备份 - 记录项目被删除列表的日志路径
	public $delLogFilePath = '';

	//备份 - 
	//备份的zip压缩包路径 - 压缩包信息包含
	//1 需要替换的文件
	//2 追加日志
	//3 替换日志
	//4 删除日志
	public $backUpPackFilePath = '';

	//最终返回结果
	public $lastReturn = true;

	//构造
	public function __construct( $pArr ) {
		if ( false == empty( $pArr )) {
			$this->dirArr = $pArr;
			$this->testingProcess();
		}
	}

	//文件检测流程
	public function testingProcess() {

		//读取备份日志信息流程
		$this->readBackUpLogProcess();
		$pathName = array_keys( $this->fileOperation );
		$this->myReaddir( $this->dirArr[1], $pathName[1] );

		//匹配最终操作路径结果集
		$this->fileReplace( $this->fileOperation['backUp'] );

		//读取真实备份文件到 fileOperation['backUp']['files']
		$this->readAllFile( $this->dirArr[0] );

		//对比备份日志与备份文件是否相同
		$bool_1 = $this->replaceLogAndBackUp();

		//对比备份日志和追加日志与要恢复的项目目录文件是否相同
		$bool_2 = $this->replaceLogAndProject();
		
		//都为真时才返回真 - 用设置值的方式来设置 set 目前是临时用
		if ( $bool_1 && $bool_2 )
			return true;

		return false;

	}

	//读取备份日志信息流程
	public function readBackUpLogProcess() {
		$this->logs = $this->searchAllLog( $this->dirArr[0] );
		$this->readPath( $this->logs );
		$this->fileOperation['backUp']['root_dir'] = $this->dirArr[0];
	}

	//对比备份日志与备份文件是否相同
	public function replaceLogAndBackUp() {
		$countLogs = count( $this->fileOperation['backUp']['back'] );
		$countFiles = count( $this->fileOperation['backUp']['files'] );
		$result = array_intersect(
			$this->fileOperation['backUp']['back'],
			$this->fileOperation['backUp']['files']
		);

		$countResult = count( $result );
		if ( $countResult != $countLogs || $countResult != $countFiles ) 
			return false;

		return true;
	}

	//对比备份日志和追加日志与要恢复的项目目录文件是否相同
	public function replaceLogAndProject() {

		$data = $this->clearDelLogPath(
			$this->fileOperation['backUp']['all_log'],
			$this->fileOperation['backUp']['del_log']
		);

		$countLogs = count( $data );
		$countFiles = count( $this->fileOperation['old']['files'] );
		$result = array_intersect( $data, $this->fileOperation['old']['files'] );

		$countResult = count($result);
		if ( $countResult != $countLogs ) 
			return false;

		return true;
	}

	/**
	 * 将 del_log 里面的文件列表从 all_log 临时里清除 - 返回去除 $pArr2里元素的 $pArr1
	 * [clearDelLogPath 返回数组差集]
	 * @param  [array] $pArr1 [Beginning an array]
	 * @param  [array] $pArr2 [Need to compare an array]
	 * @return [array]        [An array of difference set]
	 */
	public function clearDelLogPath( $pArr1, $pArr2 ) {
		return array_diff( $pArr1, $pArr2 );
	}

	//打开文件并读取文件路径 分别读取 add 与 back del 字样的日志内容
	public function readPath( $pFileArr ) {
		foreach ( $pFileArr as $value ) {
			if ( strstr( $value, 'add' )) {
				$this->fileOperation['backUp']['add_log'] = $this->readFile( $value, $this->dirArr[1]);
			} elseif ( strstr( $value, 'back' )) {
				$this->fileOperation['backUp']['back_log'] = $this->readFile( $value,$this->dirArr[1]);
			} else {
				$this->fileOperation['backUp']['del_log'] = $this->readFile( $value, $this->dirArr[1]);
			}
		}
		//将两个数组合并为一个数组
		$allFile = array_merge_recursive( 
			$this->fileOperation['backUp']['add_log'], 
			$this->fileOperation['backUp']['back_log'] 
		);
		//赋值数组到全部日志
		$this->fileOperation['backUp']['all_log'] = $allFile;
	}

	//扫描全部日志路径: 备份日志 追加日志 删除日志
	public function searchAllLog( $pDir ) {
		$handle = opendir( $pDir );
        //循环资源文件
	    while ( false !== ( $file = readdir( $handle ))) {
	    	//跳过不需要检测的文件
	        if ( $file == '.' || $file == '..' )
	        	continue;
	        //递归检测目录
	        $path = rtrim( $pDir, '/' ).'/'.$file;

			$fileAttr = pathinfo( $file );
			if ( $fileAttr['extension'] == 'log' )
				$data[] = $path;
	    }
	    closedir( $handle ); 
	    return $data;
	}

	//设置追加文件列表日志路径
	public function setAddLogPath( $pAddLogPath ) {
		$this->addLogFilePath = $pAddLogPath;
	}

	//设置备份文件列表日志路径
	public function setBackUpLogPath( $pBackUpLogPath ) {
		$this->backUpLogFilePath = $pBackUpLogPath;
	}

	//设置删除文件列表路径
	public function setDelLogPath( $pDelLogPath ) {
		$this->delLogFilePath = $pDelLogPath;
	}	

	//设置备份压缩包路径
	public function setBackUpZipPath( $pBackUpPath ) {
		$this->backUpPackFilePath = $pBackUpPath;
	}	

	//添加文件到备份列表
	public function pushBackUpList( $pFilePath ) {
		$this->lastResult['mustBackUpFileList'][] = $pFilePath;
	}

	/**
	 * 获取目录下所有文件的路径
	 * [myReaddir get path infor on files and dirs]
	 * @param  [string] $dir     [any path]
	 * @param  [array] $arrName [case: 'name'=>array( 'root_dir'=>array(), files'=>array(), 'dirs'=>aray() )]
	 * @return [array] $fileOperation [path infor the files and dirs]
	 */
	private function myReaddir( $dir, $arrName ) {
		
		static $i = 0;

		//将文件根目录提取出来添加到数组里
		if ( $i == 0 ) {
			$dir == './' ? $tmpDir = $dir : $tmpDir = rtrim( $dir, '/' ).'/';
			$this->fileOperation[$arrName]['root_dir'][] = $tmpDir;
		}

		if ( false == is_dir( $dir ))
			Log::inforReceive( __METHOD__.' '.__LINE__.' '.$dir.'|'.$arrName, 4 );	//错误报告

	    if ( false == ( $handle = opendir( $dir )))
        	Log::inforReceive( __METHOD__.' '.__LINE__.' '.$path.'|'.$arrName, 2 );

        //循环资源文件
	    while ( false !== ( $file = readdir( $handle ))) {
	    	//跳过不需要检测的文件
	        if (( $file == "." || $file == ".." || in_array( $file, $this->strConversionArr( IGNORE_FILES ) )))
	        	continue;
	        
	        //拼接地址
	        $path = rtrim( $dir, '/' ).'/'.$file;
	        //跳过不需要检测的目录
	        if ( $arrName == 'old' && in_array( $dir, $this->strConversionArr( IGNORE_DIRS ) ))
	        	continue;
	        //递归检测目录
	        if ( is_dir( $path )) {
	        	$i++;
	        	$this->myReaddir( $path, $arrName );
	        }

	        //分类文件与文件夹
	        is_dir( $path )
	        	? $this->fileOperation[$arrName]['dirs'][] = str_replace( $this->fileOperation[$arrName]['root_dir'][0], '', $path )
	        	: $this->fileOperation[$arrName]['files'][] = str_replace( $this->fileOperation[$arrName]['root_dir'][0], '', $path );

	    }

		$i = 0;
	    closedir( $handle ); 

	    return $this->fileOperation;	//虽然不用返回,这样写方便读和以后用

	}

	//设置需要替换的文件和目录,追加的文件和目录,还有需要更新的全部文件
	private function fileReplace( $pArr ) {
		//$pArr['del_log'][] = 'Application/test_aaa/files/123123/filename.txt';
		//dump( $pArr['del_log'] );
		// dump( $pArr );
		// die();
		$this->lastResult['backUpLogFileList'] = $pArr['all_log'];
		$this->lastResult['backUpFileList'] = $pArr['back_log'];
		$this->lastResult['backUpFilePathList'] = $this->distinctPath( $this->lastResult['backUpFileList'] );

		false == empty( $pArr['del_log'] )
			? $this->lastResult['mustBackUpFileList'] = array_diff( $pArr['all_log'], $pArr['del_log'] )
			: $this->lastResult['mustBackUpFileList'] = $pArr['all_log'];

		$this->lastResult['mustBackUpFilePathList'] = $this->distinctPath( $this->lastResult['mustBackUpFileList'] );
		$this->lastResult['addFileList'] = $pArr['del_log'];
		$this->lastResult['deleteFileList'] = $pArr['add_log'];
	}

	//去掉文件名,去掉重复的路径并返回
	private function distinctPath( $pFilePathArr ) {
		$tmpArr = array();
		foreach ( $pFilePathArr as $value )
			$tmpArr[] = dirname( $value );
		return array_unique( $tmpArr );
	}

	//字符串转换数组
	private function strConversionArr( $pStr, $pChar = ',' ) {
		return explode( $pChar, trim( $pStr ));
	}

	//读取文件内容 - 并清除备份路径 - 方便对比路径 - 只为本类用
	private function readFile( $pFile, $pPath ) {
		$handle = fopen( $pFile, "rb" );
        while ( !feof( $handle )){
            $tData = fgets( $handle );
            if ( $tData ) {
            	$data[] = trim( str_replace( $pPath, '', $tData ));
            }
        }
        fclose( $handle );
        return $data;
	}

	//读取所有备份文件到 $this->fileOperation['backUp']['files'] 数组中 并去除备份文件临时路径
	private function readAllFile( $pDir ) {
	    $handle = opendir( $pDir );
        //循环资源文件
	    while ( false !== ( $file = readdir( $handle ))) {
	    	//跳过不需要检测的文件
	        if ( $file == '.' || $file == '..' )
	        	continue;
	        //递归检测目录
	        $path = rtrim( $pDir, '/' ).'/'.$file;
	        if ( is_dir( $path ))
	        	$this->readAllFile( $path );

	        $fileAttr = pathinfo( $file );
	        if ( is_file( $path ) && $fileAttr['extension'] != 'log' )
				$this->fileOperation['backUp']['files'][] = str_replace( $this->dirArr[0], '', $path );
	    }
	    closedir( $handle ); 
	    return $data;
	}


}