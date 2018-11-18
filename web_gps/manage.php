<?php
/**************************************

Author:Han.zhihong
remark:
所有管理功能的入口

***************************************/
require_once("module/Smarty-3.1.16/libs/Smarty.class.php");
require_once("module/mysql.m.php");
require_once("module/session.m.php");
require_once("_config.php");

//////////////////////////////////////////////////////////////////////
//获取SESSION的各种值
//获取功能单元,将内容放入session里
$ary_info=zhPhpSessionVal('ary_info');

if(is_null($ary_info))
{
	echo '<a href="index.php">go to index</a><br />';
	echo'no login';
	exit; 
}
if(0==strcmp($ary_info['n_autoid'],''))
{
	echo '<a href="index.php">go to index</a><br />';
	echo'no username';
	zhPhpSessionRemove('ary_info');
	exit; 
}

//////////////////////////////////////////////////////////////////////
//打开数据库
$db=new PzhMySqlDB();		
$db->open_mysql(cfg_db_host,cfg_db_name,cfg_db_username,cfg_db_passwd);
$db->query("select * from tb_coodr_dev where user_autoid=".$ary_info['n_autoid'],0,0);
$ary_device=array();
while($rs=$db->read())
{
	//设备列表
	$ary_device[]=array('autoid'=>$rs['autoid'],
					  'post_coodr_id'=>$rs['post_coodr_id'],
					  'remark'=>$rs['remark'],
					  'uptime'=>$rs['uptime']);
}

$db->query('call sp_getdev_info('.$ary_info['n_autoid'].')',0,0);
if($rs=$db->read())
{
	//设备列表
	$ary_ev=array('account'=>$rs['account'],
					  'vip_deadline'=>$rs['vip_deadline'],
					  'max_dev'=>$rs['max_dev'],
					  'dev_count'=>$rs['dev_count']);
}

//var_dump($ary_ev);
$max_dev=$ary_ev['max_dev'];
$dev_count=$ary_ev['dev_count'];

$db->close();

//显示页面
$smarty = new Smarty;
$smarty->force_compile = smarty_force_compile;
$smarty->debugging = smarty_debugging;
$smarty->caching = smarty_caching;
$smarty->cache_lifetime = smarty_cache_lifetime;

//常用信息
$smarty->assign("account",$ary_info['sz_account']);
$smarty->assign("userid",$ary_info['n_autoid']);

$smarty->assign("ary_device",$ary_device);

$smarty->assign("surplus_dev",$max_dev-$dev_count);

$smarty->display('manage.tpl');

?>