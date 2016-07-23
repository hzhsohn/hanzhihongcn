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
<td>外网IP地址</td>
<td>设备名称</td>
<td>局域网IP</td>
<td>设备MAC地址</td>
<td>外网端口</td>
<td>设备芯片编号</td>
</tr>
<?php
while($rs=$db->read())
{
	$devname=$rs['devname']->value;
	$ipv=$rs['ipv']->value;
  $uptime=$rs['uptime']->value;
  $localip=$rs['localip']->value;
  $macaddr=$rs['macaddr']->value;
  $eport=$rs['eport']->value;
  $chipid=$rs['chipid']->value;
?>
<tr>
<td><?=$uptime ?></td>
<td><?=$ipv ?></td>
<td><?=$devname ?></td>
<td><?=$localip?></td>
<td><?=$macaddr?></td>
<td><?=$eport?></td>
<td><?=$chipid?></td>
</tr>

  <?
	$db->record_next();
}
?>
</table>

<?
$db->close();
 
?>