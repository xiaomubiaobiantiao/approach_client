<?php  
$connection_string = 'DRIVER={SQL Server};SERVER=127.0.0.1;DATABASE=test'; 
$user = 'sa'; 
$pass = 'sfdl9898'; 
$connection = odbc_connect( $connection_string, $user, $pass )   or   die("数据库连接失败！！！"); 
?>