<?php
$mysqli=new mysqli('localhost','root','956246','stu_admin');
if($mysqli->connect_errno){
	die('数据库连接错误'.$mysqli->connect_error);
	$mysqli->close();
}

$mysqli->set_charset('utf8');
?>
