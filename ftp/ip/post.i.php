<?php

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
$ipv=getIP();

ob_clean();

date_default_timezone_set('PRC'); //获取系统时间
define("_now",date("Y-m-d H:i:s",time()));


//------------
$fp=@fopen("./db.txt","r");
if($fp)
{fscanf($fp,"%s",$json);}
@fclose($fp);

$fp=fopen("./db.txt","w");
$json=json_decode($json, true);
//var_dump($json);
$json["$title"]=array('ipv'=>$ipv,'uptime'=>_now);
$strJ=json_encode($json);
//echo $strJ;
fprintf($fp,"%s",$strJ);
fclose($fp);

echo '<post result="true" msg="update success"></post>';
//'<post result="false" msg="database error"></post>';

?>