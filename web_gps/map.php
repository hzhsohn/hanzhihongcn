<?php
/**************************************

Author:Han.zhihong
remark:
登录模块,SESSION是整站通用的,登录之后获取权限,
用户是根据权限操作整个系统的功能

***************************************/
require_once("module/Smarty-3.1.16/libs/Smarty.class.php");
require_once("module/session.m.php");
require_once("_config.php");
require_once("module/mysql.m.php");

//获取SESSION的各种值
//$ary_info=zhPhpSessionVal('ary_info');

$coodr_dev_autoid=$_REQUEST['did'];

//打开数据库
$db=new PzhMySqlDB();		
$db->open_mysql(cfg_db_host,cfg_db_name,cfg_db_username,cfg_db_passwd);
$db->query("select * from tb_coodr_dev where autoid=".$coodr_dev_autoid,0,0);
if($rs=$db->read())
{
	//设备列表
  $lo=$rs['longitude'];
  $la=$rs['latitude'];
}
$db->close();

if($lo==0 && $la==0)
{
echo '设备未存在定位坐标';
exit;
}

//显示页面
$smarty = new Smarty;
$smarty->force_compile = smarty_force_compile;
$smarty->debugging = smarty_debugging;
$smarty->caching = smarty_caching;
$smarty->cache_lifetime = smarty_cache_lifetime;

$smarty->assign("lo",$lo);
$smarty->assign("la",$la);
$smarty->display('map.tpl');

?>
