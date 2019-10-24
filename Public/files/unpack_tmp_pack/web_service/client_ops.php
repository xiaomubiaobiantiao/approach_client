<?php 
require_once("nusoap/lib/nusoap.php");

$client = new soapclient('http://localhost:8080/web_service/web_service_ops.php?wsdl',true);  

$client->soap_defencoding = 'UTF-8';
$client->decode_utf8 = false;

$xmlStr = "
<OperationInfo>
  <Operation>
    <病案号>1129413</病案号>
    <住院次数>4</住院次数>
    <手术编号>114860</手术编号>
    <手术名称>盆腔恶性肿瘤减瘤术</手术名称>
    <手术间>24手术间</手术间>
    <手术日期>2014.01.03</手术日期>
    <感染>否</感染>
    <姓名>周杰</姓名>
    <性别>女</性别>
    <年龄>45</年龄>
    <病房>妇2-03</病房>
    <巡回护士>刘瑾</巡回护士>
    <手术开始时间>2014.01.03 12:19:00</手术开始时间>
    <手术结束时间>2014.01.03 15:08:00</手术结束时间>
    <主刀>张蓉</主刀>
    <主刀工号>784</主刀工号>
    <助1>雷呈志</助1>
    <上台护士>樊玮璐</上台护士>
    <所在科室编号>1060901</所在科室编号>
    <手术科室>FK2-妇科2</手术科室>
    <手术诊断>盆腔肿物</手术诊断>
    <手术类型>择期手术</手术类型>
    <ASA>Ⅱ</ASA>
    >
    <麻醉开始时间>2014.01.03 11:59:42</麻醉开始时间>
    <麻醉结束时间>2014.01.03 15:18:00</麻醉结束时间>
    <麻醉方法>吸入+静脉麻醉</麻醉方法>
    <失血>200</失血>
    <输血量>0</输血量>
    <切口类型>Ⅱ类（相对清洁手术）</切口类型>
   
    <就诊号>3545312</就诊号>
  </Operation>
</OperationInfo> 
"	;

	
			
$parameters = array($xmlStr,'1');  
  
$string = $client->call('strings',$parameters);   



/*$xml = new DOMDocument();

$s='';
$s = substr($client->response,250);
//echo $s;
$xml->loadXML($s); print_r( $xml);
echo $xml->getElementsByTagName( "Operation" )->item(0)->nodeValue;

			$Operations = $xml->getElementsByTagName( "Operation" );

			foreach( $Operations as $Operation )
			{
				
				echo  $Operation->getElementsByTagName("手术名称")->item(0)->nodeValue."<br>";
				
				} */

if(!$err = $client->getError())  
{  
        echo "The server return:".$string;  
		//print_r($string);
}  
else  
    echo "ERROR:".$err;  
      
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