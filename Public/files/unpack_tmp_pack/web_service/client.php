<?php 
require_once("nusoap/lib/nusoap.php");

$client = new soapclient('http://localhost:8080/web_service/web_service.php?wsdl',true);  

$xmlStr = "
<Main><VISIT_ID>3758410</VISIT_ID><Pattype>住院</Pattype><PatHosId>1158541</PatHosId><InHosSum>1</InHosSum><REG_NO>01330379</REG_NO><Patname>郑燕</Patname><NAME_PHONETIC>ZHENG YAN</NAME_PHONETIC><sex>女</sex><Birthday>1963-01-04</Birthday><ID_NO>140311196301040043</ID_NO><Address>山西省阳泉市城区德胜东街11号1楼2单元10户</Address><PhoneS>13403534258</PhoneS><CITIZENSHIP>ZG-中国</CITIZENSHIP><BIRTH_PLACE>SXS-山西省</BIRTH_PLACE><NATION>HZ-汉族</NATION><CurrentDistno>1070600</CurrentDistno><CurrentDist>放疗科2病房</CurrentDist><Currentdeptno>1070601</Currentdeptno><Currentdept>放疗科2</Currentdept><BedNo></BedNo><wardNo></wardNo><ACTION>C</ACTION><ACTION_USER>钟锋</ACTION_USER><ADMISSION_DATE_TIME>2014-04-09 13:54:46</ADMISSION_DATE_TIME><DIAGNOSIS></DIAGNOSIS><Chadoctor></Chadoctor><Chadoctorno></Chadoctorno></Main>
"	;
	/*

	$xml = new DOMDocument();

	$xml->loadXML($xmlStr);
	$ORDs = $xml->getElementsByTagName( "ORD" );
	foreach( $ORDs as $ORD )
	{
		$DocAdvice_fora = $ORD->getElementsByTagName( "DocAdvice" )->item(0)->nodeValue;
		echo $DocAdvice_fora.',';
		 //$k=odbc_do($connection,"insert into aaa (a) values ('".iconv("utf-8","GB2312",$DocAdvice_fora)."')");//把串存在aaa表中
	}
	
	
	*/	
	
			
$parameters = array($xmlStr,'1');  
  
$string = $client->call('strings',$parameters);  
  
if(!$err = $client->getError())  
{  
        echo "The server return:".$string;  
}  
else  
    echo "ERROR:".$err;  
      
echo '<p/>';  
echo 'Request:';  
echo '<pre>',htmlspecialchars($client->request,ENT_QUOTES),'</pre>';  
echo 'Response:';  
echo '<pre>',htmlspecialchars($client->response,ENT_QUOTES ),'</pre>';  

echo '--------------------<br>';

/*echo "<script language='javascript' type='text/javascript'> alert('".$string."')</script>" ;*/

echo $string;

?> 