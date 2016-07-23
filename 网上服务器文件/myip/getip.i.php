<?php
require_once("connection.m.php");
require_once("encode.m.php");

//数据库路径
$db_path=realpath('myip_db.mdb');

$title=$_REQUEST['title'];

ob_clean();
$db=new CzhDB();
$db->open_access($db_path);

if(strcasecmp($title,""))
{$result=$db->query("select*from s_iplist where title='".$title."'");}

if($result)
{
	
	if($rs=$db->read())
	{
		echo '{"result":true,"msg":"success","serv":{';
		$title=$rs['title']->value;
		$ipv=$rs['ipv']->value;
		$uptime=$rs['uptime']->value;
		echo "\"title\":\"$title\",\"time\":\"$uptime\",\"ip\":\"$ipv\"";
		echo '}}';
	}
	else
	{
		echo '{"result":false,"msg":"not found title"}';
	}
	
}
else
{
	echo '{"result":false,"msg":"data fail"}';
}
$db->close();

?>