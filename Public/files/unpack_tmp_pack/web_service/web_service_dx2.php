<?php 
function send() {  
        $params = array(  
				'SpCode'=>'242899',
				'LoginName'=>'admin0',
				'Password'=>'admin3622',
				'MessageContent'=>iconv("UTF-8", "GB2312//IGNORE", '验证码是123切勿告知他人11请尽快在页面中输入以完成验证aa15分钟内有效22'),
				'UserNumber'=>'13635241204',
				'SerialNumber'=>'12345678912345678921',
				'ScheduleTime'=>'201804101910',
				'f'=>'1'
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
    send();  
      
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
?>