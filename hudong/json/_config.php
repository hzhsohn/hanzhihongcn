<?php
/**************************************

Author:Han.zhihong
remark:
此文件用于配置account_mob模块的PHP公共变量内容
处模块只针对account_db数据库

***************************************/
require_once("module/crypt.m.php");
require_once("module/time.m.php");

//-email发送的信息------------------------------
define('email_server','smtp.163.com');      // SMTP服务器
define('email_port','25');                        // SMTP端口
define('email_fromemail','sohn@163.com');    // from邮箱账号，填写您的邮箱账号
define('email_frompassword','asdffdsa');     // from邮箱密码，填写您的邮箱密

//激活邮件信息
define('email_action_key','HI-k3*1Po');       //邮件激活的加密钥匙
define('email_action_url','http://www.cloudkon.com/member/action_page.php');  //激活页面存放的URL地址

//修改密码邮件信息
define('email_reset_passwd_key','03cjH*j-r'); //修改密码的钥匙
define('email_reset_passwd_url','http://www.cloudkon.com/member/forgot_page.php');  //重置密码存放的URL地址

//-数据库信息------------------------------
//用户数据库
define('cfg_accountdb_host','192.168.3.100');
define('cfg_accountdb_username','root');
define('cfg_accountdb_passwd','Dd123');
define('cfg_accountdb','hudong');

/*
	交互用的钥匙处理
	createMobKey 登录时创建通信KEY,返回AES加密字符串
	checkMobKey 解析KEY,返回BOOL,true解析成功session可用,false解析失败session过期
	getMobKeyUserid 在key里返回userid
	getMobKeyDate 获取在KEY里的生成日期
*/
define(mob_encrypt_key,"!$%@#*54Ujen3");
function createMobKey($userid)
{
	global $date;
	/*
		加密信息分两层
				
		第一层,三个参数,AES-CRC加密
		zh固定头,用户IP,登录的日期
		
		第二层,三个参数,base64加密
		ck为固定头日期,AES-CRC加密的KEY,最后一个参数是end固定尾
	*/
	$tim=_today;
	$str="zh,$userid,$tim";
   	$aes=new PzhAes();
	$key=$aes->encrypt($str,mob_encrypt_key);
	$key="ck|$key|end";
	$key=base64_encode($key);
	return $key;
}

function checkMobKey($encode_str)
{
	$encode_str=base64_decode($encode_str);
	$dd=explode('|',$encode_str);
	//var_dump($dd);
	if(0==strncmp($dd[0],'ck',2) && 0==strncmp($dd[2],'end',3))
	{
		$aes=new PzhAes();
		$de=$aes->decrypt($dd[1],mob_encrypt_key);	
		$tt=explode(',',$de);
		
		//校验加密数据
		if(strncmp($tt[0],'zh',2))
		 {return false;}
		 
		//检测KEY是否过期 ,有效期为14天
		if(zhPhpOverDay($tt[2],14))
		{return false;}
		return true;
	}
	else
	{
		return false;	
	}
}

function getMobKeyUserid($encode_str)
{
	$encode_str=base64_decode($encode_str);
	
	$dd=explode('|',$encode_str);
	//var_dump($dd);
	if(0==strncmp($dd[0],'ck',2) && 0==strncmp($dd[2],'end',3))
	{
		$aes=new PzhAes();
		$de=$aes->decrypt($dd[1],mob_encrypt_key);	 
		//var_dump($de);
		$tt=explode(',',$de);
		
		//校验加密数据
		if(strncmp($tt[0],'zh',2))
		 {return '';}
		 
		return $tt[1];
	}
	else
	{
		return '';	
	}
}

function getMobKeyDate($encode_str)
{
	$encode_str=base64_decode($encode_str);
	
	$dd=explode('|',$encode_str);
	//var_dump($dd);
	if(0==strncmp($dd[0],'ck',2) && 0==strncmp($dd[2],'end',3))
	{
		$aes=new PzhAes();
		$de=$aes->decrypt($dd[1],mob_encrypt_key);	 
		//var_dump($de);
		$tt=explode(',',$de);
		
		//校验加密数据
		if(strncmp($tt[0],'zh',2))
		 {return '';}
		 
		return $tt[2];
	}
	else
	{
		return '';	
	}
}

?>