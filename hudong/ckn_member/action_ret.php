<?php
/**************************************

Author:Han.zhihong
remark:
发送激活邮件的模块

***************************************/
require_once("module/Smarty-3.1.16/libs/Smarty.class.php");
require_once("module/verifycode.m.php");
require_once("module/mysql.m.php");
require_once("module/mail.m.php");
require_once("module/crypt.m.php");
require_once("module/time.m.php");
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


/*
result返回的结果
0 发送成功
1 验证码错误
2 邮箱格式不对
3 邮箱发送出错
4 找不到此用户
5 无效操作
*/
$result=0;

//获取数据和校检
$method=$_REQUEST['method'];
$email=$_REQUEST['em'];
$txt_verify=$_REQUEST['txt_verify'];
$nocheck=$_REQUEST['nocheck'];

if(0==strcmp($method,'action'))
{
	if(0==strcmp($txt_verify,zhPhpVeryifyCodeResult()) ||
	   0==strcmp($nocheck,'yes'))
	{ 
		if(is_email($email))
		{
			//生成校验内容,AES->CBC加密,再用base64转换,钥匙在_config.php文件里的email_action_key
			$aes=new PzhAes();
			$code='ck,'.$userid.','._today;
			$code=$aes->encrypt($code,email_action_key);
			$code=urlencode($code);
			$action_url=email_action_url."?code=$code";
	
			//查询账号的安全邮件
			$accountdb=new PzhMySqlDB();		
			$accountdb->open_mysql(cfg_accountdb_host,cfg_accountdb,cfg_accountdb_username,cfg_accountdb_passwd);
			$accountdb->query("select userid,nickname from tb_user_list where safe_email='$email'",0,0);
			if($rs=$accountdb->read())
			{
				$userid=$rs['userid'];
				$nickname=$rs['nickname'];

				/*生成校验内容,AES->CBC加密,钥匙在_config.php文件里的email_action_key
				加密的code分三部分 
					第一部分固定头 参数为'ck'
					第二部分是userid
					第三部分是由到邮件日期
				*/
				$aes=new PzhAes();
				$code='ck,'.$userid.','._today;
				$code=$aes->encrypt($code,email_action_key);
				$code=base64_encode($code);
				$action_url=email_action_url."?code=$code";

				//邮件发送校验码
				$emailto = $email; //需要发送的对方邮箱账号，以','分开
				$subject = "cloudkon账户验证"; //邮件主题
				$message = file_get_contents('templates/action_mail.tpl'); // 邮件内容
				
				//替换内容
				$message=str_replace('{$action_url}',$action_url,$message);
				$message=str_replace('{$userid}',$userid,$message);
				$message=str_replace('{$nickname}',$nickname,$message);
				
				define('CHARSET', 'utf8');
				$server  = email_server;
				$port    = email_port;
				$emailfr = email_fromemail;
				$emailpw = email_frompassword;
				$emailtp = 1;

				$sendmail = new PzhMail();
				$sendmail->set($server, $port, $emailfr, $emailpw, $emailtp, $emailfr);
				$result= $sendmail->send($emailto, $subject, $message, $emailfr) ? 0 :3;
			}
			else
			{
				//找不到此用户
				$result=4;
			}
			$accountdb->close();
		}
		else
		{
			//邮箱格式不对
			$result=2;
		}
	}
	else
	{
	   //验证码错误
		$result=1;
	}
	zhPhpVeryifyCodeDestory();	
}
else
{
	//无效操作
	$result=5;
}
//显示页面
$smarty = new Smarty;
$smarty->force_compile = smarty_force_compile;
$smarty->debugging = smarty_debugging;
$smarty->caching = smarty_caching;
$smarty->cache_lifetime = smarty_cache_lifetime;

$smarty->assign("username",$user);
$smarty->assign("result",$result);
$smarty->display('action_ret.tpl');

?>