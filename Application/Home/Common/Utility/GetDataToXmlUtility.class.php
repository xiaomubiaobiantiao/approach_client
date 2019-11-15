<?php
/**
 * 获取数据库 库名 表名 字段名和字段属性并转换为XML格式
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Common\Utility;

class GetDataToXmlUtility
{

	private $info = array();
	private $path = 'C:\Users\maker\Desktop\ccc.xml';

	public function __construct() {
		$this->info = array( 
			'ReportServer' => array(

				'tableName' => array(

					'ActiveSubscriptions',

					'Batch'

				)

			)
			// 'role_dzl' => array(
			// 	'tableName' => array(
			// 		'MakeSum',
			// 		'Role_dict'
			// 	)
			// )
		);
	}

	// 连接数据库 - 获取数据
	public function linkGetData() {

		$this->DataService = new \Home\Service\Data\DataService( new \Home\Supply\Supply() );

		$params = array( 'type'=>'sqlserver', 'server'=>'.', 'user'=>'sa', 'pass'=>'123123', 'database'=>'hicisdata_new_test');
		// $params = array( 'type'=>'sqlserver', 'server'=>'.', 'user'=>'sa', 'pass'=>'123123' );
		$data = $this->DataService->dataConnect( $params );

		$dataName = 'hicisdata_new_test';
		$tableName = 'PAT_INFOR';

		$data_bool = $data->in_database( $dataName );
		// dump($a);

		$table_bool = $data->in_table( $tableName );
		// dump($a);		

		$result = $data->tableFiles( $tableName );

		if ( false == $data_bool ) die( $dataName.' 数据库不存在' );
		if ( false == $table_bool ) die( $tableName.' 数据表不存在' );

		$dataList = array(
			$dataName => array(
				$tableName => $result
			)
		);

		// dump( $dataList );

		$getData = $this->getDataInfo( $this->info );
		$this->arrToXml( $getData, $this->path );
		// dump($getData);
	}

	// 获取数据库信息的数组结构如下：
	// array(
	// 	'库名称' => array(
	// 		'tableName' => array(
	// 			'表名称',
	// 			'表名称'
	// 		)
	// 	),
	// )

	public function getDataInfo( array $pInfo ) {

		foreach ( $pInfo as $key=>$value ) {
			$params = array( 'type'=>'sqlserver', 'server'=>'.', 'user'=>'sa', 'pass'=>'123123', 'database'=> $key );	
			$data = $this->DataService->dataConnect( $params );
			$data_bool = $data->in_database( $key );
			foreach ( $value['tableName'] as $val ) {
				$data->in_table( $val );
				$tmp[$key][$val] = $result = $data->tableFiles( $val );
			}
		}

		return $tmp;

	}

	// 将 getDataInfo 获取的数据库信息转化为 xml 并存储
	private function arrToXml( array $pData, string $pPath ) {

		$doc = new \DOMDocument('1.0', 'utf-8');
		$doc->preserveWhiteSpace = false;
		$doc->formatOutput = TRUE;

		$root = $doc->createElement( "Dataset" );

		foreach ( $pData as $key=>$value ) {
			$itme = $doc->createElement('database');
				$dataName = $doc->createAttribute( 'name' );
				$dataVal = $doc->createTextNode( $key );
				$dataName->appendChild( $dataVal );

				$itme->appendChild( $dataName );
			$root->appendChild($itme);

			foreach ( $value as $tabkey=>$val ) {
				$itme_1 = $doc->createElement('table');
					$dataName_1 = $doc->createAttribute( 'tname' );
					$dataVal_1 = $doc->createTextNode( $tabkey );
					$dataName_1->appendChild( $dataVal_1 );

					$itme_1->appendChild( $dataName_1 );
				$itme->appendChild( $itme_1 );
				
				foreach ( $val as $fieldVal ) {
					$itme_2 = $doc->createElement( 'column' );
					foreach ( $fieldVal as $infoKey=>$info ) {

						$dataName_2 = $doc->createAttribute( $infoKey );
						$dataVal_2 = $doc->createTextNode( $info );
						$dataName_2->appendChild( $dataVal_2 );

						$itme_2->appendChild( $dataName_2 );
					}
					$itme_1->appendChild( $itme_2 );
				}
				
			}

		}

		$doc->appendChild($root);

		header("Content-type: text/xml");
		
		$doc->save( $pPath );
		
	}

	


}