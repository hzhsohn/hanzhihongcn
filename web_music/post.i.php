<?php

require_once("module/Smarty-3.1.16/libs/Smarty.class.php");
require_once("module/session.m.php");
require_once("module/mysql.m.php");
require_once("_config.php");

header("content-type:text/html;charset=utf-8");

//获取客户端IP
function getIP()  
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

//---------------------------------------------------
$parameter=$_SERVER['QUERY_STRING'];
if(0==strcmp($parameter,''))
{
  echo 'not exist parameter.';
	exit;
}
$parameter=base64_decode($parameter);
$ipv=getIP();
//---------------------------------------
//接收到的字符串 {"_scan":"http://127.0.0.1?a001","_act":"update","operater":"","time":"2018-12-20","batch":"","place":""}
//第一个字符为下划线的参数为必备参数
//_scan扫描枪的内容
//_act为数据添加动作,update或append ,update为更新,append为追加
$_scanKey='';
$_act='';

$json=json_decode($parameter, true);
if(null==$json)
{
  echo '{"ret":"json_error"}';
  exit;
}
$_act=$json['_act'];
//var_dump($json);

//获取扫描出来的key值
$url = parse_url($json['_scan']);
$_scanKey=$url['query'];
//var_dump($url);

//删除必备参数,然后存到数据库
unset($json['_scan']);
unset($json['_act']);
//$strJ=$parameter;
$strJ=json_encode($json, JSON_UNESCAPED_UNICODE); //必须PHP5.4+
//------------------------------------
if('update'==$_act)
{
    $db=new PzhMySqlDB();		
    $db->open_mysql(cfg_db_host,cfg_db,cfg_db_username,cfg_db_passwd);
    $db->query("call sp_add_data(1,'$ipv','$_scanKey','$strJ')",0,0);
    if($rs=$db->read())
    {
      if(1==$rs[0])
      {      
        echo '{"ret": "ok","_act":"update"}';
      }
      elseif(2==$rs[0])
      {
        //不存在于数据库的key输出invalid
        echo '{"ret": "invalid","_act":"update"}'; 
      }
    }
    $db->close();
}
else if('append'==$_act)
{
    $db=new PzhMySqlDB();		
    $db->open_mysql(cfg_db_host,cfg_db,cfg_db_username,cfg_db_passwd);
    $db->query("call sp_add_data(2,'$ipv','$_scanKey','$strJ')",0,0);
    if($rs=$db->read())
    {
      if(1==$rs[0])
      {
          echo '{"ret": "ok","_act":"append"}';
      }
      elseif(2==$rs[0])
      {
        //不存在于数据库的key输出invalid
        echo '{"ret": "invalid","_act":"append"}'; 
      }
      elseif(3==$rs[0])
      {
        //同样内容的记录已经存在
        echo '{"ret": "repeat","_act":"append"}'; 
      }
    }
    $db->close();
}
?>
