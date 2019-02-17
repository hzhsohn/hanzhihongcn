<?php
/**************************************

Author:Han.zhihong
remark:
数据显示页

***************************************/

require_once("module/Smarty-3.1.16/libs/Smarty.class.php");
require_once("module/verifycode.m.php");
require_once("module/session.m.php");
require_once("module/mysql.m.php");
require_once("_config.php");


//显示页面
$smarty = new Smarty;
$smarty->force_compile = smarty_force_compile;
$smarty->debugging = smarty_debugging;
$smarty->caching = smarty_caching;
$smarty->cache_lifetime = smarty_cache_lifetime;


$scan_key=$_SERVER['QUERY_STRING'];
if(0==strcmp($scan_key,''))
{
  	$ret=1;
$smarty->assign("ret",$ret);
$smarty->display('index.tpl');
	exit;
}

$db=new PzhMySqlDB();		
$db->open_mysql(cfg_db_host,cfg_db,cfg_db_username,cfg_db_passwd);
$db->query("select*from tb_board where scan_key='$scan_key'",0,0);
if($rs=$db->read())
{
	//var_dump($rs);
 	$j=json_decode($rs['json'],true);
}
if(null==$j)
{
	$ret=2;
$smarty->assign("ret",$ret);
$smarty->display('index.tpl');
	exit;
}
//var_dump($j);

$db->query("select*from tb_append where scan_key='$scan_key'",0,0);
$l=array();
while($rs=$db->read())
{
 	$l[]=json_decode($rs['json'],true);
}
$db->close();
//var_dump($l);

$smarty->assign("j",$j);
$smarty->assign("l",$l);
$smarty->assign("ret",$ret);
$smarty->display('index.tpl');

?>