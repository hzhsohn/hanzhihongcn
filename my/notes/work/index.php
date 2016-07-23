<?php
require_once('../config.php');
require_once('../../_module/mysql.m.php');
require_once('../../_module/encode.m.php');
require_once("../../_module/session.m.php");

//判断登录的SESSION
$userinfo=json_decode($_SESSION['ADMIN_INFO']);
if(is_null($userinfo))
{
	echo '<meta http-equiv="refresh" content="0;url=../../admin/?reback=../notes/work">';
	echo'no userinfo';
	exit; 
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-
transitional.dtd">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>韩智鸿的工作文档</title>
<html xmlns="http://www.w3.org/1999/xhtml">
   <frameset frameborder="1" cols="57%,*">        
 <frame src="work_list.php" name="work_listFrame" id="work_listFrame" title="work_listFrame" />
  <frame src="" name="detailFrame"  id="detailFrame" title="detailFrame" />
 </frameset><noframes></noframes>
</html>