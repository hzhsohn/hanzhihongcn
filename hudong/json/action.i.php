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



//注册成功
function printSuccess($userid,$nickname)
{
	$p=array('nRet'=>'1',
		 'userid'=>$userid,
		 'nickname'=>$nickname,
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
			 'szErr'=>'not exist userid'
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
		
		/*生成校验内容,AES->CBC加密,再用base64转换,钥匙在_config.php文件里的email_action_key
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
		if($sendmail->send($emailto, $subject, $message, $emailfr))
		{
			//发送成功
			printSuccess($userid,$nickname);
		}
		else
		{
			//发送失败
			printSendFail();
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