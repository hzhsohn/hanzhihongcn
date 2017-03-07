<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<?php
require_once("connection.m.php");
require_once("encode.m.php");

//数据库路径
$db_path=realpath('myip_db.mdb');

$db=new CzhDB();
$db->open_access($db_path);
?>
<br />
<a href="../" target="_parent">返回主页</a><br />
<br />
<form method="get" action="">
  <input type="submit" value="删除所有" />
  <input type="hidden" name="opt" id="opt" value="clean" />
</form>
<?

$opt=$_REQUEST['opt'];
if(0==strcmp($opt,"clean"))
{
  $db->query("delete from s_iplist");
  header("Location:?");
  exit;
}

$db->query("select * from s_iplist");
?>
<table width=100% border=1 cellpadding=5 cellspacing=0 style="background-color:#EEE">
<tr bgcolor="#CCCCCC">
<td>更新时间</td>
<td>标题</td>
<td>IP地址</td>
<td>接口地址</td>
</tr>
<?php
while($rs=$db->read())
{
	$title=$rs['title']->value;
	$ipv=$rs['ipv']->value;
    $uptime=$rs['uptime']->value;
 
?>
<tr>
<td><?=$uptime ?></td>
<td><?=$title ?></td>
<td><?=$ipv ?></td>
<td><a href="getip.i.php?title=<?=$title?>" target="_blank">getip.i.php?title=<?=$title?></a></td>
</tr>

  <?
	$db->record_next();
}
?>
</table>

<?
$db->close();
 
?>