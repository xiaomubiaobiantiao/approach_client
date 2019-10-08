<?php
/**
 * 项目检测类 - 暂时未用 - 没时间开发
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Controller;

//use Think\Controller;
use Home\Common\Utility\FileBaseUtility as FileBase;

class SystemSearchController //extends Controller  //\Home\Controller\IndexController 获得权限用
{

	//初始化需要对比的项目结构数组
	private $projectGroup = array();

	public function __construct() {
		set_time_limit(0);
		// $this->createProjectStructure();
		// $this->getProjectGroup( PROJECT_STRUCTURE );
	}

	//对比项目文件 查看系统存在哪几种项目
	private function contrastProject() {
		$result = $this->search();
		$count = count( array_diff( $result, array2) );
	}

	//暂时未用 - 开发时间不足
	public function search() {
		
		//$path = 'D:/phpStudy/PHPTutorial/WWW/approach_test/';
		$path = 'E:';
		$data = $this->checkFiles( $path );
		// foreach ( $data as $key=>$value ) {
		// 	if ( is_dir( $value ) && false == in_array( $dir, $this->strConversionArr( IGNORE_DIRS ))) {
		// 		$dir[] = $value;
		// 		unset( $data[$key] );
		// 	}
		// }
		//dump( $dir );
		//dump( $data );
		//$files = $this->clearSpecificPath( $path, $data );
		dump( $data );
		//return $files;
		
	}

	//获取项目组结构数组
	public function getProjectGroup( $pDir ) {
		$this->projectGroup = FileBase::checkAllFile( $pDir );
	}

	//创建项目文件结构
	public function createProjectStructure() {

		if ( false == is_dir( PROJECT_STRUCTURE ))
			FileBase::createDir( PROJECT_STRUCTURE );
	}

	//字符串转换数组
	private function strConversionArr( $pStr, $pChar = ',' ) {
		return explode( $pChar, trim( $pStr ));
	}

	//去掉数组中路径前的指定路径
	public function clearSpecificPath( $pPath, $pArr ) {
		foreach ( $pArr as $value )
			$data[] = str_replace( $pPath, '', $value );
		return $data;
	}

	//扫描目录下的所有文件 - 递归扫描 - 合并成一维数组
	//暂时未用 - 需要手动添加 - 问题:内存溢出
	public function checkFiles( $pDir ) {
		//$this->sleepOperation();
		$handle = opendir( $pDir );
        //循环资源文件
	    while ( false !== ( $file = readdir( $handle ))) {
	    	//跳过不需要检测的文件
	        if ( $file == '.' || $file == '..' )
	        	continue;
	        
	        $path = rtrim( $pDir, '/' ).'/'.$file;
			//echo $path;
			//递归检测目录
	        if ( is_dir( $path )) {
	        	if ( strstr( $path, 'approach_test' ))
	        		return $path;

	        	$rootPath = self::checkFiles( $path );
	        	if ( false == $rootPath ) {
	        		unset( $rootPath );
	        	} else {
	        		closedir( $handle );
	        		return $rootPath;
	        	}
	        } else {
	        	unset( $path );
	        	continue;	
	        }

	        echo memory_get_usage().'<br>';
	        ob_flush();
			flush();
			//sleep(1);
			ob_end_clean();
	    }
	    

	}

	//睡眠 - 暂未用
	private function sleepOperation( $pLong = 1 ) {
		sleep( $pLong );
	}


}
