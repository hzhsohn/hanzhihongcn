<?php
/**************************************

Author:Han.zhihong
remark:
成员管理的入口

***************************************/
require_once("module/Smarty-3.1.16/libs/Smarty.class.php");
require_once("module/verifycode.m.php");
require_once("module/session.m.php");
require_once("_config.php");

$username=NULL;

//检测是否已经登录.如果SESSION有问题即要重新登录
$userinfo=json_decode(zhPhpSessionVal('userinfo'));
if(!is_null($userinfo))
{
  //用户名不为空
  $username=$userinfo->sz_userid;
  if(strcmp($username,''))
  {
    echo '<meta http-equiv="refresh" content="0;url=sign_in.php?method=pass">';
    //header("Location: sign_in.php?method=pass"); 
  }
}

//显示页面
$smarty = new Smarty;
$smarty->force_compile = smarty_force_compile;
$smarty->debugging = smarty_debugging;
$smarty->caching = smarty_caching;
$smarty->cache_lifetime = smarty_cache_lifetime;

$smarty->assign("username",$username);
$smarty->display('login.tpl');

?>