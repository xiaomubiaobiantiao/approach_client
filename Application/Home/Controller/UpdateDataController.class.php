<?php
/**
 * 更新/恢复/操作类
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Controller;

use Think\Controller;
use Home\Service\Data\DataService as DataService;
use Home\Supply\Supply;


class UpdateDataController extends Controller
{

	public function __construct() {
		parent::__construct();
		$this->DataService = new DataService( new Supply() );
	}

	// 更新数据库-首页面
	public function index() {

		//加载更新文件
		$typeId = I( 'type_id' );

		$dataList = $this->DataService->getZipList( $typeId );
		
		$this->assign( 'ziplist', $dataList );

		$this->display( 'UpdateData/index' );

	}

	// 解析压缩包内XML文件 并返回数据库类型列表
	public function dataType() {

		$vid = I( 'version_id' );

		$list = $this->DataService->getXmlInfo( $vid );
		dump( $list );
		$this->assign( 'datalist', $list );

		$this->display( 'UpdateData/dataConf' );

	}

	// 测试连接数据库
	public function testLink() {
		$abc = odbc_connect( 'DRIVER={SQL Server};SERVER=;DATABASE=','','' );
		dump( $abc );
		die();
		// new \Home\Model\NewModel('blog','think_','mysql://root:1234@localhost/demo');
		// $abc = M( '','','sqlsrv://sa:123123@localhost/hicisdata_new_test' );
		// $abc = new \Home\Common\Data\SqlserverData();
		// $abc = new \Home\Common\Data\MysqlData();
		// $abc = new \Home\Common\Data\OracleData();
		// dump( $abc );
		// $cc = $abc->connection();
		// dump( $cc );
		// die();
		$returnAjax = $this->DataService->linkData( $this->getJson() );
		dump($returnAjax);
		// $this->ajaxReturn( $returnAjax );
	}

	// 测试连接多个数据库
	public function testLinkAll() {

		$this->DataService->linkMoreData( $this->getJson() );

	}

	// 接收数据库类型参数并检测对应数据库连接
	public function detectionDatabaseConnect() {

		$databaseType = I( 'database' );

		$data = array( 'Sqlserver', 'Mysql' );

		$this->dataService->connectDatabase( $data );

	}

	// 检测数据库库名是否存在
	public function detectionDatabaseName() {

	}

	// 测试
	public function test( DataService $DataService ) {
		$DataService->test();

	}

	public function getJson() {

		return file_get_contents( 'php://input' );
		
	}

	public function paramValidat() {

	}

}