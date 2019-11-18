<?php
/**
 * 日志查看类
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */

namespace Home\Controller;

use Think\Controller;
use Home\Common\Utility\FileBaseUtility as FileBase;

class LogsController extends Controller
{

	// 获取日志
	public function index() {

		$logs = FileBase::getFileLastLines( LOCAL_LOG, 100 );
		$this->assign( 'logs', $logs );
		$this->display( 'Logs/index' );
		
	}

}