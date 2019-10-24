<?php 
require_once("nusoap/lib/nusoap.php");
 
function strings($sid,$xmlStr)  
{  
	$connection_string = 'DRIVER={SQL Server};SERVER=127.0.0.1;DATABASE=HicisData_bjdl160226'; 
	$user = 'sa'; 
	$pass = 'sfdl9898'; 
	$connection = odbc_connect( $connection_string, $user, $pass )   or   die("数据库连接失败！！！"); 
	
	$k=odbc_do($connection,"insert into json_data (json_text,sendid,write_date) values ('".iconv("utf-8","GB2312//IGNORE",$xmlStr)."','".$sid."',getdate())");//把串存在aaa表中
	
	return 1  ; 
}  
  
 
$server = new Soap_Server;  
$server->configureWSDL('strings');  
$server->register('strings',array("sid"=>"xsd:string","xmlStr"=>"xsd:string"),array("return"=>"xsd:string"));  
  
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA)? $HTTP_RAW_POST_DATA:'';  
  
$server->service($HTTP_RAW_POST_DATA);  
  
?>