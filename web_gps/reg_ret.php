<?php
/**************************************

Author:Han.zhihong
remark:
注册

***************************************/
require_once("module/Smarty-3.1.16/libs/Smarty.class.php");
require_once("_config.php");
require_once("module/mysql.m.php");
require_once("module/encode.m.php");

$isregok=0;

$exc=$_REQUEST['exc'];
$username=$_REQUEST['username'];
$pwd=$_REQUEST['pwd1'];
$question=$_REQUEST['question'];
$answer=$_REQUEST['answer'];

if($exc=='add')
{
	if($username=='')
	{echo 'username is null';exit;}
	if($pwd=='')
	{echo 'pwd is null';exit;}
	if($question=='')
	{echo 'question is null';exit;}
	if($answer=='')
	{echo 'answer is null';exit;}
	
	$username=zhPhpTrSql($username);
	$question=zhPhpTrSql($question);
	$answer=zhPhpTrSql($answer);
	$pwd=md5($pwd);
	$pwd=md5($pwd);
	//////////////////////////////////////////////////////////////////////
	//打开数据库
	$db=new PzhMySqlDB();		
	echo cfg_db_host,cfg_db_name,cfg_db_username,cfg_db_passwd;
	$db->open_mysql(cfg_db_host,cfg_db_name,cfg_db_username,cfg_db_passwd);
	echo "call sp_reg('$username','$pwd','$question','$answer',1)";
	$db->query("call sp_reg('$username','$pwd','$question','$answer',1)",0,0);
	if($rs=$db->read())
	{
		//设备列表
		$result=$rs['result_'];
	}
		
	$db->close();
}

//显示页面
$smarty = new Smarty;
$smarty->force_compile = smarty_force_compile;
$smarty->debugging = smarty_debugging;
$smarty->caching = smarty_caching;
$smarty->cache_lifetime = smarty_cache_lifetime;

$smarty->assign("result",$result);
$smarty->display('reg_ret.tpl');

?>