<?php
require_once('../public/encode.m.php');
require_once('../public/mysql.m.php');
require_once('../public/redirect.m.php');
require_once('../public/session.m.php');
require_once('../public/_config.php');
require_once("ueedit_encode.php");

$method=$_REQUEST['method'];
if(0==strcmp($method,'add'))
{
	$title=trim($_REQUEST['title']);
	$conent=$_REQUEST['cnt'];
	$conact=$_REQUEST['conact'];
	$nickname=$_REQUEST['nickname'];
	
	if(''==$conact)
	{
		$conact='无';
	}
	if(''==$nickname)
	{
		$nickname='匿名';
	}
	
	$title=zhPhpTrSql($title);
	$conent=zhPhpTrSql($conent);
	$conact=zhPhpTrSql($conact);
	$nickname=zhPhpTrSql($nickname);
	
	$ip=$_SERVER['REMOTE_ADDR'];
	
	$conent=ueTrSql($conent);//将字符串进行处理
	if(get_magic_quotes_gpc())//如果get_magic_quotes_gpc()是打开的
	{
		$conent=stripslashes($conent);//将字符串进行处理
	}

	$db=new PzhMySqlDB();	
	$db->open_mysql(cfg_db_host,cfg_db_name,cfg_db_username,cfg_db_passwd);
	if($db->query("insert into tbFreeback(ip,title,remark,conact,nickname) values('$ip','$title','$conent','$conact','$nickname')"))
	{
		//$db->query("select @@identity");
		echo "添加成功... <a href=?>继续添加</a>";
	}
	else
	{
		echo "------- 操作失败 ------<a href=?>继续添加</a>--";
	}
	$db->close();
	exit;
}


$db=new PzhMySqlDB();	
$db->open_mysql(cfg_db_host,cfg_db,cfg_db_username,cfg_db_passwd);
$db->query("select * from typeone");
while($rs=$db->read()){
		$typeoneID[]=$rs['autoid'];
		$typeoneText[]=$rs['type_text'];
}

$db=new PzhMySqlDB();	
$db->open_mysql(cfg_db_host,cfg_db,cfg_db_username,cfg_db_passwd);
$db->query("select * from typetwo");
while($rs=$db->read()){
	$typetwoID[]=$rs['autoid'];
	$typetwoOneID[]=$rs['typeone_id'];
	$typetwoText[]=$rs['type_text'];
}
$db->close();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<style type="text/css">
<!--
.STYLE1 {
	font-size: 12px;
	color: #FF0000;
}
body,td,th {
	font-size: 12px;
}
.STYLE2 {
	font-size: 24px;
	font-weight: bold;
	color: #FFFFFF;
}
-->
</style>
<script src="../js/trim.js"></script>
<style type="text/css">
<!--
body {
	background-color: #CCC;
}
-->
</style></head>
<body>
<table width="100%" border="1" cellspacing="0" cellpadding="0" style="background-color:#f5f6fa">
  <tr>
    <td height="28" align="center" bgcolor="#669900"><span class="STYLE2">添加反馈</span></td>
  </tr>
  <tr>
    <td valign="top"><form action="?" method="post" enctype="multipart/form-data" name="form1">
      <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
        <tr>
          <td  align="center">标题：
<input name="title" ty
            pe="text" id="title" size="25" maxlength="100" />
<input name="method" type="hidden" id="typename" value="add"/></td>
          </tr>
        <tr>
          <td align="center" valign="top"><textarea name="cnt" cols="100" rows="10" id="cnt"></textarea></td>
        </tr>
        <tr>
          <td align="center" valign="top">您的呢称:
            <input name="nickname" ty="ty"
            pe="text" id="nickname" size="25" maxlength="100" /></td>
        </tr>
        <tr>
         <td align="center" valign="top">联系方式:
           <input name="conact" ty="ty"
            pe="text" id="conact" size="25" maxlength="100" /></td>
         </tr>
        <tr>
          <td align="center">
            <script>
		  function sendok()
				{
				if(trim(form1.title.value)==""){
					alert('请填写标题');
				}else if(form1.cnt.value==""){
				  alert("请填入内容");
				}else{
				 	form1.submit();
				 }
				}
		  </script><br /><input type="button" name="Submit" onclick="sendok()" value=" 提交 "></td>
          </tr>
      </table>
    </form>    </td>
  </tr>
</table>
</body>
