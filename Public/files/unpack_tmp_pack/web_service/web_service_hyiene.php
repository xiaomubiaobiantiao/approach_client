<?php 
require_once("nusoap/lib/nusoap.php");
 
 function utf8togb2312($str)//Utf8 编码转 gb2312
{
  return iconv("utf-8","gbk//IGNORE",$str); 
}		

function gb2312toutf8($str)// gb2312编码转Utf8 
{
  return iconv("gbk","utf-8//IGNORE",$str); 
}

function strings($sid)  
{  
	$connection_string = 'DRIVER={SQL Server};SERVER=127.0.0.1;DATABASE=HicisData_new'; 
	$user = 'sa'; 
	$pass = 'sfdl9898'; 
	$connection = odbc_connect( $connection_string, $user, $pass )   or   die("数据库连接失败！！！"); 
	
	$sql="select top 1 * from hygiene";
	$res = odbc_exec($connection,utf8togb2312($sql));
	$RowCount=odbc_num_rows($res);
	$data = '';
	while($result = odbc_fetch_array($res)){
		$xml = "<root>"; 
		foreach ($result as $key=>$val){  
			$xml.="<".gb2312toutf8($key).">".gb2312toutf8($val)."</".gb2312toutf8($key).">"; 
		} 
		$xml.="</root>";
	}
	return $xml;
}  
  
 
$server = new Soap_Server;  
$server->configureWSDL('strings');  
$server->register('strings',array("sid"=>"xsd:string"),array("return"=>"xsd:string"));  
  
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA)? $HTTP_RAW_POST_DATA:'';  
  
$server->service($HTTP_RAW_POST_DATA);  
  
?>