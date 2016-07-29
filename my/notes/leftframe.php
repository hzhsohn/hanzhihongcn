<?php
require_once('config.php');
require_once('../_module/mysql.m.php');
require_once('../_module/encode.m.php');

require_once("../_module/session.m.php");

//判断登录的SESSION
$userinfo=json_decode($_SESSION['ADMIN_INFO']);

//数据库路径
$db_path=realpath($db_filename);


$db=new PzhMySqlDB();	
$db->open_mysql(cfg_db_host,cfg_db,cfg_db_username,cfg_db_passwd);
$db->query("select * from typeone");
while($rs=$db->read()){
		$typeoneID[]=$rs['autoid'];
		$typeoneText[]=$rs['type_text'];
}

$db->open_mysql(cfg_db_host,cfg_db,cfg_db_username,cfg_db_passwd);
$db->query("select * from typetwo");
while($rs=$db->read()){
	$typetwoID[]=$rs['autoid'];
	$typetwoOneID[]=$rs['typeone_id'];
	$typetwoText[]=$rs['type_text'];
}
$db->close();

$db->open_mysql(cfg_db_host,cfg_db,cfg_db_username,cfg_db_passwd);
$db->query("select typetwo_id,count(*) as counts from information group by typetwo_id");
while($rs=$db->read()){
    //echo $rs['typetwo_id']->value.'---'.$rs['counts']->value.'<br/>';
	$typeGroupID[]=$rs['typetwo_id'];
	$typeGroupCounts[]=$rs['counts'];
}
$db->close();

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
if($angent_iphone || $angent_ipad || $angent_android)
{
    $lineHeight='20';
}
else
{
    $lineHeight='10';
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<style type="text/css">
<!--
ul{
	list-style-type:disc;
	padding-left: 38px;
}

ul li{
	padding-bottom: <?php echo $lineHeight?>px;
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 17px;
	color: #000;
	text-decoration: none;
}
a:link {
	color:#03F;
	text-decoration: none;
	padding-top: 5px;
	padding-right: 30px;
	padding-bottom: 5px;
	padding-left: 2px;
}
a:visited {
	color:#03F;
	text-decoration: none;
}
a:hover {
	color:#F00;
	text-decoration: none;
}
a:active {
	text-decoration: none;
}
.text1 {
    color:#AAA;
	padding-left:5px;
}
-->
</style>
</head>

<body>
<p><a href="../" target="_parent" >返回面板</a></p>
<hr />
<p><a href="type.php" target="rightframe">记事分类</a></p>
<p><a href="add_article.php" target="rightframe">添加笔记</a></p>
<hr />
<ul>
<?php
$counts=0;
for($k=0;$k<count($typeGroupID);$k++)
{
    if($typeGroupID[$k]==0)
    {$counts=$typeGroupCounts[$k];}
}
?>
<li><a href="list_article.php?showcount=100&typetwo=0" target="rightframe">未分类<span class="text1"><?php echo'('.$counts.')'; ?></span></a></li>
</ul>
<?php
	for($i=0;$i<count($typeoneID);$i++)
	{
		echo $typeoneText[$i];
		echo '<ul>';
		for($j=0;$j<count($typetwoID);$j++)
		{
			if($typeoneID[$i]==$typetwoOneID[$j])
			{
                $counts=0;
                for($k=0;$k<count($typeGroupID);$k++)
                {
                    if($typeGroupID[$k]==$typetwoID[$j])
                    {$counts=$typeGroupCounts[$k];}
                }
				echo '<li>';
				echo '<a href="list_article.php?showcount=100&typetwo='.$typetwoID[$j].'" target="rightframe">';
				echo $typetwoText[$j];
                echo '<span class="text1">('.$counts.')</span>';
				echo '</a>';
				echo '</li>';
			}
		}
		echo '</ul>';
	}
?>
</body>
</html>