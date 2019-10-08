<?php
/**
 * 文件检测的日志信息
 * 继承文件检测类 - 文件检测类继承 log 日志类
 * 只服务于 RestoreService
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Service\Restore;

use Home\Supply\Detection\Detection;

class RestoreDetectionLogService extends Detection
{

	protected $errorInfo = array(

			1 => 'restore Search a update file ',			//检测一个更新后的文件失败
			2 => 'restore Search add log file ',			//检测追加日志文件失败
			3 => 'restore Search backup zip ',				//检测备份压缩包失败
			4 => 'restore Search version ',					//暂时未用
			5 => 'restore Search download file ',			//暂时未用
			6 => 'restore Search delete file ',				//暂时未用
			7 => 'restore Search backup log files ',		//检测备份文件日志失败
			8 => 'restore Search remove a temp file ',		//检测一个临时文件是否删除失败
			9 => 'restore Search version update',			//检测版本信息是否更新失败
			10 => 'restore Search operation log update',	//检测记录全部操作的日志记录是否更新失败
			11 => 'restore Search del log ',				//检测记录删除信息的日志失败
			12 => 'restore Search a del file '				//检测删除后的一个文件失败
	);

	protected $successInfo = array(

			1 => 'restore Search a update file ',					//检测一个更新后的文件成功
			2 => 'restore Search add log files ',					//检测追加日志文件成功
			3 => 'restore Search backup zip complete! ',			//检测备份压缩包成功
			4 => 'restore Search version complete! ',				//暂时未用
			5 => 'restore Search download file complete! ',			//暂时未用
			6 => 'restore Search delete file complete! ',			//暂时未用
			7 => 'restore Search backup log files complete! ',		//检测备份文件日志成功
			8 => 'restore Search remove temp file ',				//检测一个临时文件是否删除成功
			9 => 'restore Search version update complete! ',		//检测版本信息更新成功
			10 => 'restore Search operation log update complete! ',	//检测记录全部操作的日志记录更新成功
			11 => 'restore Search del log complete! ',				//检测记录删除信息的日志成功
			12 => 'restore Search a del file '						//检测删除后的一个文件成功
	);

	 /**
     * 重写错误信息 - 并将错误信息写入错误日志 同时写入两个日志( LOCAL_LOG, LOCAL_UPDATE_ERROR )
     * [inforReceive description]
     * @param  string $pFunctionName [class and functionName]
     * @param  int $pParam           [0,1,2...]
     * @return [string]              [error: info]
     */
	public function inforReceive ( $pFunctionName = '', $pParam = '' ) {
		$message = parent::inforReceive( $pFunctionName, $pParam );
		$this->writeLog( $message, LOCAL_LOG );
		$this->writeLog( $message, LOCAL_RESTORE_ERROR );
	}

	/**
     * 重写正确信息 - 并将正确信息写入总日志 LOCAL_LOG
     * [successReceive description]
     * @param  string $pParam [class and functionName]
     * @param  string $pStr   [0,1,2...]
     * @return [string]       [success: info]
     */
	public function successReceive( $pParam = '', $pStr = '' ) {
		$message = parent::successReceive( $pParam, $pStr );
		$this->writeLog( $message, LOCAL_LOG );
	}

	

	

	

}