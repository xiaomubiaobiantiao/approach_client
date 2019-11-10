<?php
/**
 * 数据库操作类
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Service\Data;

use Home\Common\Utility\FileBaseUtility as FileBase;

class DataService
{


	public function __construct( Array $pContainer ) {
		$this->container = $pContainer;
		$this->dataExtract = $pContainer->dataExtract;
		$this->zip = $pContainer->zip;
		$this->xml = $pContainer->xml;
	}

	// 提取压缩包列表
	public function getZipList( $pTypeId ) {
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

		$list = $this->searchXmlInfo( $files, $packInfo['download'] );

		if ( $list['xmlCount'] < 1 ) die( '这个版本没有数据库需要更新' );

		if ( empty( $list['xmlType'] )) die( 'xml 文件中没有数据库需要更新' );

		$list['zipId'] = $pVid;
		$list['zipPath'] = $packInfo['download'];

		return $list;
		//库名 -- 未完待续
	}

	// 总预览
	public function allPreview( $pPreviewJson ) {

		$data = $this->jsonConv( $pPreviewJson );
		$zipId = array_shift( $data );

		$list = $this->getXmlInfo( $zipId );
		$xmlInfo = $this->getXmlDataInfo( $list['zipPath'] );

		foreach ( $xmlInfo as $key=>$value ) {

			// 连接数据库
			$dataIndex = $this->in_data( $key, $data );
			$dataIndex || $dataIndex === 0 
				? $dataInstance = $this->dataConnect( $data[$dataIndex] )
				: die( '数据库不匹配' );

				dump( $dataInstance );
			// 查询当前数据库-数据表
			$dataName = array_keys( $value );
			dump($dataName);
			
		}

		// dump($xmlInfo);

		// foreach ( $ ) {

		// }
		dump($data);
		

		//数据库名
		//	表名
		//		字段名

		// $this->xmlFields( $xmlInfo );
	}

	// 判断二维数组中是否存在某些字段
	private function in_data( $field, $pArr ) {
		foreach ( $pArr as $key=>$value ){
			if ( array_search( $field, $value ) ) {
				return $key;
			}
		}
		return false;
	}


	// 提取 XML 表个数目 字段数目
	// public function xmlFields( $pXmlInfo ) {
	// 	// dump( $pXmlInfo );
	// 	$datas = array_keys( $pXmlInfo );
	// 	$dataCount = count( $dataNum );

	// 	foreach ( $datas as $value ) {

	// 		$tables = array_keys( $pXmlInfo[$value] );
	// 		$arr[$value]['count'] = count( $tables );
	// 		$arr[$value]['table'] = $tables;
	// 		foreach ( $tables as $val ) {

	// 			$fileds = array_keys( $pXmlInfo[$value][$val] );
	// 			$arr[$value][$val][] = $fileds;
	// 		}



	// 	}
	// 	// dump($fileds);
	// 	// dump( $datas );
	// 	dump( $arr );

	// 	// dump( $datas );
	// 	// dump( $dataCount );
	// 	// $tableCount = count( $pXmlInfo );
	// 	// $fieldCount = count( $pXmlInfo );
	// }

//------------------------------------------------------------------------------------------------

// 测试连接数据库 --------------------------------------------------------------------------------

    // 测试连接单个数据库
    public function linkData( $pParams ) {
    	$params = $this->jsonConv( $pParams );
    	// $data = $this->getDataInstance( $params['type'] );
    	// $data->setParam( $params );
    	// $data->connection() ? $bool = true : $bool = false;
    	$bool = $this->dataConnect( $params ) ? true : false;
    	$return[$params['type']] = $bool;
    	$ajaxReturn['code'] = 200;
    	$ajaxReturn['data'] = $return;
    	return $ajaxReturn;
    }

    // 测试连接多个数据库
    public function linkMoreData( $pParams ) {
    	$ajaxReturn = array();
    	$params = $this->jsonConv( $pParams );
    	foreach ( $params as $value ) {
    		$return = $this->linkData( $value );
    		$ajaxReturn['data'][key($return['data'])] = $return['data'][key($return['data'])];
    	}
    	$ajaxReturn['code'] = 200;
    	return $ajaxReturn;
    }

    // 连接数据库
    public function dataConnect( $pParams ) {
    	$data = $this->getDataInstance( $pParams['type'] );
    	$data->setParam( $pParams );
    	return $data->connection() ? $data : false;
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

	// 获取 JSON 数据
	public function getJson() {

		return file_get_contents( 'php://input' );
		
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