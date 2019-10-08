<?php
/**
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Service\Index;

//use Home\Common\Service\CommonService;
use Home\Common\Utility\PclZipController as Zip;
use Home\Common\Utility\DownloadUtility as Download;
use Home\Common\Utility\FileBaseUtility as FileBase;
use Home\Common\Utility\DetectionUtility as Detection;
use Home\Service\Index\IndexLogService as ProcessLog;

class IndexParentService //extends CommonService
{

	public function __construct() {
		$this->Proc = new ProcessLog();
		$this->Detection = new Detection();
		$this->Download = new Download();
	}

	//初始化执行目录,配置文件里面设置的全局变量的目录 - 未写
	public function createPerformDir() {
		FileBase::createDir();
	}

	//扫描当前版本
	public function searchVersion( $pVersionPath ) {
		$this->Detection->scanFile( $pVersionPath )
			? $this->Detection->successReceive( 4, $pVersionPath )
			: $this->Detection->inforReceive( __METHOD__.' '.__LINE__.' '.$pVersionPath, 4 );
	}

	//获取文件本地数据
	public function getTextData() {
		
	}

	//下载文件
	public function downFile() {
		$this->Download->down();
	}

	//创建压缩文件
	public function addZip( $pZipPath, $pFilePathList ) {
		Zip::createZip( $pZipPath, $pFilePathList )
			? $this->Proc->successReceive( 1, $pZipPath.'|'.$pFilePathList )
			: $this->Proc->inforReceive(  __METHOD__.' '.__LINE__.' '.$pZipPath.'|'.$pFilePathList, 3 );
		return $pZipPath;
	}

	//释放压缩文件
	public function unZip( $pZipPath, $pToPath ) {
		Zip::unpackZip( $pZipPath, $pToPath )
			? $this->Proc->successReceive( 2, $pZipPath.'|'.$pToPath )
			: $this->Proc->inforReceive( __METHOD__.' '.__LINE__.' '.$pZipPath.'|'.$pToPath, 3 );
	}

	//删除目录下的所有文件-
	public function deleteTmpFile( $pPathArr ) {
		foreach ( $pPathArr as $value ) {
		FileBase::deleteDir( $value )
			? $this->Proc->successReceive( 3, $value )
			: $this->Proc->inforReceive( __METHOD__.' '.__LINE__.' '.$value, 6 );
		}
	}

	//copy备份文件操作流程 先循环创建目录,再循环创建文件
	public function copyBackUpFile( $pFilePathArr, $pFileArr, $pUpdatePath, $pBackUpPath ) {
		foreach ( $pFilePathArr as $value ) {
			FileBase::createDir( $pBackUpPath.$value );
			is_dir( $pBackUpPath.$value )
				? $this->Proc->successReceive( 9, $pBackUpPath.$value )
				: $this->Proc->inforReceive( __METHOD__.' '.__LINE__.' '.$pBackUpPath.$value, 7 );
		}
		foreach ( $pFileArr as $value ) {
			$this->copyFiles( $pUpdatePath.$value, $pBackUpPath.$value )
				? $this->Proc->successReceive( 10, $pBackUpPath.$value )
				: $this->Proc->inforReceive( __METHOD__.' '.__LINE__.' '.$pUpdatePath.$value.' '.$pBackUpPath.$value.' ', 8 );
		}
		$this->Proc->successReceive( 6 );
	}

	//copy更新文件操作流程 先循环创建目录,再循环创建文件
	public function copyUpdateFile( $pFilePathArr, $pFileArr, $pUpdatePath, $pBackUpPath ) {
		foreach ( $pFilePathArr as $value ) {
			FileBase::createDir( $updatePath.$value );
			is_dir( $updatePath.$value )
				? $this->Proc->successReceive( 11, $pBackUpPath.$value )
				: $this->Proc->inforReceive( __METHOD__.' '.__LINE__.' '.$updatePath.$value, 7 );
		}
		foreach ( $pFileArr as $value ) {
			$this->copyFiles( $pBackUpPath.$value, $pUpdatePath.$value )
				? $this->Proc->successReceive( 12, $pBackUpPath.$value )
				: $this->Proc->inforReceive( __METHOD__.' '.__LINE__.' '.$pBackUpPath.$value.' '.$pUpdatePath.$value, 5 );	
		}
		$this->Proc->successReceive( 5 );
	}

	//--------------------------------------------------------------------------------------
	//将需要追加的文件写入到追加文件日志中,并将压缩包名称初始化到本类属性中
	public function addFileLogBackUp( $pContent, $pFilePath ) {
		FileBase::writeFile( $pContent, $pFilePath )
			? $this->Proc->successReceive( 4 )
			: $this->Proc->inforReceive( __METHOD__.' '.__LINE__.' '.$pPath, 1 );
		//$this->backUpPackFilePath = $pFilePath;
		return $pFilePath;
	}
	//--------------------------------------------------------------------------------------
	
	//将数据库数据转换成文本 - 临时测试用 - 不包含在本类流程中
	public function updatePackText( $pContent, $pFilePath ) {
		FileBase::writeFile( $pContent, $pFilePath );
	}

	//复制文件
	private function copyFiles( $pUpdateFilePath, $pBackUpFilePath ) {
		return FileBase::copyFile( $pUpdateFilePath, $pBackUpFilePath );
	}
	
	//--------------------------------------------------------------------------------------
	//检测更新后的文件是否存在
	public function scanUpdateFile( $pFilePathArr ) {
		foreach ( $pFilePathArr as $value ) {
			$this->Detection->scanFile( $value )
				? $this->Detection->successReceive( 1, $value )
				: $this->Detection->inforReceive( __METHOD__.' '.__LINE__.' '.$value, 1 );
		}
	}

	//检测追加文件日志是否存在
	public function scanAddFileLog( $pAddLogPath ) {
		$this->Detection->scanFile( $pAddLogPath )
			? $this->Detection->successReceive( 2, $pAddLogPath )
			: $this->Detection->inforReceive( __METHOD__.' '.__LINE__.' '.$pAddLogPath, 2 );
	}

	//检测备份 zip 压缩包是否存在
	public function scanBackUpPath( $pBackUpPath ) {
		$this->Detection->scanFile( $pBackUpPath )
			? $this->Detection->successReceive( 3, $pBackUpPath )
			: $this->Detection->inforReceive( __METHOD__.' '.__LINE__.' '.$pBackUpPath, 3 );
	}
	//--------------------------------------------------------------------------------------

}