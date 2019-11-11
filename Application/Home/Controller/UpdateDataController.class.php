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

		$this->assign( 'datalist', $list );

		$this->display( 'UpdateData/dataConf' );

	}

	public function test() {
		$test = new \Home\Common\Utility\GetDataToXmlUtility();
		$test->linkGetData();
	}

	// 测试连接数据库
	public function testLink() {

		$returnAjax = $this->DataService->linkData( $this->DataService->getJson() );
		// dump($returnAjax);
		$this->ajaxReturn( $returnAjax );

	}

	// 测试连接多个数据库
	public function testLinkAll() {

		$returnAjax = $this->DataService->linkMoreData( $this->DataService->getJson() );
		// dump( $returnAjax );
		$this->ajaxReturn( $returnAjax );

	}

	// 更新数据库预览
	public function dataPreview() {

		$test = $this->DataService->getJson();
		$returnAjax = $this->DataService->allPreview( $test );
		// dump($returnAjax);

	}

	




}