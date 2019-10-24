<?php 
require_once("nusoap/lib/nusoap.php");

function newmessage($s){
		
		$client = new soapclient('http://16.22.25.52/trakcarelive/trak/web/WebServiceGR.NCCWSInterface.cls?WSDL',true);  
		
		$client->soap_defencoding = 'UTF-8';
		$client->decode_utf8 = false;
		
		
		// 参数转为数组形式传递
		$aryPara = array('EpisodeID'=>$s,'strDataType'=>'GRIF');
		
		// 调用远程函数
		  
		$string = $client->Call('NewMessage',$aryPara);  
		
		
		if(!$err = $client->getError())  
		{  
				//echo "The server return:".$string['NewMessageResult']; 
		}  
		else { 
			//echo "错误:".$err;  
			}
	
	
	}
	
//取消消息

function cancelmessage($s){
	
	
		
		$client = new soapclient('http://16.22.25.52/trakcarelive/trak/web/WebServiceGR.NCCWSInterface.cls?WSDL',true);  
		
		$client->soap_defencoding = 'UTF-8';
		$client->decode_utf8 = false;
		
		
		// 参数转为数组形式传递
		$aryPara = array('EpisodeID'=>$s,'strDataType'=>'GRIF');
		
		// 调用远程函数
		  
		$string = $client->Call('CancelMessage',$aryPara);  
		
		
		if(!$err = $client->getError())  
		{  
				//echo "The server return:".$string['NewMessageResult']; 
		}  
		else { 
			//echo "错误:".$err;  
			}
	
	
	}	
	


## 入参：
## RegNo：    		就诊卡号
## MedNo：    		病案号
## RowID：   		异常信息记录ID（感染系统）
## SubDate：  		报告日期
## RptType    		异常类型(干预信息)
## RptString：   	异常内容
## 发送干预信息
function sendMessage_crb($RegNo,$MedNo,$RowID,$SubDate,$RptType,$RptString){
		//print_r($RegNo.",".$MedNo.",".$RowID.",".$SubDate.",".$RptType.",".$RptString);
		
		$client = new soapclient('http://16.22.25.52/trakcarelive/trak/web/WebServiceGR.NCCWSInterface.cls?wsdl',true);  
		
		$client->soap_defencoding = 'UTF-8';
		$client->decode_utf8 = false;
		
		
		// 参数转为数组形式传递
		$aryPara = array('RegNo'=>$RegNo,'MedNo'=>$MedNo,'RowID'=>$RowID,'SubDate'=>$SubDate,'RptType'=>$RptType,'RptString'=>$RptString);
		
		// 调用远程函数
		  
		$string = $client->Call('InsertCRUnNormalCheck',$aryPara);  
		$flag = $string['InsertCRUnNormalCheckResult'];
		
		if(!$err = $client->getError())  
		{  
				//return $flag ;
				//echo "The server return:".$string['NewMessageResult']; 
		}  
		else { 
			//print_r($string);
			//echo "错误:".$err;  
			}
	
	
	}


## 入参：
## RegNo：    		就诊卡号
## strDataType：    	"CRIF"
## SubDate：   		报卡日期
## RowID    		报卡id
## YJRowID：   		异常信息记录ID（感染系统 传染预警）
## 提交传染病报卡 或者退回
function saveMessage_crb($RegNo,$strDataType,$SubDate,$RowID,$YJRowID,$CRMemo){
		//print_r($RegNo.",".$MedNo.",".$RowID.",".$SubDate.",".$RptType.",".$RptString);
		
		$client = new soapclient('http://16.22.25.52/trakcarelive/trak/web/WebServiceGR.NCCWSInterface.cls?wsdl',true);  
		
		$client->soap_defencoding = 'UTF-8';
		$client->decode_utf8 = false;
		
		
		// 参数转为数组形式传递
		$aryPara = array('RegNo'=>$RegNo,'strDataType'=>$strDataType,'SubDate'=>$SubDate,'RowID'=>$RowID,'YJRowID'=>$YJRowID,'CRMemo'=>$CRMemo);
		
		// 调用远程函数
		  
		$string = $client->Call('CRNewMessage',$aryPara);  
		$flag = $string['CRNewMessageResult'];
		
		if(!$err = $client->getError())  
		{  
				//return $flag;
				//echo "The server return:".$string['NewMessageResult']; 
		}  
		else { 
			//print_r($string);
			//echo "错误:".$err;  
			}
	
}	


## 入参：

## RowID    		报卡id

## 删除传染病报卡
function CRCancelMessage($RowID){
		//print_r($RegNo.",".$MedNo.",".$RowID.",".$SubDate.",".$RptType.",".$RptString);
		
		$client = new soapclient('http://16.22.25.52/trakcarelive/trak/web/WebServiceGR.NCCWSInterface.cls?wsdl',true);  
		
		$client->soap_defencoding = 'UTF-8';
		$client->decode_utf8 = false;
		
		
		// 参数转为数组形式传递
		$aryPara = array('RowID'=>$RowID);

		// 调用远程函数
		  
		$string = $client->Call('CRCancelMessage',$aryPara); 
		
		$flag = $string['CRCancelMessageResult'];
		
		if(!$err = $client->getError())  
		{  
				return $flag;
				//echo "The server return:".$string['NewMessageResult']; 
		}  
		else { 
			//print_r($string);
			//echo "错误:".$err;  
			}
	
}	


//门诊病人信息
function GetAdmPatInfoData($s){
		
		$client = new soapclient('http://16.22.25.52/trakcarelive/trak/web/WebServiceGR.NCCWSInterface.cls?WSDL',true);  
		
		$client->soap_defencoding = 'UTF-8';
		$client->decode_utf8 = false;
		
		
		// 参数转为数组形式传递
		$aryPara = array('EpisodeID'=>$s);
		
		// 调用远程函数
		  
		$string = $client->Call('GetAdmPatInfoData',$aryPara);  
		
		
		if(!$err = $client->getError())  
		{  
				return $string ;
				//echo "The server return:".$string['NewMessageResult']; 
		}  
		else { 
			//echo "错误:".$err;  
			}
	
	
	}


## 入参：

## RowID    		报卡id

## 取消红灯状态
function ClearCRCheckCodes($RowID){
		//print_r($RegNo.",".$MedNo.",".$RowID.",".$SubDate.",".$RptType.",".$RptString);
		$client = new soapclient('http://16.22.25.52/trakcarelive/trak/web/WebServiceGR.NCCWSInterface.cls?wsdl',true);  
		
		$client->soap_defencoding = 'UTF-8';
		$client->decode_utf8 = false;
		
		
		// 参数转为数组形式传递
		$aryPara = array('RowId'=>$RowID);

		// 调用远程函数
		  
		$string = $client->Call('ClearCRCheckCode',$aryPara); 
		
		$flag = $string['ClearCRCheckCodeResult'];
		
		if(!$err = $client->getError())  
		{  
				return $flag;
				//echo "The server return:".$string['NewMessageResult']; 
		}  
		else { 
			//print_r($string);
			//echo "错误:".$err;  
			}
	
}	

	

?> 