<?php
/**************************************

Author:Han.zhihong
remark:
发送激活邮件的模块

***************************************/
require_once("module/Smarty-3.1.16/libs/Smarty.class.php");
require_once("module/verifycode.m.php");
require_once("module/mysql.m.php");
require_once("module/encode.m.php");
require_once("_config.php");


/*
result返回的结果
0 注册成功
1 验证码错误
2 用户名为空
3 该用户名已经存在
4 服务器操作失败
5 两次密码不一样
6 无效操作
*/
$result=0;

//获取数据和校检
$method=$_REQUEST['method'];
$txt_verify=$_REQUEST['txt_verify'];

$username=zhPhpTrSql($_REQUEST['txt_username']);
$nickname=zhPhpTrSql($_REQUEST['txt_nickname']);
$password1=md5($_REQUEST['txt_password1']);
$password1=md5($password1);
$password2=md5($_REQUEST['txt_password2']);
$password2=md5($password2);
$email=zhPhpTrSql($_REQUEST['txt_email']);

if(0==strcmp($method,'register'))
{
	if(0==strcmp($txt_verify,zhPhpVeryifyCodeResult()))
	{ 
		if(strcmp($username,''))
		{
			if(0==strcmp($password1,$password2))
			{
				//查询账号的安全邮件
				$db=new PzhMySqlDB();		
				$db->open_mysql(cfg_host,cfg_db,cfg_username,cfg_password);
				$db->query("select autoid from m_user_list where username='$user'",0,0);
				if($rs=$db->read())
				{
					//该用户名已经存在
					$result=3;
				}
				else
				{
					if($db->query("insert into m_user_list(username,password,nickname,safe_email) 
									values('$username','$password1','$nickname','$email')",0,0))
					{
						$result=0;
					}
					else
					{
						//服务器操作失败
						$result=4;
					}
				}
				$db->close();
			}
			else
			{
				//两次密码不一样
				$result=5;
			}
		}
		else
		{
			//用户名为空
			$result=2;
		}
	}
	else
	{
	   //验证码错误
		$result=1;
	}
	zhPhpVeryifyCodeDestory();
}
else
{
	//无效操作	
	$result=6;
}

//显示页面
$smarty = new Smarty;
$smarty->force_compile = smarty_force_compile;
$smarty->debugging = smarty_debugging;
$smarty->caching = smarty_caching;
$smarty->cache_lifetime = smarty_cache_lifetime;

$smarty->assign("username",$username);
$smarty->assign("result",$result);
$smarty->display('register_ret.tpl');

?>