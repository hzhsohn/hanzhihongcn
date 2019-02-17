<?php
/*****************************************************************
//Author:HanSohn
//Version:2.0.3
*****************************************************************/

session_start();

//给一个SESSION值
//成功返回true
//失败返回false
function zhPhpSessionSet($name,$value)
{
	$_SESSION[$name]=$value;
	if(isset($_SESSION[$name]))
	{		
		return true;
	}
	return false;
}

//SESSION内容
function zhPhpSessionGet($name)
{
	return $_SESSION[$name];
}

//判断SESSION是否存在
//存在返回true
//不存在返回false
function zhPhpSessionExist($name)
{
	return isset($_SESSION[$name]);	
}

//注销某一个SESSION
function zhPhpSessionRemove($name)
{
	if(isset($_SESSION[$name]))
	{
		$_SESSION[$name]=NULL;
		unset($_SESSION[$name]);
	}
}

?>