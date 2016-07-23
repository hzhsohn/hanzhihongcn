<?php
/**************************************

Author:Han.zhihong
remark:
发送激活邮件的模块

***************************************/
require_once("module/mysql.m.php");
require_once("module/mail.m.php");
require_once("module/crypt.m.php");
require_once("module/time.m.php");
require_once("_config.php");

//屏掉所有警告
error_reporting(E_ALL & ~E_NOTICE);

//注册成功
function printSuccess()
{
	$p=array('nRet'=>'1',
		 'time'=>_now
		 );
	echo json_encode($p);
}

//邮箱格式不对
function printEmailFormatErr()
{
	$p=array('nRet'=>'2',
			 'szErr'=>'email format error'
			 );
	echo json_encode($p);
}

//不存在用户
function printNoUser()
{
	$p=array('nRet'=>'3',
			 'szErr'=>'not exist account'
			 );
	echo json_encode($p);
} 

//发送失败
function printSendFail()
{
	$p=array('nRet'=>'4',
			 'szErr'=>'send email fail'
			 );
	echo json_encode($p);
}

//缺少参数
function printLostParameter()
{
	$p=array('nRet'=>'5',
			 'szErr'=>'lost parameter'
			 );
	echo json_encode($p);
}

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

  
/////////////////////////////////////////////////////////////
//获取数据
$email=$_REQUEST['em'];

if(strcmp($email,''))
{
	 
	if (false==is_email($email))
	{
		printEmailFormatErr();
		exit;
	}
	
	//查询账号的安全邮件
	$accountdb=new PzhMySqlDB();		
	$accountdb->open_mysql(cfg_accountdb_host,cfg_accountdb,cfg_accountdb_username,cfg_accountdb_passwd);
	$accountdb->query("select userid,nickname from tb_user_list where safe_email='$email'",0,0);
	if($rs=$accountdb->read())
	{
		$userid=$rs['userid'];
		$nickname=$rs['nickname'];
		
		/*
			修改密码数据库操作流程:
			1.查询密码重置请求记录
			2.插入或更新重置密码请求,包括内容有用户ID,重置密码随机标识
			3.如果更新页面,查询有密码更新请求.可进行密码重置操作
			4.重置密码操作成功,删除密码请求记录
		*/
		$accountdb->query("call sp_forgot_get_rand('$userid')",0,0);
		if($rs=$accountdb->read())
		{
			$passwdRandID=$rs['randid_'];
		
			/*生成校验内容,AES->CBC加密,再经过base64加密,钥匙在_config.php文件里的email_action_key
			加密的cd分四部分 
				第一部分固定头 参数为'ckpwd'
				第二部分是 用户ID
				第三部分是 重置密码随机标识
				第四部分是 提交日期
			*/
			$aes=new PzhAes();
			//echo email_reset_passwd_key."<br/>";
			$cd="ckpwd,$userid,$passwdRandID,"._today;
			//echo $cd."<br/>";
			$cd=$aes->encrypt($cd,email_reset_passwd_key);
			//echo $cd."<br/>";
			$cd=base64_encode($cd);
			//echo $cd."<br/>";
			$url=email_reset_passwd_url."?cd=$cd";
		
			//邮件发送校验码
			$emailto = $email; //需要发送的对方邮箱账号，以','分开
			$subject = "cloudkon重置密码"; //邮件主题
			$message = file_get_contents('templates/forgot_mail.tpl'); // 邮件内容
			//替换内容
			$message=str_replace('{$url}',$url,$message);
			$message=str_replace('{$email}',$email,$message);
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
			if($sendmail->send($emailto, $subject, $message, $emailfr))
			{
				//发送成功
				printSuccess();
			}
			else
			{
				//发送失败
				printSendFail();
			}
		}
	}
	else
	{
		//找不到此用户
		printNoUser();
	}
	$accountdb->close();
}
else
{
	//缺少参数
	printLostParameter();
}

?>