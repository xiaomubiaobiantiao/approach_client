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

	}

	// 总预览
	public function allPreview( $pPreviewJson ) {

		$data = $this->jsonConv( $pPreviewJson );
		$zipId = array_shift( $data );

		$list = $this->getXmlInfo( $zipId );
		$xmlInfo = $this->getXmlDataInfo( $list['zipPath'] );

		if ( empty( $xmlInfo )) die( '没有数据库需要更新' );


		foreach ( $xmlInfo as $dataType=>$value ) {
			// 当前数据库的类型 dump($dataType);

			// 匹配数据库类型并连接数据库
			$dataInstance = $this->match_linkData( $dataType, $data );
			
			// 连接数据库 - 成功/失败		
			if ( is_object( $dataInstance )) {
				$return[$dataType][] = true;
			} else {
				$return[$dataType][] = false;
				$logs[$dataType] = false;
			}

			foreach ( $value as $dataName=>$val ) {
				// 当前数据库的名称 dump($dataName);
				
				$dataInstance->setDatabase( $dataName );
				// 检测数据库名称 - 成功/失败
				$bool = $dataInstance->in_database( $dataName );
				$return[$dataType][1][$dataName][] = $bool;

				if ( false == $bool ) $logs[$dataName] = $bool;

				foreach ( $val as $tableName=>$field ) {
					// 当前数据表的名称 dump($dataName);
					
					// 检测数据表 - 成功/失败
					$bool = $dataInstance->in_table( $tableName );
					$return[$dataType][1][$dataName][1][$tableName][] = $bool;

					if ( false == $bool ) $logs[$tableName] = $bool;

					// 获取数据表字段信息
					$fieldInfo = $dataInstance->tableFiles( $tableName );

					// 获取字段信息的的 名称 和 数目
					$xmlResult = $this->getFieldAndCount( $field );
					$return[$dataType][1][$dataName][1][$tableName][1]['xmlCount'] = $xmlResult[0];
					$return[$dataType][1][$dataName][1][$tableName][1]['xmlField'] = $xmlResult[1];

					// 获取字段信息的的 名称 和 数目
					$fieldResult = $this->getFieldAndCount( $fieldInfo );
					$return[$dataType][1][$dataName][1][$tableName][1]['dataCount'] = $fieldResult[0];
					$return[$dataType][1][$dataName][1][$tableName][1]['dataField'] = $fieldResult[1];

					// array_shift($xmlField);
					array_pop($dataField);
					// 数据表和XML里相同的字段
					// $intersect = array_intersect( $xmlField, $dataField );//dump( $intersect );
					// 数据表里存在 XML里不存在的字段
					// $dataDiff = array_diff( $dataField, $intersect );//dump( $dataDiff );
					// XML里存在 数据表里不存在的字段 - 需要添加
					$xmlDiff = array_diff( $xmlField, $dataField );
					$return[$dataType][1][$dataName][1][$tableName][1]['addField'] = $xmlDiff;
					
					if ( count( $fieldInfo ) === 0 ) $logs[$dataType] = false;

				}
			}


		}
		if ( false == is_null( $logs )) die( '添加错误日志' );
		// dump( $logs );
		dump( $return );
		
		// $this->xmlFields( $xmlInfo );
	}

	// 获取字段信息的的 名称 和 数目
	private function getFieldAndCount( $pArr ) {
		// 获取字段名称
		$tmp[] = array_keys( $pArr );
		// 字段数目
		$tmp[] = count( $pArr );
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





}