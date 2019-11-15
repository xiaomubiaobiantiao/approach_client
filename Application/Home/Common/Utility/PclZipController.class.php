<?php
/**
 * 压缩包操作类
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Common\Utility;

//use Think\Controller;
use Home\Utility\PclZip;
use Home\Common\Utility\FileBaseUtility as FileBase;

class PclZipController //extends Controller
{

	//zip压缩文件 目前仅支持文件在需要备份目录下的相对路径,也就是需要压缩的文件必须在生成压缩文件的根目录为起始。
	/**
	 * [createZip 创建zip压缩文件]
	 * @param  [string] $pPath        [将要生成的备份文件的路径(包括文件名和后缀)]
	 * @param  [array] $pFilePathArr [需要压缩的文件路径列表(包括文件名和后缀)]
	 * @return [type]               [error or success]
	 */
	public function createZip( $pPath, $pFilePathArr='' ) {

		//如果创建的压缩文件路径不存在 尝试创建路径
		//if ( FALSE == is_dir( $pPath ))
		//	FileBase::createDir( dirname( $pPath ));

		//初始化压缩类生成压缩文件的路径,路径必须是目录,不能是文件
		$zip = new PclZip( $pPath );

		//将需要压缩的文件列表创建到 zip 压缩包中
		//$v_list = $zip->create( $pFilePathArr );
		//去掉临时路径再创建压缩文件
		$v_list = $zip->add( $pFilePathArr, PCLZIP_OPT_REMOVE_PATH, BACKUP_TMP_PATH );

		if ( $v_list == 0 ) {
			//return false;
			die( "Error : " . $zip->errorInfo( true )); //报错信息-备用
		}
		return true;
	}

	/**
	 * zip解压文件
	 * [unpackZip description]
	 * @param  [string] $pPath   [压缩文件的路径 包括文件名]
	 * @param  [string] $pToPath [要解压至的目标路径 不包括文件名]
	 * @return [bool]          [true or false]
	 */
	public function unpackZip( $pPath, $pToPath ) {
		
		//要解压缩文件的路径
		$zip = new PclZip( $pPath );
		
		if ( $zip->extract( $pToPath, 'Files' ) == 0 ) {
			return false;	//$zip->errorInfo( true ) 报错信息-备用
		}
		
		// 新增的 Database 需要删除 - 未完待续 - 解决方案:
		// 1.查找 pclzip 只解压部份文件
		// 2.解压后删除 Database 文件夹
		
		return true;


	}

	// 获取压缩包文件列表
	public function getZipFileList( $pPath ) {

		$zip = new PclZip( $pPath );

		if (( $list = $zip->listContent()) == 0 )
        	return false;

		return $list;

  //       for ( $i=0; $i<sizeof($list); $i++ ) {
  //           for ( reset($list[$i] ); $key = key( $list[$i] ); next( $list[$i] )) {
  //               echo "File $i / [$key] = " . $list[$i][$key]."<br>";
  //           }
  //           echo "<br>";
		// }

	}


	// 获取压缩包内单个文件的内容
	public function getZipFileContent( $pPath, $pFilePath ) {

		$zip = new PclZip( $pPath );

		$list = $zip->extract( PCLZIP_OPT_BY_NAME, $pFilePath, PCLZIP_OPT_EXTRACT_AS_STRING );
		if ( $list == 0 || empty( $list )) 
			return false;

		return $list[0]['content'];

	}


}