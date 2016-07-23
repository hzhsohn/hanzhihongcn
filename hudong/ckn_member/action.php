<?php
/**************************************

Author:Han.zhihong
remark:
激活账号功能
***************************************/
require_once("module/Smarty-3.1.16/libs/Smarty.class.php");
require_once("module/verifycode.m.php");
require_once("module/session.m.php");
require_once("_config.php");

$username=$_REQUEST['username'];

//显示页面
$smarty = new Smarty;
$smarty->force_compile = smarty_force_compile;
$smarty->debugging = smarty_debugging;
$smarty->caching = smarty_caching;
$smarty->cache_lifetime = smarty_cache_lifetime;

$smarty->assign("userid",$userid);

$smarty->display('action.tpl');

?>