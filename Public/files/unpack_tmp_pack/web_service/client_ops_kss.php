<?php 
require_once("nusoap/lib/nusoap.php");
	
$connection_string = 'DRIVER={SQL Server};SERVER=127.0.0.1;DATABASE=HicisData'; 
$user = 'sa'; 
$pass = '87788393'; 
$connection = odbc_connect( $connection_string, $user, $pass )   or   die("数据库连接失败！！！");

$sql = 'SELECT visit_id FROM PatOPSCUTINFOR WHERE opsdate >= LEFT (getdate(),10)';
$e=odbc_do($connection,iconv("utf-8","GB2312",$sql));
while(odbc_fetch_row($e)){
	$s = $s. odbc_result($e,'visit_id').',';
	}  
		
//echo substr($s,0,strlen($s)-1); die ;

$client = new soapclient('http://16.22.103.136:81/OperationInfo.asmx?wsdl',true);  

$client->soap_defencoding = 'utf-8';
$client->decode_utf8 = false;
$client->xml_encoding = 'utf-8';

// 参数转为数组形式传递
$aryPara = array('EpisodeID'=>substr($s,0,strlen($s)-1));

// 调用远程函数
  
$string = $client->Call('GetOperationKSSGetXML',$aryPara);  //GetOperationKSSXML


//print_r($string);
 

$arr = array();

$arr = $string['GetOperationKSSGetXMLResult']; 

echo htmlspecialchars($arr);



$xml = new DOMDocument();

$xml->loadXML($arr); 

			$depts = $xml->getElementsByTagName( "KSS" );

			foreach( $depts as $dept )
			{
				
				$useorderno = $dept->getElementsByTagName("ORDNO")->item(0)->nodeValue.
										'-'. $dept->getElementsByTagName("ORDSUB")->item(0)->nodeValue;
										
				$medTime = $dept->getElementsByTagName("medTime")->item(0)->nodeValue;
				$OP_record_ID = $dept->getElementsByTagName("OP_record_ID")->item(0)->nodeValue;
				
				$sql = "update PatUseMedicine set  domedTime='".$medTime."' ,OP_record_ID='".$OP_record_ID."' where useorderno = '".$useorderno."'" ;
				//echo $sql;
				$e=odbc_do($connection,iconv("utf-8","GB2312",$sql));
				
				}

if(!$err = $client->getError())  
{  
        echo "The server return:".$string;  
	    print_r($string);
}  
else  
    echo "ERROR:".$err;  
	
function cl(){
	
	echo '
	<script type="text/javascript">

	this.window.opener = null;
	this.window.close();
	</script>
	
	';
	
	}	
cl();
?> 

