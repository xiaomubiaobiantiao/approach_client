<?php
/**
 * 文件检测类
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Supply\Detection;

use Home\Supply\Log\Logs;

class Detection extends Logs
{


	protected $errorInfo = array();

	protected $successInfo = array();

	//检测文件
	public function scanFile( $pFilePath ) {
		return is_file( $pFilePath );
	}
	
	//检测目录
	public function scanDir( $pFilePath ) {
		return is_dir( $pFilePath );
	}




}