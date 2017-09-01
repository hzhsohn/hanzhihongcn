<?php
require_once("../_module/Smarty-3.1.16/libs/Smarty.class.php");
require_once('../_module/mysql.m.php');
require_once('../_module/encode.m.php');
require_once('../_module/session.m.php');
require_once('_config.php');

//判断登录的SESSION
$userinfo=json_decode($_SESSION['ADMIN_INFO']);
if(is_null($userinfo))
{
	echo '<meta http-equiv="refresh" content="5;url=index.php">';
	echo'no userinfo';
	exit; 
}


$db=new PzhMySqlDB();	
$db->open_mysql(cfg_db_host,cfg_db,cfg_db_username,cfg_db_passwd);

if(0==strcmp($_REQUEST['method'],'delete'))
{
	$username=$_REQUEST['username'];
	$db->query("delete from admin where username='$username'",0,0);
}

//列出数据
$db->query("select*from admin",0,0);
$rs_list=array();
while($rs=$db->read())
{
	$rs_list[]=array(
				'username'=>zhPhpTrHtml($rs['username']),
				'lastlogin'=>zhPhpTrHtml($rs['lastlogin']),
				'ip'=>zhPhpTrHtml($rs['ip']),
				'remark'=>zhPhpTrHtml($rs['remark'])
			);
}	

$db->close();

//显示页面
$smarty = new Smarty;
$smarty->force_compile = smarty_force_compile;
$smarty->debugging = smarty_debugging;
$smarty->caching = smarty_caching;
$smarty->cache_lifetime = smarty_cache_lifetime;

$smarty->assign('username',$userinfo->username);
$smarty->assign('rs_list',$rs_list);
$smarty->display('adminlist.tpl');
?>
