<?php
require_once("myip/connection.m.php");

//数据库路径
$db_path=realpath('myip/myip_db.mdb');

$db=new CzhDB();
$db->open_access($db_path);
$db->query("select*from s_iplist where title='hzh_home'");
if($rs=$db->read())
{
  $title=$rs['title']->value;
  $ipv=$rs['ipv']->value;
  $uptime=$rs['uptime']->value;
}
$db->close();
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Author" content="Han.zhihong." />
<meta name="Category" content="developer,apple,andrpoid,products" />
<meta name="Description" content="韩智鸿的小博客,本网站只是用来技术交流和生活记事..." />
<meta name="image" content="http://www.hanzhihong.cn/pc/image/index/hzh_logo.png">
<title></title>
<html>
<body>
<?php
$host = 'http://'.$ipv.':81';
$loc = 'Location:'.$host.'/pc?wsadr='.$ipv;
header($loc);
exit;
?>
</body>
</html>
