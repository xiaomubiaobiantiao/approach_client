<?php
/**
 * 路径处理系统 - 负责文件遍历后对比目录与文件结构得出最后可操作的文件结果集
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Service\Update;

use Home\Service\Update\UpdateLogService as Log;
use Home\Common\Utility\FileBaseUtility as FileBase;

class UpdateFileService
{

	//初始化更新包文件 与 原有文件 的数组结构
	public $fileOperation = array(
		'update'=>array( 'root_dir'=>array(), 'files'=>array(), 'dirs'=>array(), 'data'=>array()),
		'old'=>array( 'root_dir'=>array(), 'files'=>array(), 'dirs'=>array())
	);

	//更新包根目录与程序根目录的路径 参数为 2 个, 第1个是更新包的路径, 第2个是需要替换的程序的路径
	public $dirArr = array();

	//初始化路径最终结果集
	public $lastResult = array( 
		'updateAllFileList'=>array(),		//更新包内的全部文件列表 (结束后会被垃圾回收清除)
		'updateFilePathList'=>array(),		//需要更新的文件路径 (不包括文件名 创建目录的时候用)
		'backUpFileList'=>array(),			//需要备份的文件列表 (最后会被压缩成zip文件备份 并写到备份日志里面)
		'backUpFilePathList'=>array(),		//需要备份的文件路径 (不包括文件名 创建目录的时候用)
		'addFileList'=>array(),				//需要追加的文件列表 (写到追加日志里面)
		'deleteFileList'=>array(),			//需要删除的文件列表 (写到删除日志里面)
	);

	//初始化更新包里面的日志列表 - 目前只可能有删除日志 - 或者没有日志
	public $logs = array();

	//备份 - 追加文件列表的日志路径
	public $addLogFilePath = '';

	//备份 - 替换文件列表的备份日志路径
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

	//构造
	public function __construct( $arr ) {
		if ( false == empty( $arr )) {
			$this->dirArr = $arr;
			$this->fileAllPath();
			$this->fileReplace(
				$this->fileOperation['old']['files'], 
				$this->fileOperation['update']['files']
			);
		}
	}
	
	//获取 更新包文件 与 原有文件,返回数组结构
	private function fileAllPath() {
		$pathName = array_keys( $this->fileOperation );
		foreach ( $this->dirArr as $key=>$value ) 
			$this->myReaddir( $value, $pathName[$key] );
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
		$this->lastResult['backUpFileList'][] = $pFilePath;
	}

	/**
	 * 获取目录下所有文件的路径 - 只对本类数据结构有效
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
	        
	        //如果是数据库目录, 单独放到一个元素里, 不与需要更新的文件在同一列表 - 暂时未用
	        // if ( $dir == DATABASE_UPDATE ) {
	        // 	$this->fileOperation['update']['data'] = FileBase::checkDirFiles( $dir );
	        // 	break;
	        // }

	        //跳过不需要检测的 原有文件的 目录
	        if ( $arrName == 'old' && in_array( $dir, $this->strConversionArr( IGNORE_DIRS ) ))
	        	continue;

	        //拼接地址
	        $path = rtrim( $dir, '/' ).'/'.$file;

	        //递归检测目录
	        if ( is_dir( $path )) {
	        	$i++;
	        	$this->myReaddir( $path, $arrName );
	        }

	        //过滤压缩包里的日志文件 并添加到 $this->logs 数组
	        if ( $this->is_log( $path ))
	        	continue;

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
	private function fileReplace( $pArr1, $pArr2 ) {
		$this->lastResult['deleteFileList'] = $this->readLogProcess( $this->dirArr[0] );
		$this->lastResult['updateAllFileList'] = $pArr2;
		$this->lastResult['updateFilePathList'] = $this->distinctPath( $this->lastResult['updateAllFileList'] );
		$this->lastResult['backUpFileList'] = array_merge_recursive( array_intersect( $pArr1, $pArr2 ), $this->lastResult['deleteFileList'] );
		$this->lastResult['backUpFilePathList'] = $this->distinctPath( $this->lastResult['backUpFileList'] );

		false == empty( $this->lastResult['backUpFileList'] )
			? $this->lastResult['addFileList'] = array_diff( $pArr2, $this->lastResult['backUpFileList'] )
			: $this->lastResult['addFileList'] = $pArr2;
		//$this->lastResult['addFileList'] = array_diff( $pArr2, $this->lastResult['backUpFileList'] );
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

	/**
	 * 扫描压缩包里的日志文件
	 * [is_log description]
	 * @param  [string]  $pFile [文件路径]
	 * @return boolean        [true or false]
	 */
	private function is_log( $pFile ) {
		$fileAttr = pathinfo( $pFile );
		if( $fileAttr['extension'] == 'log' ) {
			$this->logs[] = $pFile;
			return true;
		}
		return false;
	}

	/* ------------------------------------------------------------------------------------- */
	/* ------------- 读取读取压缩包内删除日志的流程 ---------------------------------------- */
	/* ------------------------------------------------------------------------------------- */
	//以下流程本不需要这么多步骤 - 为了以后方便开发 - 需要删除文件的可能性很小 但也不排除 方便阅读文件操作过程
	//读取压缩包里日志内容流程
	private function readLogProcess( $pDir ) {
		return false == empty( $this->logs ) ? $this->readPath( $this->logs, $this->dirArr[0] ) : false;
	}

	/**
	 * 打开文件并读取文件路径 当前只读取包含 del 的 log 文件
	 * [readPath description]
	 * @param  [array] $pFileArr [日志路径数组]
	 * @param  [string] $pPath    [日志内容里面要清除的路径字符串]
	 * @return [array]           [已清除指定路径的数组]
	 */
	private function readPath( $pFileArr, $pPath ) {
		foreach ( $pFileArr as $value ) {
			if ( strstr( $value, 'del' )) 
				return $this->readFile( $value, $pPath );
		}
	}

	/**
	 * 读取文件内容 - 并清除原始数据的绝对路径 - 方便对比路径 - 只为本类用
	 * [readFile description]
	 * @param  [string] $pFileArr [路径信息]
	 * @param  [string] $pPath    [要清除的路径字符串]
	 * @return [array]           [已清除指定路径的数组]
	 */
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
	/* ------------------------------------------------------------------------------------- */




}