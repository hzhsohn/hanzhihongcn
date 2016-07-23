<?php
/**************************************

Author:Han.zhihong
remark:
登出系统的功能

***************************************/
require_once("module/Smarty-3.1.16/libs/Smarty.class.php");
require_once("module/session.m.php");
require_once("_config.php");

//清空
setcookie('cloudkon_auto_u','',time()-cookies_time); 
setcookie('cloudkon_auto_p','',time()-cookies_time); 
//清空SESSION,用户信息是JSON,结构请看登录模块
zhPhpSessionSet('userinfo','');

//重定向浏览器
//header("Location: index.php"); 
//echo '<meta http-equiv="refresh" content="2;url=index.php">';
	
//显示页面
$smarty = new Smarty;
$smarty->force_compile = smarty_force_compile;
$smarty->debugging = smarty_debugging;
$smarty->caching = smarty_caching;
$smarty->cache_lifetime = smarty_cache_lifetime;

$smarty->display('sign_out.tpl');

?>