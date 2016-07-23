<?php
require_once('../public/encode.m.php');
require_once('../public/mysql.m.php');
require_once('../public/redirect.m.php');
require_once('../public/session.m.php');
require_once('../public/_config.php');
require_once("ueedit_encode.php");

$article_id=$_REQUEST['id'];
if(0==strcmp($article_id,''))
{
	echo 'err="id is null"';
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>代码笔记</title>
<style type="text/css">
<!--
.back{
	font-size: 20px;
	color: #FFF;
	text-decoration: none;
	font-family: Arial, Helvetica, sans-serif;
}
.back:hover{
	color:#FC0;
	font-weight: bold;
}
.text1{
	color: #DDD;
	font-size: 17px;
	font-family: Arial, Helvetica, sans-serif;
}
.text2{
	color: #DDD;
	font-size: 12px;
	font-family: Arial, Helvetica, sans-serif;
}
body {
	background-color: #09F;
}
body,td,th {
	font-size: 14px;
}
-->
</style>
</head>
<body>
<a class="back" href="javascript:history.back()">返回</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="back" href="update.php?id=<?=$article_id?>">修改</a>
<hr/>
<?php
    $db=new PzhMySqlDB();	
	$db->open_mysql(cfg_db_host,cfg_db_name,cfg_db_username,cfg_db_passwd);
	$db->query('select *from tbProduct where autoid='.$article_id,0,0);
	if($rs=$db->read())
	{
		//$autoid=$rs['autoid'];
		$title=$rs['title'];
		$titleimg=$rs['titleimg'];
		$content=$rs['remark'];
		$uptime=$rs['uptime'];
?>
<table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" style="background-color:#FFF">
  <tr>
    <td height="22" valign="bottom" bgcolor="#666666"><div class="text1">标题: <?=$title?>&nbsp;</div></td>
  </tr>
  <tr>
    <td height="18" valign="top" bgcolor="#666666"><img src="<?=$titleimg?>" width="300"/></td>
  </tr>
  <tr>
    <td height="18" valign="top" bgcolor="#666666">
    <div class="text2">时间: <?=$uptime?>&nbsp;</div>
    </td>
  </tr>
  <tr>
    <td height="520" valign="top"><?=ueTrHtml($content)?></td>
  </tr>
</table>
<?php
}
else
{
echo 'not find article id='.$article_id;
}
$db->close();?>
</body>
</html>
