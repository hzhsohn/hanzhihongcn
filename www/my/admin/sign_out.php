<?php
require_once("../_module/Smarty-3.1.16/libs/Smarty.class.php");
require_once("../_module/session.m.php");

$_SESSION['ADMIN_INFO']=NULL;

//显示页面
$smarty = new Smarty;
$smarty->force_compile = false;
$smarty->debugging = false;
$smarty->caching = false;
$smarty->cache_lifetime = 120;

//$smarty->assign('err',$err);
$smarty->display('sign_out.tpl');

?>
