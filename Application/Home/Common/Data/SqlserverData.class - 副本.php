<?php
/**
 * ���ݿ�������
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Common\Data;
use Home\Interfaces\Database;

class SqlserverData implements Database
{

	// ��ʼ�����ݿ����
	// public $server = '';
	// public $user = '';
	// public $pass = '';
	// public $database = '';
	// public $connect = '';

	// // ���ݿ�����
	public $dataConnect = '';

	// ��ʼ�� - ����
	// public function __construct( array $pParams ) {
	// 	$this->setParam( $pParams );
	// }

	// �������ݿ����
	public function setParam( array $pParams ) {
		// dump( $pParams );
		$this->server = $pParams['server'];
		$this->user = $pParams['user'];
		$this->pass = $pParams['pass'];
		$this->database = $pParams['database'];
		$this->connect = 'DRIVER={SQL Server};SERVER='.$pParams['server'].';DATABASE='.$pParams['database'];
	}

	// �������ݿ�
	public function connection() {
		$this->dataConnect = odbc_connect( $this->connect, $this->user, $this->pass );
		return $this->dataConnect;
	}

	// ִ��Sql���
	public function exec( $pSql ) {
		return odbc_exec( $this->dataConnect, $pSql );
	}
	
	// ѭ����������
	public function fetchConnect( $pResources ) {
		while( $row = odbc_fetch_array( $pResources ))
			$result[] = $row;
		return $result;
	}

	// �鿴������
	public function numRows( $pResources ) {
		return odbc_num_rows( $pResources );
	}

	// �鿴 ���ݿ� �Ƿ����
	public function in_database( string $pDataName ) {
		dump($pDataName);
		$sql = "select * from master.dbo.sysdatabases where name = '$pDataName'";
		// $sql = "select * from master.dbo.sysdatabases where name = 'hicisdata_new_test'";
		$result = $this->exec( $sql );
		$tmp = $this->fetchConnect( $result );
// dump($tmp);
		return is_null( $tmp ) ? false : true;
		
	}
	
	// �鿴 ���ݱ� �Ƿ����
	public function in_table( string $pTableName ) {
		$sql = "select * from $pTableName";
		$tmp = $this->exec( $sql );

		return false == $tmp ? false : true;

	}

	// ��ȡָ�����ݱ��������ֶ�
	public function tableFiles( string $pTableName ) {

		//��ȡָ�����������ֶ�������Ϣ - �� xml ����� - �������ò���
		// $sql = "select * from syscolumns where id=object_id('$pTableName')";
		// 
		// $sql = "select name from syscolumns where id=object_id('$pTableName')";
		// $sql = "select a.name ����, b.name �ֶ���,

		// 	    case c.name when 'numeric' 
		// 		    then 'numeric(' + convert(varchar,b.length) + '��' + convert(varchar,b.xscale) + ')'
		// 			when 'char' then 'char(' + convert(varchar,b.length) + ')'
		// 		    when 'varchar' then 'varchar(' + convert(varchar,b.length) + ')'
		// 	    	else c.name END AS �ֶ�����

		// 	from sysobjects a,syscolumns b,systypes c where a.id=b.id

		// 	and a.name='PAT_INFOR' and a.xtype='U'

		// 	and b.xtype=c.xtype";


		// $sql = "SELECT name,type_name(xtype) AS type,length,(type_name(xtype)+'('+CONVERT(varchar,length)+')') as t
		// 	FROM syscolumns
		// 	WHERE (id = OBJECT_ID('PAT_INFOR'))";

		$sql = "SELECT t1.name columnName,case when  t4.id is null then 'false' else 'true' end as pkColumn,
    case when  COLUMNPROPERTY( t1.id,t1.name,'IsIdentity') = 1 then 'true' else 'false' end as  autoAdd
    ,t5.name jdbcType
    ,cast(isnull(t6.value,'') as varchar(2000)) descr
FROM SYSCOLUMNS t1
left join SYSOBJECTS t2 on  t2.parent_obj = t1.id  AND t2.xtype = 'PK'
left join SYSINDEXES t3 on  t3.id = t1.id  and t2.name = t3.name 
left join SYSINDEXKEYS t4 on t1.colid = t4.colid and t4.id = t1.id and t4.indid = t3.indid
left join systypes  t5 on  t1.xtype=t5.xtype
left join sys.extended_properties t6   on  t1.id=t6.major_id   and   t1.colid=t6.minor_id
left join SYSOBJECTS tb  on  tb.id=t1.id
where tb.name='APIInfo' and t5.name<>'sysname' <br>order by t1.colid asc";

		$result = $this->exec( $sql );
		$tmp = $this->fetchConnect( $result );
		dump($tmp);
		return $this->tablesFileArray( $tmp );

	}

	// ������һ�׻�ȡ���ֶ� ת���� 1 ά����
	public function tablesFileArray( array $pFiles ) {
		foreach ( $pFiles as $value )
			$tmp[$value['name']] = $value['name'];
		dump( $tmp );
	}

	// ��ѯ�ֶ��Ƿ����
	public function in_files( string $pFieldName ) {
		
	}

}
