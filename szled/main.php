<?php
require_once('public/encode.m.php');
require_once('public/mysql.m.php');
require_once('public/redirect.m.php');
require_once('public/session.m.php');
require_once('public/_config.php');

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
<style type="text/css">
<!--
body {
	
	background-color: #26A8FF;

}
.STYLE1 {
	font-size: 36px;
	font-family: "黑体";
	color: #CCFF66;
}
.STYLE2 {
	font-size: 16px;
	color: #FFFFFF;
}
.STYLE4 {color: #FFFFFF}
.STYLE5 {color: #FF99FF}
.STYLE9 {color: #CCFF66}
body,td,th {
	font-size: 12px;
}




-->
</style><title>后台管理系统</title>
<table width="90%" height="90%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="3"><div align="center" class="STYLE1" >用户 <?=$ADMIN_USER ?> <br/>欢迎使用管理系统</div>　　</td>
  </tr>
  
</table>
