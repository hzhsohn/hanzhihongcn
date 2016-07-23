<?php
/**************************************

Author:Han.zhihong
remark:
登录之后获取用户的服务

***************************************/

require_once("module/mysql.m.php");
require_once("_config.php");

/*
  到数据库取信息
*/
$memberdb=new PzhMySqlDB();
$memberdb->open_mysql(cfg_memberdb_host,cfg_memberdb,cfg_memberdb_username,cfg_memberdb_passwd);

//------------------------------------------------------
//打印JSION接口信息
//成功 
function printSuccess($ary_service)
{
	$p=array('nRet'=>'1',
			 'aryService'=>$ary_service
			 );
	echo json_encode($p);
}

//不存在用户
function printNoUser()
{
	$p=array('nRet'=>'2',
			 'szErr'=>'not exist userid'
			 );
	echo json_encode($p);
} 

//操作服务器失败
function printOperatFail()
{
	$p=array('nRet'=>'3',
			 'szErr'=>'can not operat database'
			 );
	echo json_encode($p);
}

//缺少参数
function printLostParameter()
{
	$p=array('nRet'=>'4',
			 'szErr'=>'lost parameter'
			 );
	echo json_encode($p);
}

//key值存在问题
function printInvalidKey()
{
	$p=array('nRet'=>'5',
			 'szErr'=>'invalid key value'
			 );
	echo json_encode($p);
}

//------------------------------------------------------
//获取角色服务
function getMemberService($userid)
{
	global $memberdb;	
	
	$unit_ary=array();
	$memberdb->query("select *from tb_member_service where account_userlist_userid='$userid'",0,0);
	$rs=NULL;
	while($rs=$memberdb->read())
	{
		$unit_ary[]=$rs['guid'];
		$memberdb->record_next();
	}
	return $unit_ary;
}


//----------------------------------------------------
//执行程序功能

$key=$_REQUEST['k'];

if(0==strcmp($key,''))
{
  printLostParameter();
  exit;
}

$userid=getMobKeyUserid($key);

if(0==strcmp($userid,''))
{
	printInvalidKey();	
}
else
{
	$ary=getMemberService($userid);
	if(count($ary)>0)
	{
		printSuccess($ary);
	}
	else
	{
		printNoUser();	
	}
}
$memberdb->close();
?>