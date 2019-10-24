<?php 
header('Content-type: text/json;charset=utf-8');

foreach ($_GET as $key=>$value)  
{
list($return_code, $return_content) = http_post_data("http://localhost:8080/web_service/web_post.php", $value); 

   }

 
function http_post_data($url, $data_string) {  
  
        $ch = curl_init();  
        curl_setopt($ch, CURLOPT_POST, 1);  
        curl_setopt($ch, CURLOPT_URL, $url);  
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(  
            'Content-Type: application/json; charset=utf-8',  
            'Content-Length: ' . strlen($data_string))  
        );  
        ob_start();  
        curl_exec($ch);  
        $return_content = ob_get_contents();  
        ob_end_clean();  
  
        $return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);  
        return array($return_code, $return_content);  
    }  

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