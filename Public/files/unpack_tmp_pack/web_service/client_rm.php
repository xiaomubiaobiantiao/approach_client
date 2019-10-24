<?php 
require_once("nusoap/lib/nusoap.php");

$client = new soapclient('http://16.22.25.52/trakcarelive/trak/web/WebServiceITFCRMS.ITFCRMSMidData.cls?WSDL',true);  

$client->soap_defencoding = 'UTF-8';
$client->decode_utf8 = false;


// 参数转为数组形式传递
$aryPara = array('strDataType'=>'4');

// 调用远程函数
  
$string = $client->Call('GetITFBasisData',$aryPara);  

//print_r($string); die ;
$arr = array();
//print_r( $string['GetNCCBasicDataResult']['diffgram']['NCCCTLocBasicData']['GetHosCtlocData'][46]['DEPT_NAME'] );
$arr = $string['GetITFBasisDataResult']['diffgram']['ITFCTLOCBasisData']['GetITFHosCtlocData'];

//print_r($arr);

$connection_string = 'DRIVER={SQL Server};SERVER=127.0.0.1;DATABASE=HicisData'; 
$user = 'sa'; 
$pass = '87788393'; 
$connection = odbc_connect( $connection_string, $user, $pass )   or   die("数据库连接失败！！！");

for($i=0;$i<count($arr);$i++){
	if ($arr[$i]['IS_OP_IP'] == '2' && $arr[$i]['SPEC_TYPE']=='1' && substr($arr[$i]['SPEC_CODE'],strlen($arr[$i]['SPEC_CODE'])-1,1) !='0') {//住院  并 临床科室
		//echo $arr[$i]['SPEC_NAME'].'----'.$arr[$i]['SPEC_CODE'].'<br>';
		$datano= "'".$arr[$i]['SPEC_CODE']."'";
		$data_name= "'".$arr[$i]['SPEC_NAME']."'";
		
		if (ioru($datano) == 'insert') {
			$sql = "insert into District_dict (datano ,data_code,data_name ,displayName,py) values (".$datano.",".$datano.",".$data_name.",".$data_name.",1)" ;
			$e=odbc_do($connection,iconv("utf-8","GB2312",$sql));
			} else {
				$sql = "update District_dict set  data_name=".$data_name." ,displayName=".$data_name." where datano = ".$datano ;
				$e=odbc_do($connection,iconv("utf-8","GB2312",$sql));
				
				}
		
		
		}
	
	}

function ioru($str){
	 $connection_string = 'DRIVER={SQL Server};SERVER=127.0.0.1;DATABASE=HicisData'; 
	 $user = 'sa'; 
	 $pass = '87788393'; 
	 $connection = odbc_connect( $connection_string, $user, $pass )   or   die("数据库连接失败！！！");
	 $sql = "select count(datano) t from District_dict where datano = ".$str ;
	 $e=odbc_do($connection,iconv("utf-8","GB2312",$sql));
	 if(odbc_result ($e,'t') >0) {
		  return 'update';
		 } else {
			 return 'insert';
			 }
	 
	}

/*$xml = new DOMDocument();

$xml->loadXML($string); 

			$depts = $xml->getElementsByTagName( "GetITFHosCtlocData" );

			foreach( $depts as $dept )
			{
				
				echo  $dept->getElementsByTagName("SPEC_NAME")->item(0)->nodeValue."<br>";
				
				} */

if(!$err = $client->getError())  
{  
        echo "The server return:".$string;  
	    
}  
else  
    echo "ERROR:".$err;  
	
	
	
	
	
echo "<script>window.close();</script>";
      
/*echo '<p/>';  
echo 'Request:';  
echo '<pre>',htmlspecialchars($client->request,ENT_QUOTES),'</pre>';  
echo 'Response:';  
echo '<pre>',htmlspecialchars($client->response,ENT_QUOTES ),'</pre>';  

echo '--------------------<br>';



print_r($string);

echo '<br>----<br>';
echo strpos($client->response,'<');

echo '<br>----<br>';
 echo substr($client->response,250);*/
?> 