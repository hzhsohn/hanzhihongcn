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

//允许一键登录的cookies保存的时间,一周
define('cookies_time',3600*24*7); 

//获取SESSION的各种值
$ary_info=zhPhpSessionVal('ary_info');

/*
result返回的信息值

1:登录成功
2:你的用户角色没有管理员权限
3:账号已经被禁用
4:账号未注册
5:登录失败,请检测用户名或密码
6:验证码错误
7:已经登录了,正在获取管理员信息

*/
$method=$_REQUEST['method'];
$result=0;

function getIP() /*获取客户端IP*/
{ 
    if (@$_SERVER["HTTP_X_FORWARDED_FOR"]) 
    $ip = $_SERVER["HTTP_X_FORWARDED_FOR"]; 
    else if (@$_SERVER["HTTP_CLIENT_IP"]) 
    $ip = $_SERVER["HTTP_CLIENT_IP"]; 
    else if (@$_SERVER["REMOTE_ADDR"]) 
    $ip = $_SERVER["REMOTE_ADDR"]; 
    else if (@getenv("HTTP_X_FORWARDED_FOR")) 
    $ip = getenv("HTTP_X_FORWARDED_FOR"); 
    else if (@getenv("HTTP_CLIENT_IP")) 
    $ip = getenv("HTTP_CLIENT_IP"); 
    else if (@getenv("REMOTE_ADDR")) 
    $ip = getenv("REMOTE_ADDR"); 
    else 
    $ip = "Unknown"; 
    return $ip; 
}

//查询数据库函数
function login($account,$passwd,$w_cookies,$isAutologin)
{
	global $result;
		
	$ip=getIP();
	
	$accountdb=new PzhMySqlDB();		
	$accountdb->open_mysql(cfg_db_host,cfg_db_name,cfg_db_username,cfg_db_passwd);

	$accountdb->query("call sp_signin('$account','$passwd','$ip')",0,0);
	if($rs=$accountdb->read())
	{
		//var_dump($rs);
		switch($rs['result_'])
		{
			case 1: //登录成功
			{
						//登录成功
						$result=1; 
						
						//获取功能单元,将内容放入session里
						$info_ary=array();
						$info_ary['n_autoid']=$rs['autoid'];			
						$info_ary['sz_vip_deadline']=$rs['vip_deadline'];
						$info_ary['sz_account']=$account;
						zhPhpSessionSet('ary_info',$info_ary);

						//写入COOKIES
						if(1==$w_cookies)
						{
							setcookie('dingwei_auto_u',$account,time()+cookies_time); 
							setcookie('dingwei_auto_p',$passwd,time()+cookies_time); 
						}
						
						//重定向浏览器 
						//header("Location: manage.php"); 
						echo '<meta http-equiv="refresh" content="1;url=manage.php">';
			}
			break;
			case 2: //密码出错
			{
				//登录失败,请检测用户名或密码
				$result=5; 
				setcookie('dingwei_auto_u','',time()-cookies_time); 
				setcookie('dingwei_auto_p','',time()-cookies_time); 
				//清空SESSION,用户信息是JSON,结构请看登录模块
				zhPhpSessionSet('ary_info',NULL);
			}
			break;
		}
	}
	
	$accountdb->close();
}

//------------------------------------------------------------------------------------------
//开始执行程序
if(0==strcmp($method,'login'))
{
	/*$txt_verify=$_REQUEST['txt_verify'];
	if(0==strcasecmp($txt_verify,zhPhpVeryifyCodeResult()))
	{ */
		$txt_account=$_REQUEST['account'];
		$txt_passwd=$_REQUEST['passwd'];
		$ckb_autologin=$_REQUEST['ckb_autologin'];
		//两次MD5加密
		$txt_passwd=md5($txt_passwd);
		$txt_passwd=md5($txt_passwd);
		login($txt_account,$txt_passwd,$ckb_autologin,false);
	/*}
	else
	{
	  //验证码错误
		$result=6;
	}
	zhPhpVeryifyCodeDestory();	*/
}
else
{
	//什么参数都没有
	//重定向浏览器 
	header("Location: index.php"); 
	exit;
}


//显示页面
$smarty = new Smarty;
$smarty->force_compile = smarty_force_compile;
$smarty->debugging = smarty_debugging;
$smarty->caching = smarty_caching;
$smarty->cache_lifetime = smarty_cache_lifetime;

$smarty->assign("result",$result);
$smarty->display('sign_in.tpl');

?>
