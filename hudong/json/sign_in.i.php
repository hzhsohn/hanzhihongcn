<?php
/**************************************

Author:Han.zhihong
remark:
登录模块,登录之后可以使用KEY通讯

***************************************/

require_once("module/mysql.m.php");
require_once("_config.php");

/*
  到数据库取信息
*/
$accountdb=new PzhMySqlDB();
$accountdb->open_mysql(cfg_accountdb_host,cfg_accountdb,cfg_accountdb_username,cfg_accountdb_passwd);

//------------------------------------------------------
//打印JSION接口信息
function printSuccess($userid,$account)
{
	$p=array('nRet'=>'1',
			 'szUserid'=>$userid,
			 'szAccount'=>$account,
			 'szKey'=>createMobKey($userid)
			 );
	echo json_encode($p);
}

//未激活
function printInactive()
{
	$p=array('nRet'=>'2',
			 'szErr'=>'account inactive'
			 );
	echo json_encode($p);
} 

//密码或账户出错
function printLoginFail()
{
	$p=array('nRet'=>'3',
			 'szErr'=>'password error'
			 );
	echo json_encode($p);
}

//空账户
function printEmptyAccount()
{
	$p=array('nRet'=>'4',
			 'szErr'=>'empty account'
			 );
	echo json_encode($p);
}

//空密码
function printEmptyPassword()
{
	$p=array('nRet'=>'5',
			 'szErr'=>'empty password'
			 );
	echo json_encode($p);
}
//账号被禁用
function printDisableAccount()
{
	$p=array('nRet'=>'6',
			 'szErr'=>'account is disable'
			 );
	echo json_encode($p);
}

//账号未注册
function printNotExistAccount()
{
	$p=array('nRet'=>'7',
			 'szErr'=>'not exist account'
			 );
	echo json_encode($p);
}


//------------------------------------------------------
/*获取客户端IP*/
function getIP() 
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

///////////////////////////////////////////////////////////
//获取是否已经激活账户角色
function isAction($userid)
{
	$ret=false;
	$memberdb=new PzhMySqlDB();
	$memberdb->open_mysql(cfg_memberdb_host,cfg_memberdb,cfg_memberdb_username,cfg_memberdb_passwd);
	//用户信息	
    $memberdb->query("select count(1) from tb_member_info where accountdb_userlist_userid='$userid'",0,0);
    if($rs=$memberdb->read())
    {
		//var_dump($rs);
		if(1==$rs[0])
      	{
			//登录成功
			$ret= true;
		}
		else
		{$ret= false;}
    }
	$memberdb->close();
	return $ret;
}

//查询数据库函数
function login($userid,$passwd,$cflag)
{
	global $accountdb;
	
	$ip=getIP();
	$accountdb->query("call sp_signin_by_userid('$userid','$passwd' ,'$ip','$cflag')",0,0);
	//var_dump($accountdb);
	if($rs=$accountdb->read())
	{
		/*
		1=登录成功,会返回userid
		2=用户名或密码不匹配
		3=账号已被禁用
		4=账号未被注册
		*/
		//var_dump($rs);
		switch($rs["result_"])
		{
			case 1:
			{
				$userid=$rs["userid_"];
				//查询成功角色并获取资料
				//if(isAction($userid))
				//{
					//登录成功,输出资料
					printSuccess($rs[1] ,$email);
				//}
				//else
				//{	
					//用户账号未激活,账号未激活原理,是因为member表没有账户的数据
				//	printInactive();
				//}
			}
			break;
			case 2:
				//登录失败,请检测用户名或密码
				printLoginFail();
			break;
			case 3:
				//账号被禁用
				printDisableAccount();
			break;
			case 4:
				//不存在此账号
				printNotExistAccount();
			break;
		}
	}
}

//----------------------------------------------------
//执行程序功能

$userid=$_REQUEST['u'];
$txt_passwd=$_REQUEST['p'];
$cflag=$_REQUEST['f'];

if(0==strcmp($userid,''))
{
  printEmptyAccount();
  exit;
}

if(0==strcmp($txt_passwd,''))
{
  printEmptyPassword();
  exit;
}

//两次MD5加密
$txt_passwd=md5($txt_passwd);
$txt_passwd=md5($txt_passwd);
login($userid,$txt_passwd,$cflag);

$accountdb->close();
?>