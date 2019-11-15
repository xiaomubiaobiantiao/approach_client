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


	public function __construct( $pContainer ) {
		$this->container = $pContainer;
		$this->dataExtract = $pContainer->dataExtract;
		$this->zip = $pContainer->zip;
		$this->xml = $pContainer->xml;
		$this->log = $pContainer->dataLog;
		$this->createDataLog( $pContainer->fileBase );
	}

	// 创建数据更新日志文件
	private function createDataLog( $pFileBase ) {
		if ( file_exists( DATABASE_LOG_PATH ) && file_exists( DATABASE_ERROR_LOG_PATH ))
			return;
		$pFileBase->createDir( dirname( DATABASE_LOG_PATH ));
		$pFileBase->createFile( DATABASE_LOG_PATH );
		$pFileBase->createFile( DATABASE_ERROR_LOG_PATH );
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

	}

	// 总预览
	public function allPreview( $pPreviewJson ) {

		$data = $this->jsonConv( $pPreviewJson );
		$zipId = array_shift( $data );

		$list = $this->getXmlInfo( $zipId );
		$xmlInfo = $this->getXmlDataInfo( $list['zipPath'] );

		if ( empty( $xmlInfo )) die( '没有数据库需要更新' );

		$prieview = $this->priviewData( $xmlInfo, $data );
		return $this->packPrieview( $data, $prieview, $xmlInfo );

	}
	
	// 打包即将返回的预览数据
	private function packPrieview( $pData, $pPrieview, $pXmlInfo ) {

		$tmp['data'] = $pData;
		$tmp['prieview'] = $pPrieview;
		$tmp['xmlInfo'] = $pXmlInfo;

		$prieviewReturn['data'] = json_encode( $tmp );
		$prieviewReturn['prieview'] = $pPrieview;

		return $prieviewReturn;
		
	}

	// 预览 - 匹配 xml 与 数据库字段 - 建立返回页面的数据结构 - 项目急用 - 暂时写法
	private function priviewData( $pXmlInfo, $pData ) {
		foreach ( $pXmlInfo as $dataType=>$value ) {
			// 当前数据库的类型

			// 匹配数据库类型并连接数据库
			$dataInstance = $this->match_linkData( $dataType, $pData );
			
			// 连接数据库 - 成功/失败		
			if ( is_object( $dataInstance )) {
				$return[$dataType][] = true;
			} else {
				$return[$dataType][] = false;
				// 日志备用
				$logs[$dataType] = false;
			}

			foreach ( $value as $dataName=>$val ) {
				// 当前数据库的名称
				
				$dataInstance->setDatabase( $dataName );
				// 检测数据库名称 - 成功/失败
				$bool = $dataInstance->in_database( $dataName );
				$return[$dataType][1][$dataName][] = $bool;

				// 日志用
				if ( false == $bool ) $logs[$dataName] = $bool;

				foreach ( $val as $tableName=>$field ) {
					// 当前数据表的名称
					
					// 检测数据表 - 成功/失败
					$bool = $dataInstance->in_table( $tableName );
					$return[$dataType][1][$dataName][1][$tableName][] = $bool;

					// 日志备用
					if ( false == $bool ) $logs[$tableName] = $bool;

					// 获取数据表字段信息
					$fieldInfo = $dataInstance->tableFiles( $tableName );

					// 获取xml字段信息的的 名称 和 数目
					$xmlField = $this->getFieldAndCount( $field );
					$return[$dataType][1][$dataName][1][$tableName][1]['xmlCount'] = $xmlField[1];
					$return[$dataType][1][$dataName][1][$tableName][1]['xmlField'] = $xmlField[0];

					// 获取data字段信息的的 名称 和 数目
					$dataField = $this->getFieldAndCount( $fieldInfo );
					$return[$dataType][1][$dataName][1][$tableName][1]['dataCount'] = $dataField[1];
					$return[$dataType][1][$dataName][1][$tableName][1]['dataField'] = $dataField[0];

					//测试用 - 上线需要删掉下面两行 array_shift 和 array_shift ******
					// array_shift($xmlField);
					array_shift($dataField[0]);

					// 数据表和XML里相同的字段
					// $intersect = array_intersect( $xmlField, $dataField );//dump( $intersect );
					// 数据表里存在 XML里不存在的字段
					// $dataDiff = array_diff( $dataField, $intersect );//dump( $dataDiff );
					// XML里存在 数据表里不存在的字段 - 需要添加
					$xmlDiff = array_diff( $xmlField[0], $dataField[0] );
					$return[$dataType][1][$dataName][1][$tableName][1]['addField'] = $xmlDiff;
					$return[$dataType][1][$dataName][1][$tableName][1]['addFieldCount'] = count($xmlDiff);

					// 配置前端字段展示列表 - 字段值为 false 需要添加的字段, true 数据库存在, 不需要添加的字段
					foreach ( $xmlField[0] as $value ) {
						$num = array_search( $value, $xmlDiff );
						$return[$dataType][1][$dataName][1][$tableName][1]['list'][$value] = $num || $num === 0 ? 'false' : 'true';
					}

					// 日志备用
					// if ( count( $fieldInfo ) === 0 ) $logs[$dataType] = false;

				}
			}


		}

		// 日志备用
		// if ( false == is_null( $logs )) die( '添加错误日志' );
		
		return $return;
		

	}

	// 更新 - 更新数据 - 项目急用 - 暂时写法
	public function updateDataExec( $pData ) {
		// dump($pData['xmlInfo']);die();
		foreach ( $pData['prieview'] as $dataType=>$value ) {
			// 当前数据库的类型 dump($dataType);

			// 匹配数据库类型并连接数据库
			$dataInstance = $this->match_linkData( $dataType, $pData['data'] );
			
			// 连接数据库 - 成功/失败		
			if ( is_object( $dataInstance )) {
				$return[$dataType][] = true;
			} else {
				$return[$dataType][] = false;
				// 日志备用
				$logs[$dataType] = false;
			}

			foreach ( $value[1] as $dataName=>$val ) {
				// 当前数据库的名称 dump($dataName);
				
				// $dataInstance->setDatabase( $dataName );
				$dataInstance->setDatabase( 'test' );
				// 检测数据库名称 - 成功/失败
				$bool = $dataInstance->in_database( $dataName );

				// 日志备用
				if ( false == $bool ) $logs[$dataName] = $bool;
				
				foreach ( $val[1] as $tableName=>$tableInfo ) {
					// 当前数据表的名称 dump($tableName);
					
					$bool = $dataInstance->in_table( $tableName );

					// 日志备用
					if ( false == $bool ) $logs[$tableName] = $bool;

					foreach ( $tableInfo[1]['addField'] as $field ) {

						$tmpField = $pData['xmlInfo'][$dataType][$dataName][$tableName][$field];
						$sqlArr = $this->toSql( $tableName, $tmpField );

						$this->addFields( $dataInstance, $dataType, $dataName, $sqlArr, $field );
						// $this->in_fields( $dataInstance, $dataType, $dataName, $field );
					}

				}

			}

		}

		// 不用返回, 只为方便代码浏览
		return $this->addFieldError;

	}

	// 添加字段
	private function addFields( database $pData, $pDataType, $pDataName, array $pSql, $pField ) {
		static $num = 0;echo $num;
		foreach ( $pSql as $value ) {

			$result = $pData->exec( $value );
			dump( $result );
			$strInfo = $pDataType.'|'.$pDataName.'|'.$value.'|'.$pField;
			// 写入日志 - 添加字段失败时会返回 bool 值的 false
			if ( false == $result ) {
				// 建立返回值数组
				count( $pSql ) == 1
					? $this->addFieldError[] = $strInfo
					: $this->addFieldError[$num][] = $strInfo;
				$this->log->inforReceive( $strInfo, 1 );
			} else {
				$this->log->successReceive( $strInfo, 1 );
			}

		}
		$num ++;
	}

	// 查询字段 - 暂时未用
	private function in_fields( database $pData, $pDataType, $pDataName, string $pField ) {

		$result = $pData->in_field( 'Table_1', $pField );
		
		// 写入日志 - 查询不成功会返回 bool 值的 false
		$strInfo = $pDataType.'|'.$pDataName.'|'.$pField;
		if ( false == $result ) {
			$this->searchFieldError[] = $strInfo;
			$this->log->inforReceive( $strInfo, 2 );
		} else {
			$this->log->successReceive( $strInfo, 2 );
		}

	}	

	// 拼接更新字段的SQL信息
	private function toSql( string $pTableName, array $pField ) {
		// dump($pTableName);
		// dump( $pField );
		$pTableName = 'Table_1';
		// 不能指定列宽的数据类型
		$ints = array( 'datetime', 'ntext', 'tinyint', 'Smallint', 'int', 'bigint' );
		$is_type = array_search( $pField['type'], $ints );

		$type = false == $is_type
			? $pField['type'].'('.$pField['length'].')'
			: $pField['type'];

		$field = $pField['cname'];

		$isnull = 'false' == $pField['isnull'] ? 'not null' : 'null';

		$default = empty( $pField['defaults'] ) ? "default ''" : $pField['defaults'];


		// $sql = "alter table $pTableName add $field $type $isnull $default";dump($sql);
		// $sql = "alter table $pTableName add $field $type identity(1,1) $isnull";dump($sql);
		// $sql = "alter table $pTableName add constraint $field primary key NONCLUSTERED($field)";
		// dump($sql);
		// die();

		if ( 'false' == $pField['ispk'] && 'false' == $pField['autoAdd'] ) {
			// alter table | 表名 | add | 字段名 | varchar | (10) | not null | defaults
			$sql[] = "alter table $pTableName add $field $type $isnull $default";
		} else if ( 'true' == $pField['ispk'] && 'true' == $pField['autoAdd'] ) {
			// alter table | 表名 | add | 字段名 | varchar | (10) | identity(1,1) | not null
			// alter table | 表名 | add constraint | 索引名 | primary key NONCLUSTERED( | 字段名 | )
			$sql[] = "alter table $pTableName add $field $type identity(1,1) $isnull";
			$sql[] = "alter table $pTableName add constraint $field primary key NONCLUSTERED($field)";
		} else if ( 'true' == $pField['ispk'] ) {
			// alter table | 表名 | add | 字段名 | varchar | (10) | not null | defaults
			$sql[] = "alter table $pTableName add $field $type $isnull $default";
			$sql[] = "alter table $pTableName add constraint $field primary key NONCLUSTERED($field)";
		} else if ( 'true' == $pField['autoAdd'] ) {
			// alter table | 表名 | add | 字段名 | varchar | (10) | identity(1,1) | not null
			$sql[] = "alter table $pTableName add $field $type identity(1,1) $isnull";
		} 

		return $sql;

	}

	// 获取字段信息的的 名称 和 数目
	private function getFieldAndCount( $pArr ) {
		// 获取字段名称
		$tmp[] = array_keys( $pArr );
		// 字段数目
		$tmp[] = count( $pArr );
		// dump($tmp);die();
		return $tmp;
	}

	// 匹配数据库类型并连接数据库
	private function match_linkData( string $pDataType, array $pData ) {

		$dataIndex = $this->in_data( $pDataType, $pData );
		if ( $dataIndex || $dataIndex === 0 )
			return $this->dataConnect( $pData[$dataIndex] );

		die( '数据库不匹配' );

	}

	// 判断二维数组中是否存在某些字段
	private function in_data( $field, $pArr ) {
		foreach ( $pArr as $key=>$value ){
			if ( array_search( $field, $value ) ) 
				return $key;
		}
		return false;
	}


//------------------------------------------------------------------------------------------------

// 测试连接数据库 --------------------------------------------------------------------------------

    // 测试连接单个数据库
    public function linkData( $pParams ) {

    	$params = $this->jsonConv( $pParams );
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

    public function getDataInstance( $pClassName ) {

    	$className = $pClassName.'Data';
    	return $this->container->$className;

    }


//------------------------------------------------------------------------------------------------
	
// Json ------------------------------------------------------------------------------------------

	// 获取 JSON 数据
	public function ajaxJson() {

		return file_get_contents( 'php://input' );
		
	}

	// json 转换数组
	private function jsonConv( $pJson ) {

		return is_array( $pJson ) ? $pJson : json_decode( $pJson, true );

	}


//------------------------------------------------------------------------------------------------

	// 获取 post 表单提交数据
	public function postJson() {

		$post = $_POST;
		return $this->jsonConv( $post['data'] );

	}




}