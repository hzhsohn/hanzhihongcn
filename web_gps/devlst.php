<?php
/**************************************

Author:Han.zhihong
remark:
定位列表管理 

***************************************/
require_once("module/Smarty-3.1.16/libs/Smarty.class.php");
require_once("module/mysql.m.php");
require_once("module/session.m.php");
require_once("module/encode.m.php");
require_once("_config.php");

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

$saveok=0;
$savetext='';

$exc=$_REQUEST['exc'];
if(strcmp($exc,''))
{
	switch($exc){
	case 'alter':
		$p0=$_REQUEST['p0'];
		$p1=$_REQUEST['p1'];
		$p2=$_REQUEST['p2'];
		$p2=urldecode(base64_decode($p2));
		$p2=zhPhpTrSql($p2);
		//echo $p2;
		$db=new PzhMySqlDB();	
		$db->open_mysql(cfg_db_host,cfg_db_name,cfg_db_username,cfg_db_passwd);
		$db->query("update tb_coodr_dev set remark='$p2' where user_autoid=$p0 and autoid=$p1");
		$db->close();
		$saveok=1;
		break;
	case 'del':
		$p0=$_REQUEST['p0'];
		$p1=$_REQUEST['p1'];
		$db=new PzhMySqlDB();
		$db->open_mysql(cfg_db_host,cfg_db_name,cfg_db_username,cfg_db_passwd);
		$db->query("delete from tb_coodr_dev where user_autoid=$p0 and autoid=$p1");
		$db->close();
		$saveok=2;
		break;
	}
}
//-------------------------------------------------------
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
					  'longitude'=>$rs['longitude'],
					  'latitude'=>$rs['latitude'],
					  'uptime'=>$rs['uptime']);
}

$db->close();


//模版页面
$smarty = new Smarty;
$smarty->force_compile = smarty_force_compile;
$smarty->debugging = smarty_debugging;
$smarty->caching = smarty_caching;
$smarty->cache_lifetime = smarty_cache_lifetime;

//常用信息
$smarty->assign("account",$ary_info['sz_account']);
$smarty->assign("userid",$ary_info['n_autoid']);

$smarty->assign("ary_device",$ary_device);
$smarty->assign("ary_device_count",count($ary_device));

$smarty->assign("saveok",$saveok);

$smarty->display('devlst.tpl');

?>