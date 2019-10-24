<?php 

$url="https://api.ums86.com:9600/sms/Api/Send.do";
/*$param = array( 'In0'=>'242899',
				'In1'=>'admin0',
				'In2'=>'admin3622',
				'In3'=>'验证码是123切勿告知他人11请尽快在页面中输入以完成验证aa15分钟内有效22',
				'In4'=>'13635241204',
				'In5'=>'12345678912345678920',
				'In6'=>'20180410183800',
				'In7'=>'1',
				'In8'=>'',
				'In9'=>'',
				'In10'=>''); */
				
$param = array( 'SpCode'=>'242899',
'LoginName'=>'11111',
'Password'=>'admin3622',
'MessageContent'=>iconv("UTF-8", "GB2312//IGNORE", '验证码是123切勿告知他人11请尽快在页面中输入以完成验证aa15分钟内有效22'),
'UserNumber'=>'13635241204',
'SerialNumber'=>'12345678912345678921',
'ScheduleTime'=>'201804101910',
'f'=>'1');
$data = http_build_query($param);  
 $ch = curl_init();  
curl_setopt($ch, CURLOPT_POST, 1);  
curl_setopt($ch, CURLOPT_URL, $url);  
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);  
curl_setopt($ch, CURLOPT_HTTPHEADER, array(  
	'Content-Type: application/json; charset=utf-8',  
	'Content-Length: ' . strlen($data))  
);  
ob_start();  
curl_exec($ch);  
$return_content = ob_get_contents();  
ob_end_clean();  

$return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);  
echo $return_code;
	//return array($return_code, $return_content);   
/*
$url="https://api.ums86.com:9600/sms_hb/services/Sms";
$data='<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
   <soapenv:Header/>
   <soapenv:Body>
      <HIPMessageServer soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
         <in0 xsi:type="xsd:string">242899</in0>
         <in1 xsi:type="xsd:string">admin0</in1>
         <in2 xsi:type="xsd:string">admin3622*</in2>
         <in3 xsi:type="xsd:string">验证码是123切勿告知他人11请尽快在页面中输入以完成验证aa15分钟内有效22</in3>
         <in4 xsi:type="xsd:string">13635241204</in4>
         <in5 xsi:type="xsd:string">12345678912345678919</in5>
         <in6 xsi:type="xsd:string">2018041015410</in6>
         <in7 xsi:type="xsd:string">1</in7>
         <in8 xsi:type="xsd:string"></in8>
         <in9 xsi:type="xsd:string"></in9>
         <in10 xsi:type="xsd:string"></in10>
      </HIPMessageServer>
   </soapenv:Body>
</soapenv:Envelope>';
$arr_header[] = "Content-type: text/xml"; //使用xml格式传递

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
// curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
// curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
if (!empty($data)){
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
}
if(!empty($arr_header)){
curl_setopt($curl, CURLOPT_HTTPHEADER, $arr_header);
}
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($curl);
curl_close($curl);
echo 1111;
print_r( $output);
 */ 
?>