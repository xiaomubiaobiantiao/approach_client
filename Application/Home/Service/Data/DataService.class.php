<?php
/**
 * 数据库操作类
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Service\Data;

use Home\Common\Utility\DataTypeUtility as DataType;
use Home\Common\Utility\FileBaseUtility as FileBase;

class DataService
{


	//初始化数据库名称
	public $data = '';

	//初始化sql文件数组 - 包含文件名与SQL语句
	public $sqlFiles = array();

	//数据库文件原始目录结构
	public $dataDir = '';

	//数据库文件需要更新的目录结构
	public $dataStructure = '';

	public function __construct( Array $pContainer ) {
		$this->container = $pContainer;
		$this->dataExtract = $pContainer->dataExtract;
		$this->zip = $pContainer->zip;
		$this->xml = $pContainer->xml;
		// $this->data = $pContainer->dataType;
	}

	// 提取压缩包列表
	public function getZipList( $pTypeId ) {
		// $dataExtract = new DE();
		empty( $pTypeId )
			? $dataList = $this->dataExtract->getDefaultType()
			: $dataList = $this->dataExtract->dataCollection( $pTypeId );
		return $dataList;
	}

	// 打开文件数据库 取出更新包信息
	private function getZipInfo( $pVid ) {
		return $this->dataExtract->packInfo( $pVid );
	}

	// 获取更新包中文件的列表
	private function getZipFileList( $pZipPath ) {
		return $this->zip->getZipFileList( $pZipPath );
	}

	// 搜索列表中 xml 文件信息
	private function searchXmlInfo( $pFiles ) {
		return $this->xml->_perForm( $pFiles );
	}

	// 解析更新包内 xml 获取数据库信息
	private function getXmlDataInfo( $pZipPath ) {
		return $this->xml->_secondPerForm( $this->zip, $pZipPath );
	}

	// 获取XML文件信息
	public function getXmlInfo( $pVid ) {

		$packInfo = $this->getZipInfo( $pVid );

		$files = $this->getZipFileList( $packInfo['download'] );

		$list = $this->searchXmlInfo( $files );

		if ( $list['xmlCount'] < 1 ) die( '这个版本没有数据库需要更新' );

		if ( empty( $list['xmlType'] )) die( 'xml 文件中没有数据库需要更新' );

		return $list['xmlType'];

		// 打开压缩包内
		$dataList = $this->getXmlDataInfo( $packInfo['download'] );
		dump( $dataList );

		// $xmlContent = $this->getFileContent( $this->xml, $packInfo['download'] );

		// $xmlArr = $this->parsXmlContent( $xmlContent );
		// dump($xmlArr);
		
	}
	// 应该将XML操作都放到XML包里面, XML文件的路径也应该传到 xml 类, 由 xml 类来操作
	// 获取压缩包内 xml 文件的内容
	private function getFileContent( $pXml, $pZipPath ) {
			
		if ( $pXml->xml['xmlCount'] == 1 ) {
			$xmlContent = $this->zip->getZipFileContent( $pZipPath, array_shift( $pXml->xml['list'] ));
		} else {
			foreach ( $pXml->xml['list'] as $value )
				$xmlContent = $this->zip->getZipFileContent( $pZipPath, $value );
		}

		return $xmlContent;

	}

//------------------------------------------------------------------------------------------------

// 测试连接数据库 --------------------------------------------------------------------------------

    // 连接单个数据库
    public function linkData( $pParams ) {
    	$params = $this->jsonConv( $pParams );
    	$data = $this->getDataInstance( $params['type'] );
    	$data->setParam( $params );
    	$data->connection() ? $bool = true : $bool = false;
    	$ajaxReturn[$params['type']] = $bool;
    	return $ajaxReturn;
    }

    // 连接多个数据库
    public function linkMoreData( $pParams ) {
    	$ajaxReturn = array();
    	$params = $this->jsonConv( $pParams );
    	foreach ( $params as $value ) {
    		$return = $this->linkData( $value );
    		$ajaxReturn[key($return)] = $return[key($return)];
    	}
    	// dump( $ajaxReturn );
    	return $ajaxReturn;
    }

    // 获取数据库实例
    public function getDataInstance( $pClassName ) {
    	// dump( $pClassName );
    	$className = $pClassName.'Data';
    	return $this->container->$className;
    }

    // json 转换数组
	private function jsonConv( $pJson ) {
		return is_array( $pJson ) ? $pJson : json_decode( $pJson, true );
	}

	// 判断是否为 json 格式 - 暂时未用
 //    private function is_not_json($str){ 
 //    	return is_null(json_decode($str));
	// }


//------------------------------------------------------------------------------------------------
	
// Json ------------------------------------------------------------------------------------------

	// 返回数据
	private function returnData() {

	}



//------------------------------------------------------------------------------------------------


	//读取数据库文件目录
	// private function readDataDir( $pDir ) {
	// 	return FileBase::checkDirFiles( $pDir );
	// }

	// /**
	//  * [updateDataProcess 更新文件流程]
	//  * @param  [string] $pDataType     [database type]
	//  * @param  [array] $pDataFilePath [database file path]
	//  * @return [type]                [null]
	//  */
	// public function updateDataProcess() {
	// 	$this->dataStructure = $this->loadDataFile( $this->dataDir );
	// 	// dump( $this->dataStructure );
	// 	return $this->dataStructure;
	// }

	// //返回首页信息
	// public function indexInfo() {
	// 	return $this->dataStructure();
	// }
	
	// //执行 SQL 语句
	// public function execStatements( $pSql ) {
	// 	//执行Sql语句
	// 	dump( $this->data );
	// 	//return $this->data->odbcExec( $pSql );
	// }

	// //检测 SQL 是否更新成功
	// public function checkSqlStatus() {

	// }

	// //加载数据库配置参数 - 临时用
	// public function loadDataParam() {

	// 	$dbconf['server'] 		= '.';
	// 	$dbconf['user'] 		= 'sa';
	// 	$dbconf['pass'] 		= '123123';
	// 	$dbconf['database'] 	= '';
	// 	$dbconf['connect'] 		= 'DRIVER={SQL Server};SERVER='.$dbconf['server'].';DATABASE='.$dbconf['database'];

	// 	return $dbconf;

	// }

	// //字符串拼接 - 暂时未用
	// public function connectStr( $pTableName, $pField, $pType ) {
	// 	// $str = "select * from syscolumns where id=object_id('qgsh_report') and name='shsjwpmca'";
	// 	$str = 'select * from syscolumns where id=object_id(' . $tableName . ') and name=' . $field;
	// 	// $sql = 'alter table qgsh_report add shsjwpmca varchar(50)';
	// 	$sql = 'alter table '.$tableName.' add '.$field.' '.$type;
	// }

	// //循环遍历内容 - 临时用
	// public function fetchTest( $pArr ) {
	// 	$this->data->fetchConnect( $pArr );
	// }



}