<?php
/**
 * 数据库连接类
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Common\Data;
use Home\Interfaces\Database;

class SqlserverData implements Database
{

	// // 初始化数据库参数
	// public $server = '';
	// public $user = '';
	// public $pass = '';
	// public $database = '';
	// public $connect = '';

	// // 数据库连接
	// public $dataConnect = '';

	// // 初始化 - 备用
	// public function __construct( array $pParams ) {
	// 	$this->setParam( $pParams );
	// }

	// 设置数据库参数
	public function setParam( array $pParams ) {
		// dump( $pParams );
		$this->server = $pParams['server'];
		$this->user = $pParams['user'];
		$this->pass = $pParams['pass'];
		$this->database = $pParams['database'];
		$this->connect = 'DRIVER={SQL Server};SERVER='.$dbconf['server'].';DATABASE='.$dbconf['database'];
	}

	// 连接数据库
	public function connection() {
		$this->dataConnect = odbc_connect( $this->connect, $this->user, $this->pass );
		return $this->dataConnect;
	}

	// // 执行Sql语句
	// public function exec( $pSql ) {
	// 	return odbc_exec( $this->dataConnect, $pSql );
	// }
	
	// // 循环遍历内容
	// public function fetchConnect( $pResources ) {
	// 	while( $row = odbc_fetch_array( $pResources ))
	// 		$result[] = $row;
	// 	return $result;
	// }

	// // 查看总行数
	// public function numRows( $pResources ) {
	// 	return odbc_num_rows( $pResources );
	// }

	//
	




}
