<?php
/**************************************

Author:Han.zhihong
remark:
修改管理员资料的模块

***************************************/
require_once("../_module/Smarty-3.1.16/libs/Smarty.class.php");
require_once("../_module/mysql.m.php");
require_once("../_module/session.m.php");
require_once("../_module/encode.m.php");
require_once("_config.php");

//判断登录的SESSION
$userinfo=json_decode($_SESSION['ADMIN_INFO']);
if(is_null($userinfo))
{
	echo '<meta http-equiv="refresh" content="5;url=index.php">';
	echo'no userinfo';
	exit; 
}

//
$db=new PzhMySqlDB();	
$db->open_mysql(cfg_db_host,cfg_db,cfg_db_username,cfg_db_passwd);

//
$editname=$_REQUEST['editname'];
$method=$_REQUEST['method'];
$result=0;

if(0==strcmp($method,'update'))
{
  $mark=$_REQUEST['mark']; 
  $mark=zhPhpTrSql($mark);
	if(strlen($mark)>1000)
	{
		$result=3;
	}
	else
	{
		if($db->query("update admin set remark='$mark' where username='$editname'",0,0))
		{
			$result=1;			
		}
		else
		{
			$result=2;	
		}
	}
}

//-------------------------
$db->query("select*from admin where username='$editname'",0,0);
if($rs=$db->read())
{	
	$remark=zhPhpTrHtml($rs['remark']);
}
$db->close();

//模版页面
$smarty = new Smarty;
$smarty->force_compile = smarty_force_compile;
$smarty->debugging = smarty_debugging;
$smarty->caching = smarty_caching;
$smarty->cache_lifetime = smarty_cache_lifetime;

//常用信息
$smarty->assign("editname",$editname);
$smarty->assign("result",$result);

//更新结果
$smarty->assign("remark",$remark);

$smarty->display('information.tpl');

?>