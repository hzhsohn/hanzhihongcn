<?php
require_once("./_module/session.m.php");
//判断登录的SESSION
$userinfo=json_decode($_SESSION['ADMIN_INFO']);

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
 	$lineHeight=32;
}
else
{
	$lineHeight=18;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>韩智鸿的文档</title><style type="text/css">
<!--
.text1 {
	font-family: "Arial Black", Gadget, sans-serif;
	font-size: 36px;
	color: #FFF;
	padding-top: 10px;
}
.text3 {
	text-align: center;
	color: #FFF;
	font-size: 12px;
	font-family: Tahoma, Geneva, sans-serif;
	padding-top: 10px;
	text-decoration: none;
}
.text2 {
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 18px;
	color: #03F;
	text-decoration: none;
	padding-top: 20px;
	padding-right: 60px;
	padding-bottom: 20px;
	padding-left: 60px;
}
.text4 {
	text-align: right;
	padding-top: 10px;
}
.text4 a{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #FFF;
	text-decoration: none;
	padding-top: 15px;
	padding-right: 15px;
	padding-bottom: 30px;
	padding-left: 30px;
}
.text4 a:hover{
	font-weight: bold;
	color: #FC0;
}
.table {
	background-color: #DDD;
}
body {
	background-color: #333;
}
.lineBtn {
	padding: <?php echo $lineHeight?>px;
}
-->
</style></head>

<body>
<table width="800" border="1" align="center" cellspacing="0" class="table">
  <tr>
    <td height="100" valign="top" bgcolor="#336666"><div class="text4">
    <?php
    	if(is_null($userinfo))
		{ 
	?>
		<a href="admin">登录</a>
	<?php
		}else{
	?>
		<a href="admin">进入管理目录</a>
	<?php
		}
	?>
    
    </div><div align="center" class="text1">文档管理
    </div></td>
  </tr>
  <tr>
    <td align="center"><div class="lineBtn"><a href="notes" target="_parent" class="text2">我的记事本</a></div></td>
  </tr>
  <tr>
    <td align="center" ><div class="lineBtn"><a href="http://pan.baidu.com" target="_baidu_pan" class="text2">百度网盘</a></div></td>
  </tr>
  <tr>
    <td align="center" ><div class="lineBtn"><a href="gen_guid" target="_parent" class="text2">生成GUID</a></div></td>
  </tr>
  <tr>
    <td align="center" ><div class="lineBtn"><a href="gen_qr" target="_parent" class="text2">生成二维码</a></div></td>
  </tr>
  <tr>
    <td align="center" ><div class="lineBtn"><a href="websocket" target="_parent" class="text2">Websocket数据调试</a></div></td>
  </tr>
</table>
<div class="text3">
Copyright@2013 , Design By Han.zh , 粤ICP备13015372号</div>
</body>
</html>

