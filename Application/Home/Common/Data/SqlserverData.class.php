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
	
		$sql = "SELECT 
			t1.name columnName,
			case when  t4.id is null then 'false' else 'true' end as pkColumn, 
			case when  COLUMNPROPERTY( t1.id,t1.name,'IsIdentity') = 1 then 'true' else 'false' end as  autoAdd,
			t5.name jdbcType ,
			t1.length as DataLength,
			t1.isnullable as IsNullable,
			e.text as defaulta,
			cast(isnull(t6.value,'') as varchar(2000)) descr
			--tb.name as tableName,
		FROM SYSCOLUMNS t1
			left join SYSOBJECTS t2 on  t2.parent_obj = t1.id  AND t2.xtype = 'PK' 
			left join SYSINDEXES t3 on  t3.id = t1.id  and t2.name = t3.name  
			left join SYSINDEXKEYS t4 on t1.colid = t4.colid and t4.id = t1.id and t4.indid = t3.indid
			left join systypes  t5 on  t1.xtype=t5.xtype
			left join sys.extended_properties t6   on  t1.id=t6.major_id   and   t1.colid=t6.minor_id
			left join SYSOBJECTS tb  on  tb.id=t1.id 
			left join sys.syscomments e on t1.cdefault=e.id
		where tb.name='$pTableName'";


		$result = $this->exec( $sql );
		$tmp = $this->fetchConnect( $result );
		// dump($tmp);
		// return $tmp;
		return $this->tableAssoc( $tmp );

	}

	// 将索引数组改为关联数据
	public function tableAssoc( array $pFiles ) {
		foreach ( $pFiles as $key=>$value ) {
			// dump($value);
			$tmp[$value['columnName']] = $value;
		}
		return $tmp;
	}

	// 将数据一肿获取的字段 转换成 1 维数组 - 暂时未用
	public function tablesFileArray( array $pFiles ) {
		foreach ( $pFiles as $value )
			$tmp[$value['columnName']] = $value['columnName'];
		return $tmp;
	}

	// 查询字段是否存在
	public function in_files( string $pFieldName ) {
		
	}

}
