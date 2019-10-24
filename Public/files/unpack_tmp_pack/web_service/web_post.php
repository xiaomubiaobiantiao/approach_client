<?php 
header('Content-type: text/json;charset=utf-8');

$postStr = isset($GLOBALS["HTTP_RAW_POST_DATA"])?$GLOBALS["HTTP_RAW_POST_DATA"]:"";
logger('http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].(empty($_SERVER['QUERY_STRING'])?"":("?".$_SERVER['QUERY_STRING'])),'1',$_GET['sid']);
logger($postStr,'2',$_GET['sid']);

foreach ($_GET as $key=>$value)  
{
    logger("_GET: Key: $key; Value: $value",'3',$_GET['sid']);
}
foreach ($_POST as $key=>$value)  
{
    logger("_POST: Key: $key; Value: $value",'3',$_GET['sid']);
}


//日志记录
function logger($log_content,$type,$id)
{
	if($type=='1'){
		$sql="insert into json_log(url,write_date) values('".$log_content."',getdate())";
	}
	if($type=='2'){
		$sql="insert into json_data(json_text,sendid,write_date) values('".$log_content."','".$id."',getdate())";
	}
	if($type=='3'){
		$sql="insert into json_other(textstr,write_date) values('".$log_content."',getdate())";
	}
	$connection_string = 'DRIVER={SQL Server};SERVER=127.0.0.1;DATABASE=HicisData_new'; 
	$user = 'sa'; 
	$pass = 'sfdl9898'; 
	$connection = odbc_connect( $connection_string, $user, $pass )   or   die("数据库连接失败！！！"); 
	$k=odbc_do($connection,iconv("utf-8","gbk//IGNORE",$sql));
}

// $arr = array(  
	// 'Response'=>array(
		// 'Header'=>array(
			// 'SourceSystem'=>'',
			// 'MessageID'=>'',
			// ),
		// 'Body'=>array(
			// 'ResultCode'=>'0',
			// 'ResultContent'=>'成功',
			// )
		// )
   
// );  
  
// echo json_encode($arr);  

echo '{
  “Response”:{
    "Header":{
        "SourceSystem":"",
        "MessageID":""
    },
    "Body":{
        "ResultCode":"0",
        "ResultContent":"成功"
}
  }
}';
?>