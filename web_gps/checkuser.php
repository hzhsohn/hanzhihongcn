<?php
/**************************************

Author:Han.zhihong
remark:
检查用户是否存在

***************************************/
require_once("module/mysql.m.php");
require_once("_config.php");
	
$account=$_REQUEST['account'];

if($account=='')
{
  echo 'account is null';
  exit;
}
	
$db=new PzhMySqlDB();		
$db->open_mysql(cfg_db_host,cfg_db_name,cfg_db_username,cfg_db_passwd);

$db->query("select count(autoid) from tb_userlist where account='$account'",0,0);
if($rs=$db->read())
{
   echo (0==$rs[0])?1:2;//1可以注册,2不可以注册
}	
$db->close();

?>
