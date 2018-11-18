<?php
/**************************************

Author:Han.zhihong
remark:
新设备

***************************************/
require_once("module/Smarty-3.1.16/libs/Smarty.class.php");
require_once("module/verifycode.m.php");
require_once("module/mysql.m.php");
require_once("module/session.m.php");
require_once("module/encode.m.php");
require_once("_config.php");
require_once "module/phpqrcode/qrlib.php"; 

date_default_timezone_set('PRC'); 

//获取SESSION的各种值
$ary_info=zhPhpSessionVal('ary_info');

if(is_null($ary_info))
{
echo'no login';
exit; 
}
if(0==strcmp($ary_info['n_autoid'],''))
{
echo'no username';
zhPhpSessionRemove('ary_info');
exit; 
}


//////////////////////////////////////////////////////////////////////
//打开数据库
$db=new PzhMySqlDB();		
$db->open_mysql(cfg_db_host,cfg_db_name,cfg_db_username,cfg_db_passwd);
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

//-------------------------------------------------------
//模版页面
$smarty = new Smarty;
$smarty->force_compile = smarty_force_compile;
$smarty->debugging = smarty_debugging;
$smarty->caching = smarty_caching;
$smarty->cache_lifetime = smarty_cache_lifetime;

//常用信息
$smarty->assign("account",$ary_info['sz_account']);
$smarty->assign("userid",$ary_info['n_autoid']);
$smarty->assign("surplus_dev",$max_dev-$dev_count);

//QE
$checksum=rand(10,100)*7; //可以整除7的数,就是合格数据
$qr_data=date("ymdHis",time()).'-'.$checksum;
$smarty->assign("qr_data",$qr_data);

$smarty->display('newdev.tpl');

?>