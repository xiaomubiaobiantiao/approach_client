<?php
/**
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Service\Restore;

use Home\Service\Restore\RestoreParentService as Process;
use Home\Service\Restore\RestoreFileService as GetPath;
use Home\Common\Utility\PclZipController as PclZip;
//use Home\Common\Utility\FileBaseUtility as FileBase;

class RestoreService extends Process
{

	public function __construct() {
		parent::__construct();
	}

	/* --------------------------------------------------------------------------- */
	/* ----- 文本数据操作 -------------------------------------------------------- */
	/* --------------------------------------------------------------------------- */

	//获取备份文件列表
	public function getBackUpZipList() {
		if ( is_dir( BACKUP_PATH )) {
			//return FileBase::checkAllFile( BACKUP_PATH );
			$backUpList = $this->checkDirFile( BACKUP_PATH );
			foreach ( $backUpList as $key=>$value ) {
				$str = explode( '-', basename( $value ));
				$str = explode( '_', $str[1] );
				$mTime[] = $str[0];
			}
			$fileMtime = $this->orderByData( $mTime );
			foreach ( $backUpList as $key=>$value ) {
				if ( strstr( $value, $fileMtime[0]))
					return $value;
			}
		}
			
	}

	/* --------------------------------------------------------------------------- */

	//更新压缩包的流程
	public function restoreBackUpProcess( $pBackUpFile ) {
		
		//初始化程序所需目录结构和日志文件
		$this->initializeFile();

		//根据ID解压文件到默认文件夹,自带创建目录的功能
		$this->unZip( $pBackUpFile, UNPACK_TMP_PATH );

		//检测压缩包文件 和 项目的文件
		$PathObj = new GetPath( array( UNPACK_TMP_PATH, UPDATE_PATH ));
		// dump($PathObj->fileOperation);
		// dump($PathObj->lastResult);
		// die( 'aaa');
		//有需要备份的文件就执行以下操作
		if ( false == empty( $PathObj->lastResult['mustBackUpFileList'] )) {

			//拷贝文件到备份临时目录
			$tData = $this->copyBackUpFile( 
				$PathObj->lastResult['mustBackUpFilePathList'],
				$PathObj->lastResult['mustBackUpFileList'],
				UPDATE_PATH,
				BACKUP_TMP_PATH
			);

			//如果需要备份的文件有不存在的,就将它从需要压缩的备份列表里面去除
			if ( false == empty( $tData ))
				$PathObj->lastResult['mustBackUpFileList']=array_diff( $PathObj->lastResult['mustBackUpFileList'], $tData);

			//创建备份文件日志 将需要备份的文件路径列表写入备份日志
			$backUpLogFilePath = $this->createBackUpFileLog(
				$this->matchZipFileRootPath( UPDATE_PATH, $PathObj->lastResult['mustBackUpFileList'] ),
				BACKUP_TMP_PATH . date('Y_m_d').'-'.time().'-back.log'
			);
			// dump( $backUpLogFilePath );
			//将备份日志文件路径存储到 $PathObj 类 的 backUpLogFilePath
			$PathObj->setBackUpLogPath( $backUpLogFilePath );
			//将记录备份文件列表的 日志的路径 去掉临时路径信息 back.log
			$tFilePath = str_replace( BACKUP_TMP_PATH, '', $PathObj->backUpLogFilePath );
			//将替换日志路径写入到备份文件列表
			$PathObj->pushBackUpList( $tFilePath );

		}
		
		//有需要追加的文件就就执行以下操作
		if ( false == empty( $PathObj->lastResult['addFileList'] )) {

			//创建追加文件日志 将需要追加的文件路径列表写入追加日志
			$addLogFilePath = $this->createAddFileLog(
				$this->matchZipFileRootPath( UPDATE_PATH, $PathObj->lastResult['addFileList'] ),
				BACKUP_TMP_PATH . date('Y_m_d').'-'.time().'-add.log'
			);

			//将追加日志文件路径存储到 $PathObj 类 的 addLogFilePath
			$PathObj->setAddLogPath( $addLogFilePath );
			//将记录追加文件列表的 日志的路径 去掉临时路径信息 add.log
			$tFilePath = str_replace( BACKUP_TMP_PATH, '', $PathObj->addLogFilePath );
			//将临时目录的日志路径写入到备份文件列表
			$PathObj->pushBackUpList( $tFilePath );
			
			//为写入文件争取停顿时间1秒
			$this->sleepOperation( 1 );

		}

		//有需要删除的文件就执行以下操作
		if ( false == empty( $PathObj->lastResult['deleteFileList'] )) {
			
			//删除项目文件流程
			$tData = $this->deleteProjectFile( UPDATE_PATH, $PathObj->lastResult['deleteFileList'] );

			//返回值不为空时 - 去除删除文件列表里面与返回值相同的文件
			if ( false == empty( $tData ))
				$PathObj->lastResult['deleteFileList']=array_diff( $PathObj->lastResult['deleteFileList'], $tData);

			//创建删除文件日志 将需要追加的文件路径列表写入删除日志
			$tDelLogFilePath = $this->createDelFileLog(
				$this->matchZipFileRootPath( UPDATE_PATH, $PathObj->lastResult['deleteFileList'] ),
				BACKUP_TMP_PATH . date('Y_m_d').'-'.time().'-del.log'
			);

			//将删除日志文件路径存储到 $PathObj 类 的 delLogFilePath
			$PathObj->setDelLogPath( $tDelLogFilePath );
			//将记录删除文件列表的 日志的路径 去掉临时路径信息 *-del.log
			$tFilePath = str_replace( BACKUP_TMP_PATH, '', $PathObj->delLogFilePath );
			//将临时目录的日志路径写入到备份文件列表
			$PathObj->pushBackUpList( $tFilePath );

		}

		//将备份文件打包 并命名 备份文件包括( 替换的文件,替换文件的日志,追加文件的日志, 删除文件的日志 )
		if ( false == empty( $PathObj->lastResult['mustBackUpFileList'] )) {
			
			$zipPath = $this->addZip( 
				RESTORE_BACKUP_PATH.date('Y_m_d').'-'.time().'_r.zip',
				$this->matchZipFileRootPath( BACKUP_TMP_PATH, $PathObj->lastResult['mustBackUpFileList'] )
			);

			//将备份文件路径存储到 $PathObj 类 的 backUpPackFilePath
			$PathObj->setBackUpZipPath( $zipPath );
		}
		
		//开始还原文件 - 添加全部日志 - 添加还原日志
		$this->copyUpdateFile(
			$PathObj->lastResult['backUpFilePathList'],
			$PathObj->lastResult['backUpFileList'],
			UPDATE_PATH,
			UNPACK_TMP_PATH
		);

		//更新或创建版本信息
		$this->updateVersion( VERSION_PATH, OLD_VERSION_PATH );
		
		/*-------------------------------------------------------------------------------------*/
		/*----- 检测系统 - 检测所有操作是否成功 -----------------------------------------------*/
		/*-------------------------------------------------------------------------------------*/

		//备份文件列表存在 则检测备份日志是否创建成功
		if ( isset( $backUpLogFilePath ))
			$this->scanBackUpLog( $PathObj->backUpLogFilePath );

		//追加文件列表存在 则检测追加日志是否创建成功 - 如果追加列表为空则不检测
		if (  isset( $addLogFilePath ))
			$this->scanAddFileLog( $PathObj->addLogFilePath );

		//备份文件列表存在 则检测需要备份的文件压缩包是否创建成功
		if ( isset( $zipPath ))
			$this->scanBackUpZip( $PathObj->backUpPackFilePath );

		//删除文件列表存在 则检测需要删除的文件日志是否创建成功 并查看文件是否删除成功
		if ( isset( $tDelLogFilePath )) {
			$this->scanDelFileLog( $PathObj->delLogFilePath );
			//检测需要删除的文件是否存在
			$tDelFileList = $this->matchZipFileRootPath( UPDATE_PATH, $PathObj->lastResult['deleteFileList'] );
			//检测被删除的的文件是否存在
			$this->scanDelFile( $tAllFileList );
		}

		//将全部更新文件加上绝对路径信息
		$tAllFileList = $this->matchZipFileRootPath( UPDATE_PATH, $PathObj->lastResult['backUpFileList'] );
		//检测更新后的文件是否存在
		$this->scanUpdateFile( $tAllFileList );

		//查看日志是否更新成功
		$this->scanLog( LOCAL_LOG );
		
		//删除临时目录和备份目录里的所有文件
		$this->deleteTmpFile( array( BACKUP_TMP_PATH, UNPACK_TMP_PATH ));

		//搜索垃圾回收是否清理完成
		$this->scanRecycle( array( BACKUP_TMP_PATH, UNPACK_TMP_PATH ));

		//查看版本信息是否创建或更新完成
		$this->scanVersion( OLD_VERSION_PATH );
		
		/*-------------------------------------------------------------------------------------*/

		//添加一条操作信息到记录日志
		$this->recordInfo( LOCAL_RESTORE_RECORD );

	}

	//获取旧的版本信息
	public function getVersion() {
		if( false == $this->checkFile( OLD_VERSION_PATH ))
			return VERSION_DEFAULT_INFO;
		
		$versionInfo = $this->readFile( OLD_VERSION_PATH );
		if ( empty( $versionInfo ))
	 		return VERSION_DEFAULT_INFO;

	 	return $versionInfo;
	}

	//将路径拼接到数组中的全部路径的前面
	private function matchZipFileRootPath( $pPath, $pArr ) {
		foreach ( $pArr as $value )
			$data[] = $pPath.$value;
		return $data;
	}

	//睡眠 - 暂未用
	private function sleepOperation( $pLong = 1 ) {
		sleep( $pLong );
	}

	//初始化程序所需目录结构和日志文件
	private function initializeFile() {
		//初始化程序所需目录结构
		$this->initializeDir(
			array( 
				BACKUP_PATH, BACKUP_TMP_PATH, UNPACK_TMP_PATH, RESTORE_BACKUP_PATH,
				dirname( LOCAL_LOG ), 
				dirname( LOCAL_UPDATE_ERROR ), 
				dirname( LOCAL_RESTORE_ERROR )
			)
		);

		//初始化日志文件
		$this->initializeLog(
			array( LOCAL_LOG, LOCAL_UPDATE_ERROR, LOCAL_UPDATE_RECORD, LOCAL_RESTORE_ERROR, LOCAL_RESTORE_RECORD )
		);
	}

	//按时间排序数据 - 默认从大到小
	private function orderByData( $pDataArr, $pStr = '>'  ) {
		$data = $pDataArr;
		$count = count( $data );
		for ( $i=0; $i<$count; $i++ ) {
			for ( $j=0; $j<$i; $j++ ) {
				if ( $pStr == '>' ) {
					if ( $data[$i] > $data[$j] ) {
						$tmp = $data[$i];
						$data[$i] = $data[$j];
						$data[$j] = $tmp;
					}
				} else {
					if ( $data[$i] < $data[$j] ) {
						$tmp = $data[$i];
						$data[$i] = $data[$j];
						$data[$j] = $tmp;
					}
				}
			}
		}
		return $data;
	}

}