<?php
/**
 * 文件操作日志信息
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Service\Restore;

use Home\Supply\Log\Logs;

class RestoreLogService extends Logs
{

	public $errorInfo = array(
		
			1 => 'restore Create add log file',			//创建追加日志文件失败
			2 => 'restore Open dir resources ',			//打开目录资源失败
			3 => 'restore Create zip file ',			//创建压缩文件失败
			4 => 'restore Is dir ', 					//不是目录 失败
			5 => 'restore Copy a update file ',			//复制更新文件失败
			6 => 'restore Delete tmp dir ',				//删除临时目录失败
			7 => 'restore Create dir update ',			//创建更新目录失败
			8 => 'restore Copy a backup file ',			//复制备份文件失败
			9 => 'restore Search a update file ',		//搜索一个更新文件失败 - 目前未用
			10 => 'restore Search backup log ',			//搜索备份日志失败 - 目前未用
			11 => 'restore Create Backup log ',			//创建备份日志失败
			12 => 'restore Version update ',			//版本信息更新失败
			15 => 'restore Initialize a log file ',		//初始化一个日志文件失败
			16 => 'restore Create del log file ',		//创建删除文件日志失败
			17 => 'restore Del a project file '			//删除项目文件失败 - 需要更新的项目

	);

	public $successInfo = array(

			1 => 'restore Create zip complete! ',					//创建压缩文件成功
			2 => 'restore Unzip complete! ',						//解压缩文件成功
			3 => 'restore Delete tmp dir complete! ',				//删除临时目录成功
			4 => 'restore Create add file log complete! ',			//创建更新时追加文件的日志成功
			5 => 'restore Copy update file complete! ',				//复制更新文件成功
			6 => 'restore Copy backup file complete! ',				//复制备份文件成功
			7 => 'restore Search a update file ',					//搜索一个更新文件成功 - 目前未用
			8 => 'restore Search backup log complete! ',			//搜索备份日志成功 - 暂时未用
			9 => 'restore Create a backup file path ',				//创建一个备份文件目录成功
			10 => 'restore Copy a backup file ',					//复制一个备份文件成功
			11 => 'restore Create a update file path ',				//创建一个更新文件目录成功
			12 => 'restore Copy a update file ',					//复制一个备份文件日志成功
			15 => 'restore Create Backup file log complete! ',		//创建备份文件日志成功
			16 => 'restore Version update complete! ',				//版本信息更新成功
			17 => 'restore Initialize log complete! ',				//初始化一个日志文件成功
			18 => 'restore Create del file log complete! ',			//创建删除文件日志成功
			19 => 'restore Del a project file ',					//删除项目中的一个文件成功
			20 => 'restore Dont find Del del-log a project file '	//需要删除的项目文件不存在 - 也成功

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

	//记录本次操作信息到日志 - 自定义日志
	public function customLogFile( $pLogPath ) {
		$this->writeLog( $this->getUpdateInfo(), $pLogPath );
	}

	//每更新一次,记录一次相关信息,如时间,地点,操作者,所属组等 - 目前只有时间
	public function getUpdateInfo() {
		return '['.date( 'Y-m-d h:i:s').'] '.' username: Yang'.' <|> '.'group: 1';
	}

	
	
}