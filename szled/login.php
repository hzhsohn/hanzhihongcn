<?php
require_once('public/encode.m.php');
require_once('public/mysql.m.php');
require_once('public/redirect.m.php');
require_once('public/session.m.php');
require_once('public/_config.php');

if($ADMIN_INFO)zhPhpRedirect("index.php");

$err=$_REQUEST['err'];


if($_REQUEST['Send']==1)
{
	$username=$_REQUEST['username'];
	$PASSWORD=$_REQUEST['PASSWORD'];
	
	$_CON=new PzhMySqlDB();		
	$_CON->open_mysql(cfg_db_host,cfg_db_name,cfg_db_username,cfg_db_passwd);
	
	$PASSWORD=md5($PASSWORD);
	$username=zhPhpTrSql($username); 
	$_CON->query("select * from tbAdmin where password='$PASSWORD' and username='$username'");
	if($rs=$_CON->read())
	{
		$ADMIN_INFO=$rs['username'].',';
		$ADMIN_INFO.=$rs["level"].',';	
		$ADMIN_INFO.=$rs["conent"];
		setcookie("ADMIN_LAST_LOGIN_TIME",$rs["lastlogin"],null,'/');
		setcookie("ADMIN_LAST_LOGIN_IP",$rs["ip"],null,'/');
		//判断是否保存账号
		if($saveAccount==1)
		setcookie("SaveAccount",$username,time()+3600*24*3,'/');
		
		zhPhpSessionSet("ADMIN_INFO",$ADMIN_INFO);
	
		$_CON->query("update tbAdmin set lastlogin=now(),ip='".$_SERVER['REMOTE_ADDR']."' where username='".$rs['username']."'");
		zhPhpRedirect("index.php");
	}
	else
	{
		$err=1;
	}
	
	$_CON->close();
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<style type="text/css">
<!--
body {
	background-image: url();
	background-color: #CCCCCC;
}
.box {
	height: 18px;
	width: 100px;
}
body,td,th {
	font-size: 14px;
	color: #000000;
}
.up {
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-style: none;
	border-top-color: #6699FF;
	border-right-color: #6699FF;
	border-bottom-color: #6699FF;
	border-left-color: #6699FF;
	border-bottom-style: solid;
}
.STYLE3 {	font-size: 36px;
	font-weight: bold;
	color: #FFFFCC;
	font-family: Arial, Helvetica, sans-serif;
}
.STYLE7 {font-size: 24px}
.STYLE8 {
	font-weight: bold;
	color: #339900;
	text-decoration: none;
}
.STYLE9 {
	font-size: 12px;
	font-family: Arial, Helvetica, sans-serif;
	color: #0066FF;
	text-decoration: none;
}
.STYLE10 {color: #FFFFFF}
-->
</style>
<title><?=$SITE_TITLE?>后台管理系统--登录</title>
<script  language="javascript" type="text/javascript" src="js/noReflash.js"></script>
<body topmargin="10">
<div style="background-color:#FFFFFF;width:80%;height:500px; margin-left:auto; margin-right:auto"><br>
              <br>
              <table  height="225" border="0" align="center" cellpadding="2" cellspacing="0" bgcolor="#F0F0F0">
  <tr>
    <td width="430" height="70" background="images/logo_back.gif" align="center"><span class="STYLE3"><span class="STYLE7">
      后台管理系统 
      </span></span></td>
    </tr>
  <tr>
    <td><form action="?" method="post" name="form1" id="form1" autocomplete="off">
      <table width="100%" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td height="55" colspan="2" align="center" bgcolor="#FCFCFC"><span class="STYLE8">
            <?php
		  switch($err){
		  	case 1: echo '登录失败,没有此用户或密码错误!';break;
			case 2: echo '页面超时,请重新登录!';break;
			case 3: echo '答案不正确!';break;
		  };?></span></td>
            </tr>
        
        <tr>
          <td width="35%" align="right"><strong>账　号:</strong></td>
            <td><input name="username" type="text" id="username" value="<?=$SaveAccount?>" size="15" maxlength="18">
              <span class="STYLE9" title="若你在网吧登录请勿选取此项,记录只保存三天">
			  <label><input name="saveAccount" type="checkbox" id="saveAccount" value="1" />
              保存账户</label></span> </td>
            </tr>
        <tr>
          <td align="right"><strong>密　码:</strong></td>
            <td><input name="PASSWORD" type="password" class="box" id="PASSWORD" maxlength="20"/></td>
        </tr>
       
        <tr>
          <td align="right" valign="top">&nbsp;</td>
            <td valign="top">&nbsp;</td>
            </tr>
        <tr>
          <td height="37" colspan="2" align="center" class="up"><input type="submit" name="Submit" value="   登陆   " />
            <input type="hidden" name="Send" value="1"></td>
          </tr>
        </table>
          </form>
      </td>
    </tr>
  <tr>
    <td align="center" bgcolor="#858585">&nbsp;</td>
    </tr>
  </table>
              <br>
              <br />
              <br />
              <br />
              <br />
              <br>
              <br>
              <br>
</div></body>
