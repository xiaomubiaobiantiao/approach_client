<?php 
require_once("nusoap/lib/nusoap.php");


 
$client = new soapclient('http://16.22.25.52/trakcarelive/trak/web/WebServiceGR.NCCWSInterface.cls?wsdl',true);

$client->soap_defencoding = 'UTF-8';
$client->decode_utf8 = false;

require_once("../conn/conn.php");
require_once("../function/function.php");

## 入参：
## RegNo：    		就诊卡号
## MedNo：    		病案号
## RowID：   		异常信息记录ID（感染系统）
## SubDate：  		报告日期
## RptType    		异常类型
## RptString：   	异常内容（项目名称+结果+参考范围——暂定）


## 返回值：
## 	-101^ 	//就诊卡号和病历号同时为空
## 	-102^ 		// 异常标记类型为空
## 	-103^"    // ID号为空
## 	-104^ 		// 异常描述为空
## 	-105^ 		// 报告日期为空
## 	-106^     //没有找到患者信息


//住院传染病推送
$sql = "exec crb '".date('Y-m-d')."','".date('Y-m-d')."'";
//$sql = "exec crb '2014-06-13','2014-06-13'";
//$sql = "exec crb '2013-09-01','2013-09-25'";
$res = odbc_exec($connection,utf8togb2312($sql));
$RowCount=odbc_num_rows($res);
$arr ='';
while($result = odbc_fetch_array($res)){
	// 参数转为数组形式传递
	$aryPara = array('RegNo'=>gb2312toutf8($result['reg_no']),'MedNo'=>gb2312toutf8($result['pathosid']),'RowID'=>gb2312toutf8($result['orderno']),'SubDate'=>substr(gb2312toutf8($result['ttime']),0,10),'RptType'=>gb2312toutf8($result['targetsetname']),'RptString'=>gb2312toutf8($result['text']));
	
	// 调用远程函数  
	$string = $client->Call('InsertCRUnNormalCheck',$aryPara);	
	$flag = $string['InsertCRUnNormalCheckResult'];
	$arr .= "UPDATE ItemsPatinfo SET flag = '".$flag."' WHERE orderno = '".gb2312toutf8($result['orderno'])."';";			
}
$res = odbc_exec($connection,utf8togb2312($arr));

//门诊传染病推送
$sql = "exec pro_web_yg_crb_mz '".date('Y-m-d')."','".date('Y-m-d')."'";
//$sql = "exec pro_web_yg_crb_mz '2014-07-01','2014-07-31'";
$res = odbc_exec($connection,utf8togb2312($sql));
$RowCount=odbc_num_rows($res);
$arr ='';
while($result = odbc_fetch_array($res)){
	// 参数转为数组形式传递
	$aryPara = array('RegNo'=>gb2312toutf8($result['reg_no']),'MedNo'=>gb2312toutf8($result['pathosid']),'RowID'=>gb2312toutf8($result['orderno']),'SubDate'=>substr(gb2312toutf8($result['ttime']),0,10),'RptType'=>gb2312toutf8($result['targetsetname']),'RptString'=>gb2312toutf8($result['text']));
	
	// 调用远程函数  
	$string = $client->Call('InsertCRUnNormalCheck',$aryPara);	
	$flag = $string['InsertCRUnNormalCheckResult'];
	$arr .= "UPDATE ItemsPatinfo SET flag = '".$flag."' WHERE orderno = '".gb2312toutf8($result['orderno'])."';";	
	//echo $flag."---";	
	//var_dump( gb2312toutf8($result['pathosid'])).'------';
}
$res = odbc_exec($connection,utf8togb2312($arr));
die;








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