<?php
/**
 * 日志接口
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Supply\Log;

interface Log
{
	//失败信息
	public function inforReceive ();
	
	//成功信息
	public function successReceive ();

}