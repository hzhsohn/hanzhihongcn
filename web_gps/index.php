<?php
/**************************************

Author:Han.zhihong
remark:
功能入口

***************************************/
require_once("module/Smarty-3.1.16/libs/Smarty.class.php");
require_once("module/verifycode.m.php");
require_once("module/session.m.php");
require_once("_config.php");

//检测是否已经登录.如果SESSION有问题即要重新登录

//获取SESSION的各种值
$ary_info=zhPhpSessionVal('ary_info');

$showAutoLogin=false;
if(!is_null($ary_info))
{
  //用户名不为空
  $userid=$ary_info['n_autoid'];
  if(strcmp($userid,''))
  {
    echo '<meta http-equiv="refresh" content="0;url=manage.php">';
    //header("Location: sign_in.php?method=pass"); 
    exit;
  }
}
else
{
  //自动登录
  $account=$_COOKIE['dingwei_auto_u'];
  if(strcmp($account,''))
  {
    $showAutoLogin=true;
  }
}

//显示页面
$smarty = new Smarty;
$smarty->force_compile = smarty_force_compile;
$smarty->debugging = smarty_debugging;
$smarty->caching = smarty_caching;
$smarty->cache_lifetime = smarty_cache_lifetime;

$smarty->assign("showAutoLogin",$showAutoLogin);
$smarty->assign("account",$account);
$smarty->display('index.tpl');

?>