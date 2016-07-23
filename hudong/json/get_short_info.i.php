<?php
/**************************************

Author:Han.zhihong
remark:
登录之后获取用户信息

***************************************/

require_once("module/mysql.m.php");
require_once("_config.php");

//------------------------------------------------------
//打印JSION接口信息
function printSuccess($ary_memberInfo)
{
	$p=array('nRet'=>'1',
			 'aryMemberInfo'=>$ary_memberInfo
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

//操作数据库失败
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
//获取角色资料
function getMemberInfo($userid)
{	
	$unit_ary=array();
	
	$unit_ary['szUserid']="$userid";
	
	$accountdb=new PzhMySqlDB();
	$accountdb->open_mysql(cfg_accountdb_host,cfg_accountdb,cfg_accountdb_username,cfg_accountdb_passwd);
	$accountdb->query("select nickname,createtime from tb_user_list where userid='$userid'",0,0);
    if($rs=$accountdb->read())
    {
      $unit_ary['szNickname']=$rs['nickname'];
	  $unit_ary['szCreateTime']=$rs['createtime'];
    }	
	$accountdb->close();
	
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
	$ary=getMemberInfo($userid);
	if(count($ary)>0)
	{
		printSuccess($ary);
	}
	else
	{
		printNoUser();	
	}
}

?>