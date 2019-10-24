<?php 
require_once("nusoap/lib/nusoap.php");
 
function HIPMessageServer($action,$message)  
{  
	$client = new soapclient('https://api.ums86.com:9600/sms_hb/services/Sms?wsdl',true);  
	$param = array( 'In0'=>$In0,
				'In1'=>$In1,
				'In2'=>$In2,
				'In3'=>$In3,
				'In4'=>$In4,
				'In5'=>$In5,
				'In6'=>$In6,
				'In7'=>$In7,
				'In8'=>$In8,
				'In9'=>$In9,
				'In10'=>$In10); 
			$string = $client->Call('SmsResponse',array('SmsResponse' => $param)); 
	return $string; 
}  


function send($In0,$In1,$In2,$In3,$In4,$In5,$In6,$In7,$In8,$In9,$In10) {  
        $params = array(  
				'SpCode'=>$In0,
				'LoginName'=>$In1,
				'Password'=>$In2,
				'MessageContent'=>iconv("UTF-8", "GB2312//IGNORE", $In3),
				'UserNumber'=>$In4,
				'SerialNumber'=>$In5,
				'ScheduleTime'=>$In6,
				'f'=>$In7
        );  
        $data = http_build_query($params);  
        $res = iconv('GB2312', 'UTF-8//IGNORE',_httpClient($data));  
        //$resArr = array();  
        //parse_str($res, $resArr);  
		echo $res;
        if (!empty($resArr) && $resArr["result"] == 0) 
		{ 
			print_r($resArr);
		}
        else {  
            //if (empty($this->errorMsg)) $this->errorMsg = isset($resArr["description"]) ? $resArr["description"] : '未知错误';  
            echo 1111;
			//return false;  
        }  
    }  
    //send();  
      
    /** 
     * POST方式访问接口 
     * @param string $data 
     * @return mixed 
     */  
    function _httpClient($data) {  
        try {  
            $ch = curl_init();  
            curl_setopt($ch, CURLOPT_URL,"http://gd.ums86.com:8899/sms/Api/Send.do");  
            curl_setopt($ch, CURLOPT_HEADER, 0);  
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
            curl_setopt($ch, CURLOPT_POST, 1);  
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);  
            $res = curl_exec($ch);  
            curl_close($ch);  
            return $res;  
        } catch (Exception $e) {  
            //$this->errorMsg = $e->getMessage();  
            return false;  
        }  
    }  
  
 
$server = new Soap_Server;  
$server->configureWSDL('send');  
$server->register('send',
	array(
		"in0"=>"xsd:string",
		"in1"=>"xsd:string",
		"in2"=>"xsd:string",
		"in3"=>"xsd:string",
		"in4"=>"xsd:string",
		"in5"=>"xsd:string",
		"in6"=>"xsd:string",
		"in7"=>"xsd:string",
		"in8"=>"xsd:string",
		"in9"=>"xsd:string",
		"in10"=>"xsd:string"
	),
	array("SmsResponse"=>"xsd:string"));  
  
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA)? $HTTP_RAW_POST_DATA:'';  
  
$server->service($HTTP_RAW_POST_DATA);  
  
?>