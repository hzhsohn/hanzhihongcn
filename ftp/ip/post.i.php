<?php
require_once("connection.m.php");
require_once("encode.m.php");


function getIP() /*获取客户端IP*/ 
{ 
if (@$_SERVER["HTTP_X_FORWARDED_FOR"]) 
$ip = $_SERVER["HTTP_X_FORWARDED_FOR"]; 
else if (@$_SERVER["HTTP_CLIENT_IP"]) 
$ip = $_SERVER["HTTP_CLIENT_IP"]; 
else if (@$_SERVER["REMOTE_ADDR"]) 
$ip = $_SERVER["REMOTE_ADDR"]; 
else if (@getenv("HTTP_X_FORWARDED_FOR")) 
$ip = getenv("HTTP_X_FORWARDED_FOR"); 
else if (@getenv("HTTP_CLIENT_IP")) 
$ip = getenv("HTTP_CLIENT_IP"); 
else if (@getenv("REMOTE_ADDR")) 
$ip = getenv("REMOTE_ADDR"); 
else 
$ip = "Unknown"; 
return $ip; 
} 

echo '<?xml version="1.0" encoding="utf-8"?>';
$title=$_REQUEST['title'];
if(0==strcmp($title,''))
{
	echo '<post result="false" msg="no server title"></post>';
	exit;
}
$title=zhTrSql($title);

//数据库路径
$db_path=realpath('myip_db.mdb');
$ipv=getIP();

ob_clean();
$db=new CzhDB();
$db->open_access($db_path);
$db->query("select*from s_iplist where title='$title'");
if($db->read())
{
	$sql="update s_iplist set ipv='$ipv',uptime=now() where title='$title'";
	if($db->query($sql,0,0))
	{
		echo '<post result="true" msg="update success"></post>';
	}
	else
	{
		echo '<post result="false" msg="database error"></post>';
	}
}
else
{
	$sql="insert into s_iplist(ipv,title) values('$ipv','$title')";
	if($db->query($sql,0,0))
	{
		echo '<post result="true" msg="insert success"></post>';
	}
	else
	{
		echo '<post result="false" msg="database error"></post>';
	}
}
$db->close();

?>