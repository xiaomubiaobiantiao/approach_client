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
		
		$this->assign( 'datalist', $dataList );

		$this->display( 'UpdateData/index' );

	}

	// 解析压缩包内XML文件 并返回数据库类型列表
	public function dataType() {

		$vid = I( 'version_id' );

		$this->DataService->getXmlInfo( $vid );

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


}