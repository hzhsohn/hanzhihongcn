<?php
/**************************************

Author:Han.zhihong
remark:
登录模块,SESSION是整站通用的,登录之后获取权限,
用户是根据权限操作整个系统的功能

***************************************/
require_once("module/Smarty-3.1.16/libs/Smarty.class.php");
require_once("module/verifycode.m.php");
require_once("module/mysql.m.php");
require_once("module/session.m.php");
require_once("_config.php");

//cookies保存的时间,一周
define('cookies_time',3600*24*7); 

//获取session
$userinfo=json_decode(zhPhpSessionVal('userinfo'));

$username=NULL;
$method=$_REQUEST['method'];

/*
login_ret_msg返回的信息值

2:登录成功
3:你的用户账户没有被激活 
5:登录失败,请检测用户名或密码
6:验证码错误
7:已经登录了,正在获取用户信息
*/
$login_ret_msg=0;
$login_ret=false;

$db=new PzhMySqlDB();		
$db->open_mysql(cfg_host,cfg_db,cfg_username,cfg_password);

//获取角色资料
function getUserInfo($user)
{
	global $db,$userinfo,$login_ret_msg,$login_ret;	

	//用户信息
    $info_ary=array();
    $db->query("select userlist_userid from m_member_info a where userlist_userid='$user'",0,0);
    $rs=NULL;
    if($rs=$db->read())
    {
      $info_ary['userid']=$rs['userlist_userid'];
    }
	return $info_ary;
}

//查询数据库函数
function login($user,$passwd)
{
	global $db,$userinfo,$login_ret_msg,$login_ret;	
	$login_ret=false;

	$db->query("select *from m_user_list where username='$user' and password='$passwd'",0,0);
	if($db->read())
	{
		//查询成功角色并获取资料
		$info_ary=getUserInfo($user);
		if(count($info_ary)>0)
		  {			
			  //登录成功
			  $login_ret_msg=2; 
			  $login_ret=true;
			  
			  //更新最后登录时间
			  $db->query("update m_member_info set lastlogin=now() where userlist_userid='$user'",0,0);
			  
			  //获取功能单元
			  $unit_ary=array();
			  $db->query("select *from m_member_unit where member_username='$user'",0,0);
			  $rs=NULL;
			  while($rs=$db->read())
			  {
				$unit_ary[]=$rs['guid'];
			  }
			  
			  //绑定SESSION
			  if(is_null($userinfo))
			  {
				  $userinfo=new PzhUserinfo;
				  $userinfo->sz_userid=$user; 
				  $userinfo->is_member=true;
				  $userinfo->ary_member_info=$info_ary;
				  $userinfo->ary_member_unit=$unit_ary;
				  $json=json_encode($userinfo);
				  zhPhpSessionSet('userinfo',$json);
			  }
			  else
			  {
				  $userinfo->sz_userid=$user; 
				  $userinfo->is_member=true;
				  $userinfo->ary_member_info=$info_ary;
				  $userinfo->ary_member_unit=$unit_ary;
				  $json=json_encode($userinfo);
				  zhPhpSessionSet('userinfo',$json);
			  }
			  //重定向浏览器 
			  //header("Location: manage.php"); 
			  echo '<meta http-equiv="refresh" content="1;url=manage.php">';
		  }
		  else
		  {
				//用户账号未激
				$login_ret_msg=3;
		  }
	}
	else
	{
		//登录失败,请检测用户名或密码
		$login_ret_msg=5; 
	}
}

if(0==strcmp($method,'login'))
{
	$txt_verify=$_REQUEST['txt_verify'];
	if(0==strcmp($txt_verify,zhPhpVeryifyCodeResult()))
	{ 
		$username=$_REQUEST['txt_username'];
		$txt_passwd=$_REQUEST['txt_passwd'];
		//两次MD5加密
		$txt_passwd=md5($txt_passwd);
		$txt_passwd=md5($txt_passwd);
		login($username,$txt_passwd);
	}
	else
	{
	  //验证码错误
		$login_ret_msg=6;
	}
	zhPhpVeryifyCodeDestory();	
}

else if(0==strcmp($method,'pass'))
{
	$username=$userinfo->sz_userid;
	$info_ary=getUserInfo($username);
	if(count($info_ary)>0)
	{
	 		//已经登录了,正在获取管理员信息
	 		$login_ret_msg=7;
			$login_ret=true;

			//更新最后登录时间
			$db->query("update m_member_info set lastlogin=now() where userlist_userid='$username'",0,0);

			//获取功能单元
			$unit_ary=array();
			$db->query("select *from m_member_unit where member_username='$username'",0,0);
			$rs=NULL;
			while($rs=$db->read())
			{
			  $unit_ary[]=$rs['guid'];
			  $db->record_next();
			}

			//绑定SESSION
			$userinfo->is_member=true;
			$userinfo->ary_member_info=$info_ary;
			$userinfo->ary_member_unit=$unit_ary;
			$json=json_encode($userinfo);
			zhPhpSessionSet('userinfo',$json);
			
			//重定向浏览器 
			//header("Location: manage.php"); 
			echo '<meta http-equiv="refresh" content="1;url=manage.php">';
	}
	else
	{
	 		//用户账号未激
			$login_ret_msg=3;
	}
}
else
{
	//什么参数都没有
	//重定向浏览器 
	header("Location: index.php"); 
	exit;
}

$db->close();

//显示页面
$smarty = new Smarty;
$smarty->force_compile = smarty_force_compile;
$smarty->debugging = smarty_debugging;
$smarty->caching = smarty_caching;
$smarty->cache_lifetime = smarty_cache_lifetime;

$smarty->assign("username",$username);

$smarty->assign("login_ret_msg",$login_ret_msg);
$smarty->assign("login_ret",$login_ret);
$smarty->display('sign_in.tpl');

?>