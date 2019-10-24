<?php
/**
 * 更新/恢复/操作类
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Controller;

use Think\Controller;
use Home\Service\Update\UpdateService;
use Home\Service\Restore\RestoreService;
use Home\Service\Data\DataService;

use Home\Common\Utility\FileBaseUtility as FileBase;


class UpdateController extends Controller
{

	public function __construct() {
		//加载权限管理 - 暂时未用
		parent::__construct();
		$this->UpdateService = new UpdateService();
		$this->RestoreService = new RestoreService();
	}

	//主页面 - 视图
	public function index() {

		//加载更新文件
		$typeId = I( 'type_id' );

		//如果未传入类别值 默认为分类列表的第一个类别
		empty( $typeId )
			? $datalist = $this->UpdateService->getDefaultType()
			: $datalist = $this->UpdateService->dataCollection( $typeId );

		//获取当前项目版本
		$datalist[3] = $this->UpdateService->getVersion();
		$this->assign( 'datalist', $datalist );

		//加载备份文件 - 还原
		$backupFile = $this->RestoreService->getBackUpZipList();
		if ( false == empty( $backupFile ))
			$this->assign( 'backupFile', $backupFile );

		//加载视图
		$this->display( 'Update/index' );

	}

	//更新文件
	public function update() {

		// $result = FileBase::checkDirFiles( DATABASE_UPDATE );
		// dump( $result );
		// die();

		// 更新数据库字段或其它信息
		$this->updateData();
		// die();

		$vid = I( 'version_id' );

		//版本ID为空时结束程序 - 此处可以放入单独的错误页面
		if ( empty( $vid )) die( '输入id名称' );

		//开始更新
		$this->UpdateService->updatePackProcess( $vid );

		//跳转到提示页面
		//$this->redirect('Common/message');
		echo 123;die();
		$message = new \Home\Controller\CommonController();
		$message->customMessage( array( 'ab','cd' ) );
	}

	//恢复备份文件 - 还原
	public function restore() {

		$backUpFile = I( 'backupath' );
		if ( is_file( $backUpFile )) {
			$this->RestoreService->restoreBackUpProcess( $backUpFile );
			$this->redirect('Common/message');
		}
		//$this->redirect( 'Update/reductionBackup' );
	}

	//更新数据库 - 暂时未用
	public function updateData() {
		$data = new DataService();
		//$result = $data->execStatements( $sql );
		// $data->fetchTest( $result );

	}





}