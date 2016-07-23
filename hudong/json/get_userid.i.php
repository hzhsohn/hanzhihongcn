<?php
/**************************************

Author:Han.zhihong
remark:
验证userid是否可用

判断m_user_list表里面的userid和m_free_userid表里面是否空闲可用

***************************************/

require_once("module/mysql.m.php");
require_once("_config.php");

//------------------------------------------------------
//userid可用
function printSuccess($userid)
{
	$p=array('nRet'=>'1',
			 'userid'=>$userid,
			 'time'=>_now
			 );
	echo json_encode($p);
}

//m_free_userid表已经不存在空闲用户ID
function printNoFree()
{
	$p=array('nRet'=>'2',
			 'szErr'=>'not free userid'
			 );
	echo json_encode($p);
} 

//读取数据库失败
function printOperatFail()
{
	$p=array('nRet'=>'3',
			 'szErr'=>'operator fail'
			 );
	echo json_encode($p);
} 

//----------------------------------------------------
//执行程序功能

//-------------------------------------------
/*
  到数据库取信息
*/
$accountdb=new PzhMySqlDB();
$accountdb->open_mysql(cfg_accountdb_host,cfg_accountdb,cfg_accountdb_username,cfg_accountdb_passwd);
$accountdb->query("call sp_get_free_userid(@n)",0,0);
$accountdb->query("select @n",0,0);
if($rs=$accountdb->read())
{
	if($rs[0]>0)
	{
		printSuccess($rs[0]);
	}
	else
	{
		printNoFree();	
	}
}
else
{
	printOperatFail();
}

$accountdb->close();
?>