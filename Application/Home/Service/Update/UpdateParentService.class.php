<?php
/**
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Service\Update;

use Home\Common\Utility\PclZipController as Zip;
use Home\Common\Utility\FileBaseUtility as FileBase;
use Home\Service\Update\UpdateDetectionLogService as Detection;
use Home\Service\Update\UpdateLogService as ProcessLog;

class UpdateParentService
{

	public function __construct() {
		$this->Proc = new ProcessLog();
		$this->Detection = new Detection();
	}

	//查看版本信息
	protected function checkFile( $pVersionPath ) {
		return FileBase::checkFile( $pVersionPath );
	}

	//下载文件 - 目前未用 将来可能也不会用
	protected function downFile() {
		return FileBase::down();
	}

	//记录本次操作信息到记录日志 LOCAL_UPDATE_RECORD
	protected function recordInfo( $pLogPath ) {
		$this->Proc->customLogFile( $pLogPath );
	}

	//读取文件
	protected function readFile( $pFile ) {
		return FileBase::readFile( $pFile );
	}

	//如果版本信息不存在,创建版本信息
	protected function createVersion( $pContent, $pVersionFile ) {
		//创建版本信息路径
		FileBase::createDir( dirname( $pVersionFile ));
		//创建初始版本信息文件
		FileBase::writeFile( $pContent, $pVersionFile )
			? $this->Proc->successReceive( 21, $pVersionFile )
			: $this->Proc->inforReceive(  __METHOD__.' '.__LINE__.' '.$pVersionFile, 18 );
	}

	//替换软件版本信息文件
	protected function updateVersion( $pFilePath, $pNewPath ) {
		//拷贝文件到版本信息路径
		FileBase::copyFile( $pFilePath, $pNewPath )
			? $this->Proc->successReceive( 16, $pFilePath.'|'.$pNewPath )
			: $this->Proc->inforReceive(  __METHOD__.' '.__LINE__.' '.$pFilePath.'|'.$pNewPath, 12 );
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

	// 检查更新文件的目录是否存在
	// public function 

	//初始化程序运行需要的目录
	public function initializeDir( $pDirArr ) {
		foreach ( $pDirArr as $value ) {
			if ( false == is_dir( $value ))
				FileBase::createDir( $value );
		}
	}

	//初始化日志文件
	public function initializeLog( $pLogArr ) {
		foreach ( $pLogArr as $value ) {
			if ( false == is_file( $value )) {
				FileBase::createFile( $value )
					? $this->Proc->successReceive( 17, $value )
					: $this->Proc->inforReceive( __METHOD__.' '.__LINE__.' '.$value, 15 );
			}
		}
	}

	//删除目录下的所有文件
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
			if ( is_file( $pUpdatePath.$value )) {
				FileBase::copyFile( $pUpdatePath.$value, $pBackUpPath.$value )
					? $this->Proc->successReceive( 10, $pBackUpPath.$value )
					: $this->Proc->inforReceive( __METHOD__.' '.__LINE__.' '.$pUpdatePath.$value.' '.$pBackUpPath.$value.' ', 8 );
			} else {
				$data[] = $value;
			}
		}
		$this->Proc->successReceive( 6 );
		return $data;
	}

	//copy更新文件操作流程 先循环创建目录,再循环创建文件
	public function copyUpdateFile( $pFilePathArr, $pFileArr, $pUpdatePath, $pBackUpPath ) {
		foreach ( $pFilePathArr as $value ) {
			FileBase::createDir( $pUpdatePath.$value );
			is_dir( $pUpdatePath.$value )
				? $this->Proc->successReceive( 11, $pBackUpPath.$value )
				: $this->Proc->inforReceive( __METHOD__.' '.__LINE__.' '.$pUpdatePath.$value, 7 );
		}
		foreach ( $pFileArr as $value ) {
			FileBase::copyFile( $pBackUpPath.$value, $pUpdatePath.$value )
				? $this->Proc->successReceive( 12, $pUpdatePath.$value )
				: $this->Proc->inforReceive( __METHOD__.' '.__LINE__.' '.$pUpdatePath.$value.' '.$pUpdatePath.$value, 5 );
		}
		$this->Proc->successReceive( 5 );
	}

	//delete 删除项目文件流程
	public function deleteProjectFile( $pPath, $pPathArr ) {
		foreach ( $pPathArr as $value ) {
			if ( is_file( $pPath.$value )) {
				FileBase::deleteFile( $pPath.$value )
					? $this->Proc->successReceive( 19, $pPath.$value )
					: $this->Proc->inforReceive( __METHOD__.' '.__LINE__.' '.$pPath.$value, 17 );
			} else {
				//如果需要删除的文件不存在,也报成功 - 并记录返回相应不存在的文件
				$this->Proc->successReceive( 20, $pPath.$value );
				$data[] = $value;
			}
		}
		return $data;
	}

	//--------------------------------------------------------------------------------------
	//将需要追加的文件列表写入到追加文件日志中
	public function createAddFileLog( $pContent, $pAddLogFilePath ) {
		FileBase::writeFile( $pContent, $pAddLogFilePath )
			? $this->Proc->successReceive( 4 )
			: $this->Proc->inforReceive( __METHOD__.' '.__LINE__.' '.$pAddLogFilePath, 1 );
		return $pAddLogFilePath;
	}

	//将需要替换的文件列表写入到备份文件日志中
	public function createBackUpFileLog( $pContent, $pBackUpLogFilePath ) {
		FileBase::writeFile( $pContent, $pBackUpLogFilePath )
			? $this->Proc->successReceive( 15 )
			: $this->Proc->inforReceive( __METHOD__.' '.__LINE__.' '.$pBackUpLogFilePath, 11 );
		return $pBackUpLogFilePath;
	}

	//将需要删除的文件列表写入到删除文件日志中 - 成功失败 日志说明未写
	public function createDelFileLog( $pContent, $pDelLogFilePath ) {
		FileBase::writeFile( $pContent, $pDelLogFilePath )
			? $this->Proc->successReceive( 18 )
			: $this->Proc->inforReceive( __METHOD__.' '.__LINE__.' '.$pDelLogFilePath, 16 );
		return $pDelLogFilePath;
	}
	
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

	//检测备份文件日志是否存在
	public function scanBackUpLog( $pBackUpLogPath ) {
		$this->Detection->scanFile( $pBackUpLogPath )
			? $this->Detection->successReceive( 7, $pBackUpLogPath )
			: $this->Detection->inforReceive( __METHOD__.' '.__LINE__.' '.$pBackUpLogPath, 7 );
	}

	//检测备份 zip 压缩包是否存在
	public function scanBackUpZip( $pBackUpZipPath ) {
		$this->Detection->scanFile( $pBackUpZipPath )
			? $this->Detection->successReceive( 3, $pBackUpZipPath )
			: $this->Detection->inforReceive( __METHOD__.' '.__LINE__.' '.$pBackUpZipPath, 3 );
	}

	//检测删除后的文件是否存在
	public function scanDelFile( $pFilePathArr ) {
		foreach ( $pFilePathArr as $value ) {
			false == $this->Detection->scanFile( $value )
				? $this->Detection->successReceive( 12, $value )
				: $this->Detection->inforReceive( __METHOD__.' '.__LINE__.' '.$value, 12 );
		}
	}

	//检测更新时记录删除文件的日志文件是否存在
	public function scanDelFileLog( $pDelLogPath ) {
		$this->Detection->scanFile( $pDelLogPath )
			? $this->Detection->successReceive( 11, $pDelLogPath )
			: $this->Detection->inforReceive( __METHOD__.' '.__LINE__.' '.$pDelLogPath, 11 );
	}

	//检测垃圾是否清理完成 - 不需要的临时文件
	public function scanRecycle( $pPathArr ) {
		foreach ( $pPathArr as $value ) {
			false == $this->Detection->scanDir( $value )
				? $this->Detection->successReceive( 8, $value )
				: $this->Detection->inforReceive( __METHOD__.' '.__LINE__.' '.$value, 8 );
		}
	}

	//检测记录全部操作信息的日志是否更新成功
	public function scanLog( $pLogPath ) {
		$mTime = FileBase::scanFileInfo( $pLogPath );
		( time()-$mTime < 60*2 )
			? $this->Detection->successReceive( 10, date("Y-m-d H:i:s",$mTime).'|'.date("Y-m-d H:i:s") )
			: $this->Detection->inforReceive( __METHOD__.' '.__LINE__.' '.date("Y-m-d H:i:s",$mTime).'|'.date("Y-m-d H:i:s"), 10 );
	}

	//检测版本信息是否更新完成
	public function scanVersion( $pVersionPath ) {
		$mTime = FileBase::scanFileInfo( $pVersionPath );
		( time()-$mTime < 60*2 )
			? $this->Detection->successReceive( 9, date("Y-m-d H:i:s",$mTime).'|'.date("Y-m-d H:i:s") )
			: $this->Detection->inforReceive( __METHOD__.' '.__LINE__.' '.date("Y-m-d H:i:s",$mTime).'|'.date("Y-m-d H:i:s"), 9 );
	}

	//检测更新文件的目录是否存在, 目录名称默认为 zz_files - 暂时未用
	public function scanFileDir( $pFileDir ) {
		FileBase::checkDir( $pFileDir )
			? $this->Detection->successReceive()
			: $this->Detection->inforReceive(  );
	}
	//--------------------------------------------------------------------------------------

}