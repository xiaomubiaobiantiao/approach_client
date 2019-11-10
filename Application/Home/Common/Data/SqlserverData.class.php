<?php
/**
 * 数据库连接类
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Common\Data;
use Home\Interfaces\Database;

class SqlserverData implements Database
{

	// 初始化数据库参数
	// public $server = '';
	// public $user = '';
	// public $pass = '';
	// public $database = '';
	// public $connect = '';

	// // 数据库连接
	public $dataConnect = '';

	// 初始化 - 备用
	// public function __construct( array $pParams ) {
	// 	$this->setParam( $pParams );
	// }

	// 设置数据库参数
	public function setParam( array $pParams ) {
		// dump( $pParams );
		$this->server = $pParams['server'];
		$this->user = $pParams['user'];
		$this->pass = $pParams['pass'];
		$this->database = $pParams['database'];
		$this->connect = 'DRIVER={SQL Server};SERVER='.$pParams['server'].';DATABASE='.$pParams['database'];
	}

	// 连接数据库
	public function connection() {
		$this->dataConnect = odbc_connect( $this->connect, $this->user, $this->pass );
		return $this->dataConnect;
	}

	// 执行Sql语句
	public function exec( $pSql ) {
		return odbc_exec( $this->dataConnect, $pSql );
	}
	
	// 循环遍历内容
	public function fetchConnect( $pResources ) {
		while( $row = odbc_fetch_array( $pResources ))
			$result[] = $row;
		return $result;
	}

	// 查看总行数
	public function numRows( $pResources ) {
		return odbc_num_rows( $pResources );
	}

	// 查看 数据库 是否存在
	public function in_database( string $pDataName ) {
		dump($pDataName);
		$sql = "select * from master.dbo.sysdatabases where name = '$pDataName'";
		// $sql = "select * from master.dbo.sysdatabases where name = 'hicisdata_new_test'";
		$result = $this->exec( $sql );
		$tmp = $this->fetchConnect( $result );
// dump($tmp);
		return is_null( $tmp ) ? false : true;
		
	}
	
	// 查看 数据表 是否存在
	public function in_table( string $pTableName ) {
		$sql = "select * from $pTableName";
		$tmp = $this->exec( $sql );

		return false == $tmp ? false : true;

	}

	// 获取指定数据表中所有字段
	public function tableFiles( string $pTableName ) {

		//获取指定表下所有字段名和信息 - 给 xml 打包用 - 在这里用不上
		// $sql = "select * from syscolumns where id=object_id('$pTableName')";
		// 
		// $sql = "select name from syscolumns where id=object_id('$pTableName')";
		// $sql = "select a.name 表名, b.name 字段名,

		// 	    case c.name when 'numeric' 
		// 		    then 'numeric(' + convert(varchar,b.length) + '，' + convert(varchar,b.xscale) + ')'
		// 			when 'char' then 'char(' + convert(varchar,b.length) + ')'
		// 		    when 'varchar' then 'varchar(' + convert(varchar,b.length) + ')'
		// 	    	else c.name END AS 字段类型

		// 	from sysobjects a,syscolumns b,systypes c where a.id=b.id

		// 	and a.name='PAT_INFOR' and a.xtype='U'

		// 	and b.xtype=c.xtype";


		// $sql = "SELECT 
		// 	name,type_name(xtype) AS type,
		// 	length,
		// 	(type_name(xtype)+'('+CONVERT(varchar,length)+')') as t,
		// 	isnullable as isnull,
		// 	type as a,
		// 	cdefault
		// 	FROM syscolumns
		// 	WHERE (id = OBJECT_ID('PAT_INFOR'))";

		// --
		// $sql = "Select d.Name tableName, isnull(e.value,'') descr From SysObjects dleft join  sys.extended_properties  e on d.id = e.major_id   and   e.minor_id=0 Where d.XType='U' and d.name like ? order By d.Name";

		$sql = "SELECT  c.TABLE_SCHEMA ,
        c.TABLE_NAME ,
        c.COLUMN_NAME ,
        c.DATA_TYPE ,
        c.CHARACTER_MAXIMUM_LENGTH ,
        c.COLUMN_DEFAULT ,
        c.IS_NULLABLE ,
        c.NUMERIC_PRECISION ,
        c.NUMERIC_SCALE
FROM    [INFORMATION_SCHEMA].[COLUMNS] c
WHERE   TABLE_NAME = 'hicisdata_new_test'";

		$result = $this->exec( $sql );
		$tmp = $this->fetchConnect( $result );
		dump($tmp);
		return $this->tablesFileArray( $tmp );

	}

	// 将数据一肿获取的字段 转换成 1 维数组
	public function tablesFileArray( array $pFiles ) {
		foreach ( $pFiles as $value )
			$tmp[$value['name']] = $value['name'];
		dump( $tmp );
	}

	// 查询字段是否存在
	public function in_files( string $pFieldName ) {
		
	}

}
