<?php
/**
 * 更新包管理
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Controller;

use Think\Controller;
use Home\Service\Pack\PackService;

class PackController extends Controller  //\Home\Controller\IndexController 获得权限用
{

	private $packService; //压缩包操作服务类

	public function __construct() {
		//为了加载权限管理
		parent::__construct();
		//生成压缩包 - 服务类
		$this->PackService = new PackService();
	}

	//判断数据列表 有值返回该类别相关数据 无值返回全部数据
	public function dataList() {
		$typeId = I( 'type_id' );
		empty( $typeId )
			? $this->index()
			: $this->typeDataList( $typeId );
	}

	//分类数据
	public function typeDataList( $pTypeId ) {
		$typeDataList = $this->PackService->dataCollection( $pTypeId );
		$this->assignDisplay( $typeDataList );
	}

	//主页面 - 视图
	public function index() {
		//下面赋值依次为类别,当前类别相关数据
		$datalist = $this->PackService->getUpdatePack();
		$this->assignDisplay( $datalist );
	}

	//下载压缩包
	public function downloadPack() {
		$data = I( 'get.' );
		$this->PackService->download( $data['id'] );
		$typeDataList = $this->PackService->dataCollection( $data['type_id'] );
		$this->assignDisplay( $typeDataList );
	}

	//刪除
	public function del() {
		$data = I( 'get.' );
		$this->PackService->deletePackProcess( $data['id'] );
		$typeDataList = $this->PackService->dataCollection( $data['type_id'] );
		$this->assignDisplay( $typeDataList );
	}

	//统一输出到模板
	public function assignDisplay( $pDataList ) {
		$this->assign( 'datalist', $pDataList );
		$this->display( 'Pack/index' );
	}



}