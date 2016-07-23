<?php
/**************************************

Author:Han.zhihong
remark:
注册账户模块

***************************************/
require_once("module/mysql.m.php");
require_once("module/encode.m.php");
require_once("_config.php");


/////////////////////////////////////////////////////////////////
//匹配包括._-在内的各种邮箱
function is_email($email){
    //$regex = '/^[\w\d][0-9a-z-._]+@{1}([0-9a-z][0-9a-z-]+.)+[a-z]{2,4}$/i';
    $regex = '/^[0-9a-z][0-9a-z-._]+@{1}[0-9a-z.-]+[a-z]{2,4}$/i';
    if (preg_match($regex, $email,$match)){
        return true;
    }
 
    return false;
}

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

/////////////////////////////////////////////////////////////////
//注册成功
function printSuccess($userid)
{
	$p=array('nRet'=>'1',
		 'userid'=>$userid,
		 );
	echo json_encode($p);
}

//用户ID为空
function printEmptyUserid()
{
	$p=array('nRet'=>'2',
			 'szErr'=>'empty userid'
			 );
	echo json_encode($p);
}

//邮箱为空
function printEmptyEmail()
{
	$p=array('nRet'=>'3',
			 'szErr'=>'empty email'
			 );
	echo json_encode($p);
}

//呢称为空
function printEmptyNick()
{
	$p=array('nRet'=>'4',
			 'szErr'=>'empty nickname'
			 );
	echo json_encode($p);
}

//密码为空
function printEmptyPassword()
{
	$p=array('nRet'=>'5',
			 'szErr'=>'empty password'
			 );
	echo json_encode($p);
}

//操作失败
function printOperatFail()
{
	$p=array('nRet'=>'6',
			 'szErr'=>'operat fail'
			 );
	echo json_encode($p);
}

//用户已经存在
function printRepeatUserid()
{
	$p=array('nRet'=>'7',
			 'szErr'=>'repeat userid'
			 );
	echo json_encode($p);
}

//邮箱已经被使用
function printRepeatEmail()
{
	$p=array('nRet'=>'8',
			 'szErr'=>'repeat email'
			 );
	echo json_encode($p);
}

//userid不是自然数
function printNotIsNatural()
{
	$p=array('nRet'=>'9',
			 'szErr'=>'userid not is natural'
			 );
	echo json_encode($p);
}

//邮箱格式不对
function printEmailFormatErr()
{
	$p=array('nRet'=>'10',
			 'szErr'=>'email format error'
			 );
	echo json_encode($p);
}

//------------------------------------------------------------------
//程序执行
$userid=zhPhpTrSql(trim($_REQUEST['u']));
$nickname=zhPhpTrSql(trim($_REQUEST['nick']));
$password1=md5($_REQUEST['p']);
$password1=md5($password1);
$email=zhPhpTrSql(trim($_REQUEST['em']));

if(0==strcmp($userid,''))
{
	printEmptyUserid();
	exit;
}
if(!is_numeric($userid))
{
	printNotIsNatural();
	exit;
}
if(0==strcmp($userid,''))
{
	printEmptyUserid();
	exit;
}
if(0==strcmp($nickname,''))
{
	printEmptyNick();
	exit;
}
if(0==strcmp($password1,''))
{
	printEmptyPassword();
	exit;
}
if(0==strcmp($email,''))
{
	printEmptyEmail();
	exit;
}
else
{
	if (false==is_email($email))
	{
		printEmailFormatErr();
		exit;
	}	
}


//获取IP
$ip=getIP();
//操作数据库
$accountdb=new PzhMySqlDB();
$accountdb->open_mysql(cfg_accountdb_host,cfg_accountdb,cfg_accountdb_username,cfg_accountdb_passwd);
$accountdb->query("call sp_register('$userid','$password1','$nickname','$email','$ip',@ret)",0,0);
$accountdb->query("select @ret",0,0);
if($rs=$accountdb->read())
{
	//var_dump($rs);
	switch($rs[0])
	{
		case 1:
			//成功
			printSuccess($userid);
		break;
		
		case 2:
			//操作失败
 			printOperatFail();
		break;
		
		case 3:
			//该用户名已经存在
 			 printRepeatUserid();
		break;
		
		case 4:
			//邮箱已经被使用
	  		printRepeatEmail();
		break;
	}  
}
else
{
	//服务器操作失败
	printOperatFail();
}
$accountdb->close();

?>