<?php
/**************************************

Author:Han.zhihong
remark:
发送邮件后,邮件的激活地址连接到这里进行修改密码

***************************************/
require_once("module/Smarty-3.1.16/libs/Smarty.class.php");
require_once("module/mysql.m.php");
require_once("module/mail.m.php");
require_once("module/time.m.php");
require_once("_config.php");

//----------------------------------------
//更新操作

/*
1 更新成功
2 没有操作参数
3 随机密码验证失败
4 无效账户
5 数据库操作失败
6 两次密码不一样
*/

$method=$_REQUEST['method'];
if(0==strcmp($method,'modify'))
{
	$userid=$_REQUEST['uid'];
	$randid=$_REQUEST['rid'];
	$pwd1=md5(md5($_REQUEST['pwd1']));
	$pwd2=md5(md5($_REQUEST['pwd2']));
	if(0==strcmp($pwd1,$pwd2))
	{		
		$accountdb=new PzhMySqlDB();		
		$accountdb->open_mysql(cfg_accountdb_host,cfg_accountdb,cfg_accountdb_username,cfg_accountdb_passwd);
		$accountdb->query("call sp_forgot_set_passwd($userid,$randid,'$pwd1',@ret)",0,0);
		$accountdb->query("select @ret",0,0);
		if($rs=$accountdb->read())
		{
			switch($rs[0])
			{
				case 1://成功修改新密码
				$result=1;
				break;
				
				case 2://验证失败
				$result=3;
				break;
				
				case 3://无效账户
				$result=4;
				break;
				
				default://数据库操作失败
				$result=5;
				break;
			}
		}
		else
		{
			//数据库操作失败
			$result=5;
		}
		$accountdb->close();
	}
	else
	{
		//两次输入的密码不一样
		$result=6;
	}
	
}
else
{
	//没有参数
	$result=2;
}

//显示页面
$smarty = new Smarty;
$smarty->force_compile = smarty_force_compile;
$smarty->debugging = smarty_debugging;
$smarty->caching = smarty_caching;
$smarty->cache_lifetime = smarty_cache_lifetime;

$smarty->assign("result",$result);
$smarty->display('forgot_page_ret.tpl');

?>