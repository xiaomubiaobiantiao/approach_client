<?php
/**
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Service\Pack;

use Home\Model\PackModel;
use Home\Common\Service\CommonService;
use Home\Service\Pack\PackDetectionLogService as PackLog;
use Home\Common\Utility\FileBaseUtility as FileBase;
//use Home\Common\Utility\UploadUtility as Upload;
//use Home\Common\Utility\DownloadUtility as Download;

class PackService // extends CommonService
{

	//初始化文本数据
	public function __construct() {
		$this->PackModel = new PackModel();
		//$this->download = new Download();
	}

	/* --------------------------------------------------------------------------- */
	/* ----- 本文数据操作 -------------------------------------------------------- */
	/* --------------------------------------------------------------------------- */
	
	//获取分类列表
	public function getSystemTypeList() {
		return $this->PackModel->systemTypeList();
	}

	//获取全部数据列表
	public function getDataList() {
		return $this->PackModel->getData();
	}

	//返回所有压缩包信息
	public function getUpdatePack() {
		$datalist[] = $this->getSystemTypeList();
		$datalist[] = $this->getDataList();
		return $datalist;
	}

	//获取单个分类的相关数据
	public function getTypeDataList( $pTypeId ) {
		if ( empty( $pTypeId ))
			return $this->getDataList();
		
		$typeDataList = $this->PackModel->typeDataList();
		return $typeDataList[$pTypeId];
	}

	//返回系统分类列表和当前分类相关数据的和集
	public function dataCollection( $pTypeId ) {
		//下面赋值依次为分类列表,当前类别相关数据
		$dataList[] = $this->getSystemTypeList();
		$dataList[] = $this->getTypeDataList( $pTypeId );
		$dataList[] = $pTypeId;
		return $dataList;
	}

	/* --------------------------------------------------------------------------- */
	
	//下载更新包
	public function download( $pId ) {

		//获取单个更新包信息
		$packInfo = $this->packInfo( $pId );
		//下载文件
		//$this->download->down( $packInfo['download'], UPLOAD_PATH )
			// ? $this->download->successReceive( 1, UPLOAD_PATH )
			// : $this->download->inforReceive( __METHOD__.' '.__LINE__.' '.$pId.'|'.$packInfo['download'].' '.UPLOAD_PATH, 1 );

		$this->down( $packInfo['download'], UPLOAD_PATH )
			? PackLog::successReceive( 5, UPLOAD_PATH )
			: PackLog::inforReceive( __METHOD__.' '.__LINE__.' '.$pId.'|'.$packInfo['download'].' '.UPLOAD_PATH, 6 );

		//组合下载后更新包的路径
		$localPath = rtrim( UPLOAD_PATH, '/' ).'/'.$packInfo['pack_name'];
		//检测文件是否存在
		PackLog::scanFile( $localPath )
			? PackLog::successReceive( 1, $localPath )
			: PackLog::inforReceive( __METHOD__.' '.__LINE__.' '.$localPath, 1 );

		//设置更新包的下载状态信息为 1 已下载
		$this->PackModel->setStatusValue( $pId, 1 );

		//检测更新包的下载状态信息是否更新成功为 1
		$boolValue = $this->PackModel->downloadStatus( $pId, 1 );

		//判断更新包的下载状态并给出相应信息
		if ( false == PackLog::checkBoolValue( $boolValue )) {
			//删除本地更新包
			$this->PackModel->deletePack( $localPath );
			PackLog::inforReceive( __METHOD__.' '.__LINE__.' '.$pId.'|1|'.$localPath, 5 );
		} else {
			PackLog::successReceive( 4, $pId.'|1|'.$localPath );
		}

	}

	//删除本地更新包过程
	public function deletePackProcess( $pId ) {

		//获取更新本地地址
		$packInfo = $this->packInfo( $pId );

		//组合下载后更新包的路径
		$localPath = rtrim( UPLOAD_PATH, '/' ).'/'.$packInfo['pack_name'];
		//检测本地更新包是否存在
		if ( false == PackLog::scanFile( $localPath ))
			PackLog::inforReceive( __METHOD__.' '.__LINE__.' '.$localPath, 3 );

		//删除本地更新包
		$this->PackModel->deletePack( $localPath );

		//检测本地更新包是否删除更新成功
		false == PackLog::scanFile( $localPath )
			? PackLog::successReceive( 2, $localPath )
			: PackLog::inforReceive( __METHOD__.' '.__LINE__.' '.$localPath, 2 );

		//设置更新包的下载状态信息为 0 未下载
		$this->PackModel->setStatusValue( $pId, 0 );

		//检测更新包的下载状态信息是否更新成功为 0
		$boolValue = $this->PackModel->downloadStatus( $pId, 0 );

		//判断更新包的下载状态并给出相应信息
		PackLog::checkBoolValue( $boolValue )
			? PackLog::successReceive( 4, $pId.'|0|'.$localPath )
			: PackLog::inforReceive( __METHOD__.' '.__LINE__.' '.$pId.'|0|'.$localPath, 5 );

	}

	//返回一条压缩包相关信息
	private function packInfo( $pId ) {
		return $this->PackModel->getOnePackInfo( $pId );
	}

	private function down( $pUrl, $pFolder ) {
		return FileBase::down( $pUrl, $pFolder );
	}

	//文件上传配置
	// public function fileUpload (){
	// 	//检查上传路径,不存在则创建
	// 	if ( FALSE == is_dir( UPLOAD_PATH )) mkdir( UPLOAD_PATH, 0777 );
	// 	//检查文件是否存在重名
	// 	if ( is_file( $_SERVER['DOCUMENT_ROOT'].'/'.ltrim( UPLOAD_PATH, '.' ).$_FILES['photo']['name'] )) {
	// 		$this->error( '文件重名,请更改' );
	// 		return FALSE;
	// 	}
	// 	//配置上传文件信息
	// 	$config = array(
	// 	    'maxSize'    =>    0,
	// 	    'rootPath'   =>    UPLOAD_PATH,
	// 	    'savePath'   =>    '',
	// 	    'saveName'   =>    '',
	// 	    'saveRule'	 =>	   '',
	// 	    'exts'       =>    array('jpg', 'gif', 'png', 'jpeg', 'rar', 'html', 'zip', 'txt'),
	// 	    'autoSub'    =>    false,
	// 	    'subName'    =>    array('date','Ymd'),
	// 	);

	// 	$Upload = new Upload();

	// 	return $Upload->upload( $config );

	// }

	//数据库添加信息
	// public function addData() {
	// 	//上传文件
	// 	$resultName = $this->fileUpload();
	// 	if ( false == $resultName ) $this->error( '上传失败！' );
	// 	//拼接上传文件全路径
	// 	$uploadPath =  $_SERVER['DOCUMENT_ROOT'].'/'.ltrim( UPLOAD_PATH, '.' ).$resultName;
	// 	//整理需要添加的数据信息
	// 	$data = array(
	// 		'pack_name' => $resultName,
	// 		'path' 	=> $uploadPath,
	// 		'relative_path' => ltrim( UPLOAD_PATH, '.' ).$resultName,
	// 		'download' => '',
	// 		'user' => '目前为空',
	// 		'type' => 1,
	// 		'add_time' => time(),
	// 		'update_time' => time()
	// 	);
	// 	//添加一条更新包记录
	// 	$resultId = $this->PackModel->insertData( $data );
	// 	//判断上传文件与数据库信息是否同步添加成功,如果非同步,则全部删除(删除数据库本次记录和本地上传的本次文件)
	// 	if ( FALSE === $resultName || FALSE === $resultId || FALSE == is_file( $uploadPath )) {
	// 		$this->deleteData( $pId );
	// 		//$this->deleteData( $resultId );
	// 		return false;
	// 	}
		
	// 	return true;

	// }
	
	

	
}