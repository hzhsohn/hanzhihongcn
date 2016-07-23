<?php
/**************************************

Author:Han.zhihong
remark:
发送邮件后,邮件的激活地址连接到这里进行修改密码

***************************************/
require_once("module/Smarty-3.1.16/libs/Smarty.class.php");
require_once("module/mysql.m.php");
require_once("module/mail.m.php");
require_once("module/crypt.m.php");
require_once("module/time.m.php");
require_once("_config.php");

/* ---------------------------------------
result返回的结果
0 初始验证成功
1 cd码错误
2 cd码为空
3 忘记密码邮件已经过期
*/
$result=0;

//获取激活码
$cd=$_REQUEST['cd'];
if(0==strcmp($cd,''))
{
	$result=2;
}
else
{
	/*
	生成校验内容,AES->CBC加密,再经过base64加密,钥匙在_config.php文件里的email_action_key
	加密的cd分四部分 
		第一部分固定头 参数为'ckpwd'
		第二部分是 用户ID
		第三部分是 重置密码随机标识
		第四部分是 提交日期
	*/
	//echo email_reset_passwd_key."<br/>";
	//echo $cd."<br/>";
	$aes=new PzhAes();
	$cd=base64_decode($cd);
	//echo $cd."<br/>";
	$cd=$aes->decrypt($cd,email_reset_passwd_key);
	//echo $cd."<br/>";
	$p=explode(',',$cd);
	//var_dump($p);
	if(strcmp($p[0],'ckpwd'))
	{
		$result=1;
	}
	else
	{
		if(zhPhpOverDay($p[3],1))
		{
			$result=3;
		}
		else
		{
			$userid=$p[1];
			$randid=$p[2];			
		}
	}
}
//显示页面
$smarty = new Smarty;
$smarty->force_compile = smarty_force_compile;
$smarty->debugging = smarty_debugging;
$smarty->caching = smarty_caching;
$smarty->cache_lifetime = smarty_cache_lifetime;

$smarty->assign("result",$result);
$smarty->assign("userid",$userid);
$smarty->assign("randid",$randid);
$smarty->display('forgot_page.tpl');

?>