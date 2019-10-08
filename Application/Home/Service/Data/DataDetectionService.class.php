<?php
/**
 * 数据库操作类
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Service\Data;

class DataService
{

	//数据库参数
	public function connectParam() {

		$conf['server'] 	= '.';
		$conf['user'] 		= 'sa';
		$conf['pass'] 		= '123123';
		$conf['database'] 	= 'contract';
		$conf['connect'] 	= 'DRIVER={SQL Server};SERVER='.$conf['server'].';DATABASE='.$conf['database'];

		return $conf;

	}




}