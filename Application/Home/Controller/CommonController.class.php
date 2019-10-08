<?php
/**
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Controller;

use Think\Controller;

class CommonController extends Controller 
{

	//输出对话页面
	public function message() {
		$data[] = '成功！';
		$data[] = '软件目前版本为 v1.0 版本';
		$this->assign( 'data', $data );
		$this->display( 'Common/message' );
	}

	//输出错误页面
	public function error() {
		$data[] = '失败！';
		$data[] = '软件目前版本为 v1.0 版本';
		$this->assign( 'data', $data );
		$this->display( 'Common/error' );
	}

	//jquery弹出窗口
	public function out() {
		$this->display( 'Common/out' );
	}

	

}
