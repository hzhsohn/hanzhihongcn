<?php
/**************************************

Author:Han.zhihong
remark:
通讯校验模块,
**************************************/

require_once("module/mysql.m.php");
require_once("_config.php");

/*
  到数据库取信息
*/
$accountdb=new PzhMySqlDB();
$accountdb->open_mysql(cfg_accountdb_host,cfg_accountdb,cfg_accountdb_username,cfg_accountdb_passwd);

//------------------------------------------------------
//打印JSION接口信息
function printSuccess($userid,$account,$key)
{
	$p=array('nRet'=>'1',
			 'szUserid'=>$userid,
			 'szAccount'=>$account,
			 'szKey'=>$key
			 );
	echo json_encode($p);
}

//空账户
function printEmptyAccount()
{
	$p=array('nRet'=>'2',
			 'szErr'=>'empty account'
			 );
	echo json_encode($p);
}

//空密码
function printEmptyKey()
{
	$p=array('nRet'=>'3',
			 'szErr'=>'empty key'
			 );
	echo json_encode($p);
}

//账户未激活
function printInactive()
{
	$p=array('nRet'=>'4',
			 'szErr'=>'account inactive'
			 );
	echo json_encode($p);
}

//无效钥匙
function printKeyFail()
{
	$p=array('nRet'=>'5',
			 'szErr'=>'key fail'
			 );
	echo json_encode($p);
}

//钥匙与账户不匹配
function printKeyInvalid()
{
	$p=array('nRet'=>'6',
			 'szErr'=>'key invalid'
			 );
	echo json_encode($p);
}

//不存在此邮箱用户
function printNotFindEmail()
{
	$p=array('nRet'=>'7',
			 'szErr'=>'not exist the email'
			 );
	echo json_encode($p);
}

//账号被禁用
function printDisableAccount()
{
	$p=array('nRet'=>'8',
			 'szErr'=>'account is disable'
			 );
	echo json_encode($p);
}
//------------------------------------------------------
//获取是否已经激活账户角色
function isAction($userid)
{
	$ret=false;
	$memberdb=new PzhMySqlDB();
	$memberdb->open_mysql(cfg_memberdb_host,cfg_memberdb,cfg_memberdb_username,cfg_memberdb_passwd);
	//用户信息	
    $memberdb->query("select count(*) from tb_member_info where accountdb_userlist_userid='$userid'",0,0);
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
function verifyKey($email,$key)
{
	global $accountdb;
	
	/* checkMobKey函数,检测数据格式,检查有效期*/
	if(!checkMobKey($key))
	{
		//过期或者不是正解的无效钥匙
		printKeyFail();
		exit;
	}

	$accountdb->query("select userid,nickname,all_disable from tb_user_list where safe_email='$email'",0,0);
	if($rs=$accountdb->read())
	{
		if(0==$rs['all_disable'])
		{
			//账号有效
			$ary_accountInfo=array();
			$ary_accountInfo['szUserid']=$rs['userid'];
			$ary_accountInfo['szNickname']=$rs['nickname'];
			
			$userid=$rs['userid'];
			
			//对比邮箱的用户ID跟KEY里的是否一致
			if(strcmp($userid,getMobKeyUserid($key)))
			{
				printKeyInvalid();
				exit;	
			}
			
			//查询成功角色并获取资料
			if(isAction($userid))
			{	 
				  //登录成功,输出资料
				  printSuccess($userid,$email,$key);
			}
			else
			{
				//用户账号未激活,账号未激活原理,是因为member表没有账户的数据
				printInactive();
			}
		}
		else
		{
			//账户被禁用
			printDisableAccount();
		}
	}
	else
	{
        //没有此邮箱用户
		printNotFindEmail();
	}
}


//----------------------------------------------------
//执行程序功能

$email=$_REQUEST['e'];
$key=$_REQUEST['k'];

if(0==strcmp($email,''))
{
  printEmptyAccount();
  exit;
}

if(0==strcmp($key,''))
{
  printEmptyKey();
  exit;
}

//验证
verifyKey($email,$key);

$accountdb->close();
?>