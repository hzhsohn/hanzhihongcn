<?php
require_once('../public/encode.m.php');
require_once('../public/mysql.m.php');
require_once('../public/redirect.m.php');
require_once('../public/session.m.php');
require_once('../public/_config.php');

$ADMIN_INFO=zhPhpSessionGet("ADMIN_INFO");
if($ADMIN_INFO)
{
 $EX_INFO=explode(',',$ADMIN_INFO);
 $ADMIN_USER=$EX_INFO[0];
 $ADMIN_LEVEL=$EX_INFO[1];
}
else
zhPhpRedirect("../login.php?err=2");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

<style type="text/css">
<!--
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: none;
	color:#F00;
}
a:active {
	text-decoration: none;
}
.text1 {
	color: #FFF;
	text-decoration: none;
	font-size: 18px;
	font-family: Arial, Helvetica, sans-serif;
}

body {
	background-color: #09F;
	font-size: 18px;
}

-->
</style>
<script>
function MM_goToURL() {
    var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
    for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
</script>
</head>
<body>
<?php
//判断登录的SESSION
$userinfo=json_decode($_SESSION['ADMIN_INFO']);

//1.html   2.delete 
$method=$_REQUEST['method'];
if(0==strcmp($method,'delete'))
{
	//$set_name 负责人
	$autoid=$_REQUEST['autoid'];
	$autoid=$autoid;
	if(0==strcmp($autoid,''))
	{
		echo 'err="autoid is null"';
		exit;
	}
	
	$sql='delete from tbNews where autoid='.$autoid;

	$db=new PzhMySqlDB();	
	$db->open_mysql(cfg_db_host,cfg_db_name,cfg_db_username,cfg_db_passwd);
	if($db->query($sql,0,0))
	{
		$method='html';
	}
	else
	{
		$page=$_REQUEST['page'];
		$showcount=$_REQUEST['showcount'];
		$sequence=$_REQUEST['sequence'];
		echo 'delete operator <a href="?method=html&page='.$page.'&showcount='.$showcount.'&sequence='.$sequence.'&typetwo='.$typetwo.'">fail..</a>';
	}
	$db->close();
}

//-----------------------------------------------------------
//参数处理

//开始页数为0
$page=$_REQUEST['page'];
if(0==strcmp($page,''))
{
	$page=0;
	//echo 'err="page is null,0=begin page"';
	//exit;
}
//$showcount为0时显示全部
$showcount=$_REQUEST['showcount'];
if(0==strcmp($showcount,''))
{
	$showcount=10;
	//echo 'err="showcount is null,0=show all"';
	//exit;
}
//&sequence排序0为顺序,1为倒序
$sequence=$_REQUEST['sequence'];
if(0==strcmp($sequence,''))
{
	$sequence=0;
	//echo 'err="sequence is null,0=asc 1=desc"';
	//exit;
}

if($sequence==0)
{$orderby=' asc';}
else
{$orderby=' desc';}

//区分设备
$agent = strtolower($_SERVER['HTTP_USER_AGENT']);
$angent_ary=explode('(',$agent);
$angent_ary=explode(')',$angent_ary[1]);
if(count($angent_ary)>0)
{
    $agent=$angent_ary[0];
    $angent_win = (strstr($agent, 'windows nt')) ? 1 : 0;//pc
    $angent_mac = (strstr($agent, 'macintosh')) ? 1 : 0;//pc
    $angent_iphone = (strstr($agent, 'iphone')) ? 1 : 0;//ios
    $angent_ipad = (strstr($agent, 'ipad')) ? 1 : 0;//ios
    $angent_android = (strstr($agent, 'android')) ? 1 : 0;//android
    
}

if($angent_iphone || $angent_ipad || $angent_android){
    $lineHeight='45';
}
else
{
    $lineHeight='20';
}
//-----------------------------------------------------------
//显示页面内容
$db=new PzhMySqlDB();	
$db->open_mysql(cfg_db_host,cfg_db_name,cfg_db_username,cfg_db_passwd);

$db->query('select *from tbNews order by uptime'.$orderby,$showcount,$page);
?>

<span class="text1">
消息发布
</span>
<hr/>
<table width=100% border=1 cellpadding=5 cellspacing=0 style="background-color:#EEE">
<tr bgcolor="#CCCCCC">
<td>标题</td>
<td>时间</td>
<td width="10%">操作</td>
</tr>
<?php

$i=0;
while($rs=$db->read())
{
	$autoid=$rs['autoid'];
	$title=$rs['title'];
	
	//$content=$rs['content'];
	$uptime=$rs['uptime'];
	echo '<tr height="'.$lineHeight.'">';
	echo '<td><a id="titleID'.$i.'" href="detail.php?id='.$autoid.'">'.$title.'</a></td>';//标题
	echo '<td>'.$uptime.'</td>';//时间
	echo '<td width="13%">';
	//echo '<span style="float:left;"><a href="update_article.php?id='.$autoid.'">修改</a></span>';
	echo '<span><a href="javascript:void(0)" onclick="var str=\'确定删除 [ \'+document.getElementById(\'titleID'.$i.'\').innerHTML+\' ] 吗?\';if(confirm(str))MM_goToURL(\'self\',\'?method=delete&page='.$page.'&showcount='.$showcount.'&sequence='.$sequence.'&autoid='.$autoid.'\')">删除</a></span></td>';

echo '</tr>';
	$i++;
}
?>
<tr bgcolor="#CCCCCC">
<td colspan="4" bgcolor="#FFFFFF"><div><a href="add.php" >添加新记录</a></div>
<?php
if($showcount>0)
{
	$db->query('select count(*) from tbNews',0,0);
	$rsct=$db->read();
	$n=$rsct[0]/$showcount;
	if($n>1)//小于2页不显示当前第几页这文字
	{
		echo '</br>当前第'.($page+1).'页</br></br>';
		for($i=0;$i<=$n;$i++)
		{
			echo '<a href="?method='.$method.'&page='.$i.'&showcount='.$showcount.'&sequence='.$sequence.'&typetwo='.$typetwo.'">第'.($i+1).'页</a>&nbsp;&nbsp;&nbsp;&nbsp;';
		}
	}
}
$db->close();

?>
</td>
</tr>
</table>

</body>
</html>