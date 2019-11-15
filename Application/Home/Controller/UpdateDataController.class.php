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

	// 接收预览JSON数据并转换为数组传送给页面 - 以便thinkphp用标签配置
	public function priview() {

		$data = $this->DataService->postJson();
		$this->assign( 'list', $data );
		$this->display( 'UpdateData/priview' );

	}

	// 测试连接数据库
	public function testLink() {

		$returnAjax = $this->DataService->linkData( $this->DataService->ajaxJson() );
		// dump($returnAjax);
		$this->ajaxReturn( $returnAjax );

	}

	// 测试连接多个数据库
	public function testLinkAll() {

		$returnAjax = $this->DataService->linkMoreData( $this->DataService->ajaxJson() );
		// dump( $returnAjax );
		$this->ajaxReturn( $returnAjax );

	}

	// 接收数据库配置信息和更新包id - 返回预览数据
	public function dataPreview() {

		$test = $this->DataService->ajaxJson();
		$returnAjax = $this->DataService->allPreview( $test );
		$return['code'] = 201;
    	$return['data'] = $returnAjax;
		$this->ajaxReturn( $return );

	}

	// 更新 xml 数据到相应数据库
	public function updateXmlToData() {
		
		$data = $this->DataService->postJson();
		$result = $this->DataService->updateDataExec( $data );
		if ( empty($result )) {
			echo '更成完成！';
		} else {
			echo '更新失败：下列字段未更新成功！';
			dump( $result );
		}

	}

	// 获取数据库中数据信息并生成 xml 文件 - 开发用
	public function getDataXml() {

		$test = new \Home\Common\Utility\GetDataToXmlUtility();
		$test->linkGetData();

	}



}