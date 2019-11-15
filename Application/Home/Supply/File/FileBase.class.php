<?php
/**
 * 文件操作基础类
 * [FileBaseUtility]
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Supply\File;

class FileBase
{

	//读取文件内容 - 每次读取一行
	public function readFile( $pFile ) {
		$handle = fopen( $pFile, "rb" );
        while ( !feof( $handle )){
            $data = fgets( $handle );
        }
        fclose( $handle );
        return $data;
	}

	//读取文件内容 - 一次性读取全部
	public function readFileAll( $pFile ) {
		return file_get_contents( $pFile );
	}

	//获取文件修改时间
	public function scanFileInfo( $pFile ) {
		if ( false == self::checkFile( $pFile ))
			return false;
		$handle = fopen( $pFile, "r" );
		$fileStat = fstat( $handle );
		return $fileStat["mtime"];
	}

	//创建文件
	public function createFile( $pFilePath ) {
		if ( false == file_exists( $pFilePath ) )
			return touch( $pFilePath );
	}

	/**
	 * 将内容写入文件,文件不存在则自动创建(在目录存在的情况下才会自动创建)
	 * [writeFile description]
	 * @param  [string] $filePath [write in path]
	 * @param  [type] $content  [write content]
	 * @return [type]           [description]
	 */
	public function writeFile( $pContent, $pFilePath ) {

		//去掉文件名称,然后创建文件需要的路径
		if ( false == is_array( $pFilePath ) && strstr( $pFilePath, '.' ))
			self::createDir( dirname( $pFilePath ));

		//如果创建文件失败,返回错误信息
		if ( false == ( $handle = fopen( $pFilePath, "a+" )))
			return false;

		//示例$combination = '[' . date( 'Y-m-d h:i:s') . '] '. $content . "\r\n";
		if ( is_array( $pContent )) {
			foreach ( $pContent as $value )
				fwrite( $handle, $value."\r\n" );
		} else {
			fwrite( $handle, $pContent."\r\n" );
		}

		//关闭资源
		fclose( $handle );

		//返回文件路径
		return true;
		// file_put_contents($filepath, 'use file_put_contents function', FILE_APPEND);  // 附加内容
		
	}

	/**暂未用
	 * 将内容写入文件,文件不存在则自动创建(在目录存在的情况下自动创建)
	 * [writeFile description]
	 * @param  [string] $filePath [write in path]
	 * @param  [type] $content  [write content]
	 * @return [type]           [description]
	 */
	public function writeFileReplace( $pContent, $pFilePath ) {

		//去掉文件名称,然后创建文件需要的路径
		if ( false == is_array( $pFilePath ) && strstr( $pFilePath, '.' ))
			self::createDir( dirname( $pFilePath ));

		//如果创建文件失败,返回错误信息
		if ( false == ( $handle = fopen( $pFilePath, "a+" )))
			return false;

		//示例$combination = '[' . date( 'Y-m-d h:i:s') . '] '. $content . "\r\n";
		fwrite( $handle, $pContent."\r\n" );

		//关闭资源
		fclose( $handle );

		//返回文件路径
		return true;
		// file_put_contents($filepath, 'use file_put_contents function', FILE_APPEND);  // 附加内容
		
	}

	//递归创建目录
	public function createDir( $pPath ) {
		if ( false == is_dir( $pPath )) {
			self::createDir( dirname( $pPath ));
			mkdir( $pPath, 0777 );
		}
	}

	//递归删除目录
	public function deleteDir( $path ) {

		$path = str_replace( '\\', '/', $path ); //去除反斜杠
		$path = rtrim($path,'/');

	    if ( false == is_dir( $path ))
        	return false;
        
        if ( false == ( $handle = opendir( $path )))
			return false;
		
        while ( false != ( $file = readdir( $handle ))) {

            if ( $file == '.' || $file == '..' )
                continue;

            $pNewPath = rtrim( $path.'/' ).'/'.$file;

            is_dir( $pNewPath )
            	? self::deleteDir( $pNewPath )
            	: self::deleteFile( $pNewPath );
            	//if( pathinfo( $pNewPath, PATHINFO_EXTENSION ) != 'zip' ) //遇到 zip 压缩文件跳过-之前用的,暂时未用
        }

        if ( false == readdir( $handle ) ) {
	        closedir( $handle );      //关闭目录句柄
	        rmdir( $path );          //删除空目录
	    }

	    return true;

	}

	//扫描目录下的所有文件 - 不是递归扫描 - 只扫描一维
	public function checkAllFile( $pDir ) {

	    $handle = opendir( $pDir );
        //循环资源文件
	    while ( false !== ( $file = readdir( $handle ))) {
	    	//跳过不需要检测的文件
	        if ( $file == '.' || $file == '..' )
	        	continue;
	        
	        $path = rtrim( $pDir, '/' ).'/'.$file;
			$data[] = $path;
	    }
	    closedir( $handle ); 
	    return $data;
	}

	//扫描目录下的所有文件 - 递归扫描 - 合并成一维数组
	public function checkFiles( $pDir ) {
		$handle = opendir( $pDir );
        //循环资源文件
	    while ( false !== ( $file = readdir( $handle ))) {
	    	//跳过不需要检测的文件
	        if ( $file == '.' || $file == '..' )
	        	continue;
	        
	        $path = rtrim( $pDir, '/' ).'/'.$file;
			
			//递归检测目录
	        if ( is_dir( $path )) {
	        	$result = self::checkFiles( $path );
	        	foreach ( $result as $value )
					$data[] = $value;
	        }

	        //if ( is_file( $path ))
				$data[] = $path;

	    }
	    closedir( $handle ); 
	    return $data;
	}

	//扫描目录下的所有文件 - 递归扫描 - 保留原有文件结构 - 关联
	public function checkDirFiles( $pDir ) {
		
		$handle = opendir( $pDir );
        //循环资源文件
	    while ( false !== ( $file = readdir( $handle ))) {
	    	//跳过不需要检测的文件
	        if ( $file == '.' || $file == '..' )
	        	continue;
	        
	        $path = rtrim( $pDir, '/' ).'/'.$file;

	        is_dir( $path )
	        	? $dirName = basename( $path )
	        	: $dirName = basename( $pDir );

			//递归检测目录
	        if ( is_dir( $path )) {
	        	$data[$dirName] = self::checkDirFiles( $path );
	        }

	        if ( is_file( $path ))
				$data[] = $path;

	    }
	    closedir( $handle ); 
	    return $data;
	}

	/**
	 * 检测传入的文件是否存在-多个文件可以数组的形式传递 - 暂时未用
	 * [detectionAllFile]
	 * @param  [String or Array] $pAnyFile [ path or multiple paths ]
	 * @return [bool]       [true | false]
	 */
	public function detectionFile( $pAnyFile ) {

		if ( empty( $pAnyFile ))
			return false;

		if ( is_array( $pAnyFile )) {
			foreach( $pAnyFile as $value ) {
				if ( false == is_file( $value ))
					return false;
			}
		} else {
			if ( false == is_file( $pAnyFile ))
				return false;
		}
		return true;
	}

	/**
	 * 检测目录是否存在-多个目录可以数组的形式传递 - 暂时未用
	 * [detectionAllFile]
	 * @param  [String or Array] $pAnyDir [ path or multiple paths ]
	 * @return [bool]       [true | false]
	 */
	public function detectionDir( $pAnyDir ) {

		if ( empty( $pAnyDir ))
			return false;

		if ( is_array( $pAnyDir )) {
			foreach( $pAnyDir as $value ) {
				if ( false == is_dir( $value ))
					return false;
			}
		} else {
			if ( false == is_dir( $pAnyDir ));
				return false;
		}
		return true;
	}

	//复制文件
	public function copyFile( $pFilePath, $pNewPath ) {
		return copy( $pFilePath, $pNewPath );
	}

	//删除文件
	public function deleteFile( $pFile ) {
		return unlink( $pFile );
	}

	/**
	 * 检测文件是否存在-只检测单个文件
	 * [checkFile]
	 * @param  [String] $pFilePath [ file path ]
	 * @return [bool]       [true | false]
	 */
	public function checkFile( $pFilePath ) {
		 return is_file( $pFilePath );
	}

	/**
	 * 检测目录是否存在-只检测单个目录
	 * [checkDir]
	 * @param  [String] $pFileDir [ path ]
	 * @return [bool]       [true | false]
	 */
	public function checkDir( $pFileDir ) {
		return is_dir( $pFileDir );
	}

}