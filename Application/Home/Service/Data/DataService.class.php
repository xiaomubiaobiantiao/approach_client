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

	public function __construct( $pChildren ) {
		// dump( $pChildren );
		// if ( is_object( current( $pChildren )))
		// 	$this->children = array_shift( $pChildren );

		// dump( $this->children );
	}

	public function test() {
		echo 444;
	}

	//读取数据库文件目录
	private function readDataDir( $pDir ) {
		return FileBase::checkDirFiles( $pDir );
	}

	/**
	 * [updateDataProcess 更新文件流程]
	 * @param  [string] $pDataType     [database type]
	 * @param  [array] $pDataFilePath [database file path]
	 * @return [type]                [null]
	 */
	public function updateDataProcess() {
		$this->dataStructure = $this->loadDataFile( $this->dataDir );
		// dump( $this->dataStructure );
		return $this->dataStructure;
	}

	//返回首页信息
	public function indexInfo() {
		return $this->dataStructure();
	}

	/**
	 * [connectData 连接数据库]
	 * @param  [string] $pDataType [database type]
	 * @return [type]            [null]
	 */
	public function connectDatabase( array $pDatabaseType ) {
		dump( $pDatabaseType );

		// 拼接完整数据库名称
		$databaseType = ucfirst( $pDatabaseType[1].'Data' );
		
		$database = $this->children->make( 'DataType', $databaseType, $this->loadDataParam() );
		dump( $database );

		// $sql = "select * from a_nnis";
		// $resources = $database->exec( $sql );
		// $nums = $database->numRows( $resources );
		// dump( $nums );
		
	}

	//遍历数组连接数据库
	public function connectDatabases( array $pDatabaseTypeArr ) {
		foreach ( $pDatabaseTypeArr as $value )
			$this->connectDatabase( $value ) ? $data[$value] = true : $data[$value] = false;
		return $data;
	}

	//返回需要修改的数据库名称和对应sql文件 - 暫時未用
	private function loadDataFile( $pDataDir ) {
		return array_filter( $pDataDir );
	}

	//返回数组键名 - 一维 - 暫時未用
	private function getArrayKeys( $pArr ) {
		return array_keys( $pArr );
	}

	//加载数据库文件
	// public function loadDataFile( $pDataFilePathArr ) {
	// 	foreach ( $pDataFilePathArr as $value ) {
	// 		$connect = FileBase::readFileAll( $value );
	// 		$this->sqlFiles[basename($value)] = $connect;
	// 	}
	// }

	//分类数据库类型和文件
	public function typeDistinguish( $pFileArr ) {
		$keys = array_keys( $pFileArr );
		foreach ( $keys as $value ) {
			if ( false == empty( $pFileArr[$value] ))
				// $this->updateDataProcess( $value, $pFileArr[$value] );
				dump( $pFileArr[$value] );
		}
	}
	
	//执行 SQL 语句
	public function execStatements( $pSql ) {
		//执行Sql语句
		dump( $this->data );
		//return $this->data->odbcExec( $pSql );
	}

	//检测 SQL 是否更新成功
	public function checkSqlStatus() {

	}

	//加载数据库配置参数 - 临时用
	public function loadDataParam() {

		$dbconf['server'] 		= '.';
		$dbconf['user'] 		= 'sa';
		$dbconf['pass'] 		= '123123';
		$dbconf['database'] 	= 'hicisdata_new_test';
		$dbconf['connect'] 		= 'DRIVER={SQL Server};SERVER='.$dbconf['server'].';DATABASE='.$dbconf['database'];

		return $dbconf;

	}

	//字符串拼接 - 暂时未用
	public function connectStr( $pTableName, $pField, $pType ) {
		// $str = "select * from syscolumns where id=object_id('qgsh_report') and name='shsjwpmca'";
		$str = 'select * from syscolumns where id=object_id(' . $tableName . ') and name=' . $field;
		// $sql = 'alter table qgsh_report add shsjwpmca varchar(50)';
		$sql = 'alter table '.$tableName.' add '.$field.' '.$type;
	}

	//循环遍历内容 - 临时用
	public function fetchTest( $pArr ) {
		$this->data->fetchConnect( $pArr );
	}



}