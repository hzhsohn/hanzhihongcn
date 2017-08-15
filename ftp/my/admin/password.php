<?php
/**************************************

Author:Han.zhihong
remark:
修改密码的功能

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
$username=$userinfo->username;
$method=$_REQUEST['method'];

//
$result=0;

//修改密码
if(0==strcmp($method,'update'))
{
	$oldpassword=$_REQUEST['oldpassword'];
    if(is_null($oldpassword))
    {
        echo'oldpassword is not null!!';
        exit;
    }
    $password=$_REQUEST['password'];
    if(is_null($password))
    {
        echo'password is not null!!';
        exit;
    }
	$password2=$_REQUEST['password2'];
    if(is_null($password))
    {
        echo'password2 is not null!!';
        exit;
    }
	
	if(0==strcmp($oldpassword,'') || 0==strcmp($password,'') || 0==strcmp($password2,''))
	{
		//其中一个密码为空
		$result=5;
	}
	else
	{
		$oldpassword=md5($oldpassword);
		$oldpassword=md5($oldpassword);

		$password=md5($password);
		$password=md5($password);
		
		$password2=md5($password2);
		$password2=md5($password2);
		
		//将password无法还原密码
		$oldpassword=substr($oldpassword,11,20); 
		$password=substr($password,11,20); 
		$password2=substr($password2,11,20); 

		if(strcmp($password,$password2))
		{
			//两次密码不相同
			$result=1;
		}
		else
		{
			$db=new PzhMySqlDB();	
			$db->open_mysql(cfg_db_host,cfg_db,cfg_db_username,cfg_db_passwd);
			$db->query("select autoid from admin where username='$username' and passwd='$oldpassword'",0,0);

			if($db->read())
			{
				if($db->query("update admin set passwd='$password' where username='$username' ",0,0))
				{
					//修改成功
					$result=2;
				}
				else
				{
					//修改密码失败
					$result=3;	
				}
			}
			else
			{
				//旧密码不对
				$result=4;
			}
			$db->close();
		}
	}
}

//模版页面
$smarty = new Smarty;
$smarty->force_compile = smarty_force_compile;
$smarty->debugging = smarty_debugging;
$smarty->caching = smarty_caching;
$smarty->cache_lifetime = smarty_cache_lifetime;

//常用信息
$smarty->assign('username',$username);

//更新结果
$smarty->assign('result',$result);

$smarty->display('password.tpl');

?>