<?php
/**
 * 继承文件检测类 - 文件检测类继承 log 日志类
 * 只服务于 PackService
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Service\Pack;

use Home\Supply\Detection\Detection;

class PackDetectionLogService extends Detection
{

	//失败结果集
	public $errorInfo = array(
			1 => 'Download file ',				//下载文件失败
			2 => 'Delete file ',				//删除文件失败
			3 => 'File does not exist ',		//文件不存在
			4 => 'Download status update ',		//下载状态更新失败
			5 => 'Set status ',					//设置压缩包下载状态失败
			6 => 'Download file '				//下载压缩包失败
	);

	//成功结果集
	public $successInfo = array(
			1 => 'Download file complete! ',			//下载文件成功
			2 => 'Delete file complete! ',				//删除文件成功
			3 => 'Download status update complete! ',	//删除文件成功
			4 => 'Set status complete! ',				//设置压缩包下载状态成功
			5 => 'Download file complete! '				//下载压缩包成功
	);

	//查看 bool值 结果
	public function checkBoolValue( $pBoolValue ) {
		$pBoolValue == 1 ? $value = true : $value = false;
		return $value;
	}

	/**
     * 重写错误信息 - 并将错误信息写入本地错误日志
     * [inforReceive description]
     * @param  string $pFunctionName [class and functionName]
     * @param  int $pParam           [0,1,2...]
     * @return [string]              [error: info]
     */
	public function inforReceive ( $pFunctionName = '', $pParam = '' ) {
		$message = parent::inforReceive( $pFunctionName, $pParam );
		echo $message;
		die();
		//$this->writeLog( $message, LOCAL_LOG );
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
		echo $message;
		//$this->writeLog( $message, LOCAL_LOG );
	}


}