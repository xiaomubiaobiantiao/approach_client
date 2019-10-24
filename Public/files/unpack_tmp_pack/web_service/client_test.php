<?php 
require_once("nusoap/lib/nusoap.php");
//phpinfo();die;
 
//$client = new soapclient('http://localhost:21284/WebService1.asmx?wsdl',true);
$client = new soapclient('http://localhost:21284/WebService1.asmx?wsdl',true);

$client->soap_defencoding = 'UTF-8';
$client->decode_utf8 = false;

//$param = array('werwerwerwerwer'); 
$param = array('xml'=>'洒洒水发发发沙发安抚撒'); 
			
	// 调用远程函数  
$string = $client->Call('test1',array('parameters' => $param));	
//$string = $client->Call('test1',$param);	
//$string = $client->Call('test2');	

echo iconv("utf-8","gbk//IGNORE",$string['test1Result']);

?> 