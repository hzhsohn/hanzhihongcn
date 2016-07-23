<?php
/**************************************

Author:Han.zhihong
remark:
发送邮件后,邮件的激活地址连接到这里进行激活

***************************************/
require_once("module/Smarty-3.1.16/libs/Smarty.class.php");
require_once("module/verifycode.m.php");
require_once("module/mysql.m.php");
require_once("module/session.m.php");
require_once("module/mail.m.php");
require_once("module/crypt.m.php");
require_once("module/time.m.php");
require_once("_config.php");


/*
result返回的结果
1 成功
2 code码空或出错
3 账户已经被激活过了
4 激活邮件已经过期
5 操作数据库失败
6 用户还未注册
7 查询数据库失败

*/
$result=0;

//获取激活码
$code=$_REQUEST['code'];

if(0==strcmp($code,''))
{
	$result=2;
}
else
{
	/*生成校验内容,AES->CBC加密,钥匙在_config.php文件里的email_action_key
		加密的code分三部分 
			第一部分固定头 参数为'ck'
			第二部分是userid
			第三部分是由到邮件日期
	*/
	$aes=new PzhAes();
	//echo $code."</br>";
	$code=base64_decode($code);
	//echo $code."</br>";
	$code=$aes->decrypt($code,email_action_key);
	
	$p=explode(',',$code);
	if(strcmp($p[0],'ck'))
	{
		$result=4;	
	}
	else if(0==strcmp($p[1],''))
	{
		$result=2;
	}
	else if(zhPhpOverDay($p[2],1))
	{
		$result=1;
	}
	else
	{
		$userid=$p[1];
		$accountdb=new PzhMySqlDB();
		$accountdb->open_mysql(cfg_accountdb_host,cfg_accountdb,cfg_accountdb_username,cfg_accountdb_passwd);
		$accountdb->query("select count(1) from tb_user_list where userid=$userid",0,0);
		if($rs=$accountdb->read())
		{
			if(0==$rs[0])
			{
				//用户还未注册
				$result=6;
			}
			else
			{
				//建立新记录
				$memberdb=new PzhMySqlDB();
				$memberdb->open_mysql(cfg_memberdb_host,cfg_memberdb,cfg_memberdb_username,cfg_memberdb_passwd);
				$memberdb->query("call sp_activate_member($userid,@result)",0,0);
				$memberdb->query("select @result",0,0);
				if($rs=$memberdb->read())
				{
					switch($rs[0])
					{
						case 1:
							//成功
							$result=1;
							
						break;
						case 2:
							//账户已经被激活过了
							$result=3;
						break;
					}			
				}
				else
				{
					//操作数据库失败
					$result=5;
				}
				$memberdb->close();
			}
		}
		else
		{
			//查询数据库失败
			$result=7;
		}
		$accountdb->close();
	}
}
//显示页面
$smarty = new Smarty;
$smarty->force_compile = smarty_force_compile;
$smarty->debugging = smarty_debugging;
$smarty->caching = smarty_caching;
$smarty->cache_lifetime = smarty_cache_lifetime;

$smarty->assign("result",$result);
$smarty->display('action_page.tpl');

?>