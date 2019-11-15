<?php
/**
 * 文件操作日志信息
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Service\Data;

use Home\Supply\Log\Logs;

class DataLogService extends Logs
{

	public $errorInfo = array(

			1 => 'add data field ',				//添加字段失败
			2 => 'search data field ',			//查询字段失败
		
	);

	public $successInfo = array(

			1 => 'add data field complete! ',				//添加字段成功
			2 => 'search data field complete! ',			//查询字段成功

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
		$this->writeLog( $message, DATABASE_LOG_PATH );
		$this->writeLog( $message, DATABASE_ERROR_LOG_PATH );
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
		$this->writeLog( $message, DATABASE_LOG_PATH );
	}

	//记录本次操作信息到日志 - 自定义日志
	public function customLogFile( $pLogPath ) {
		$this->writeLog( $this->getUpdateInfo(), $pLogPath );
	}

	//每更新一次,记录一次相关信息,如时间,地点,操作者,所属组等 - 目前只有时间 - 暂时未用
	public function getUpdateInfo() {
		return '['.date( 'Y-m-d h:i:s').'] '.' username: Zhang'.' <|> '.'group: 1';
	}

	
	
}