<?php
/**
 * 文件操作日志信息
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Service\Update;

use Home\Supply\Log\Logs;

class UpdateLogService extends Logs
{

	public $errorInfo = array(
			1 => 'Create add log file',			//创建追加日志文件失败
			2 => 'Open dir resources ',			//打开目录资源失败
			3 => 'Create zip file ',			//创建压缩文件失败
			4 => 'Is dir ', 					//不是目录 失败
			5 => 'Copy a update file ',			//复制更新文件失败
			6 => 'Delete tmp dir ',				//删除临时目录失败
			7 => 'Create dir update ',			//创建更新目录失败
			8 => 'Copy a backup file ',			//复制备份文件失败
			9 => 'Search a update file ',		//搜索一个更新文件失败 - 目前未用
			10 => 'Search backup log ',			//搜索备份日志失败 - 目前未用
			11 => 'Create Backup log ',			//创建备份日志失败
			12 => 'Version update ',			//版本信息更新失败
			15 => 'Initialize a log file ',		//初始化一个日志文件失败
			16 => 'Create del log file ',		//创建删除文件日志失败
			17 => 'Del a project file ' ,		//删除项目文件失败 - 需要更新的项目
			18 => 'Create default version info '//创建默认版本信息失败


	);

	public $successInfo = array(
			1 => 'Create zip complete! ',					//创建压缩文件成功
			2 => 'Unzip complete! ',						//解压缩文件成功
			3 => 'Delete tmp dir complete! ',				//删除临时目录成功
			4 => 'Create add file log complete! ',			//创建更新时追加文件的日志成功
			5 => 'Copy update file complete! ',				//复制更新文件成功
			6 => 'Copy backup file complete! ',				//复制备份文件成功
			7 => 'Search a update file ',					//搜索一个更新文件成功-目前未用
			8 => 'Search backup log complete! ',			//搜索备份日志成功 - 目前未用
			9 => 'Create a backup file path ',				//创建一个备份文件目录成功
			10 => 'Copy a backup file ',					//复制一个备份文件成功
			11 => 'Create a update file path ',				//创建一个更新文件目录成功
			12 => 'Copy a update file ',					//复制一个备份文件日志成功
			15 => 'Create Backup file log complete! ',		//创建备份文件日志成功
			16 => 'Version update complete! ',				//版本信息更新成功
			17 => 'Initialize log complete! ',				//初始化一个日志文件成功
			18 => 'Create del file log complete! ',			//创建删除文件日志成功
			19 => 'Del a project file ',					//删除项目中的一个文件成功
			20 => 'Dont find Del del-log a project file ',	//需要删除的项目文件不存在 - 也成功
			21 => 'Create default version info complete! '	//创建默认版本信息成功

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
		$this->writeLog( $message, LOCAL_UPDATE_ERROR );
		$this->redirect('Common/error');
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