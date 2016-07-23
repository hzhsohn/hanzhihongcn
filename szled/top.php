<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?=$SITE_TITLE?></title>
<style type="text/css">
<!--
body {
	background-image: url(images/logo_back.gif);
}
body,td,th {
	font-size: 12px;
	color: #FFFFFF;
}
a:link {
	text-decoration: none;
	color: #FFFFFF;
}
a:visited {
	text-decoration: none;
	color: #FFFFFF;
}
a:hover {
	text-decoration: none;
	color: #FFCC00;
}
a:active {
	text-decoration: none;
	color: #FF0000;
}
.STYLE1 {color: #FFFF00}
.STYLE7 {
	font-size: 24px;
	font-family: "黑体";
}
-->
</style>
</head>
<script  language="javascript" type="text/javascript" src="js/noReflash.js"></script>
<script  language="javascript" type="text/javascript" src="js/ajax.js"></script>
<body leftmargin="0" topmargin="0">
<table width="100%" height="70" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="middle"><span class="STYLE7">后台管理系统
    </span></td>
    <td valign="bottom" ><table width="100%" border="0" align="right" cellpadding="0" cellspacing="0">
      <tr>
        <td align="right">&nbsp;</td>
        </tr>
      <tr>
        <td align="right">&nbsp;</td>
        </tr>
      <tr>
        <td align="right"><a href="out.module.php" target="_parent"><img src="images/20070414171339714.gif" border="0" alt="退出登陆" width="18" height="18" />退出登陆</a></td>
        </tr>
      
    </table></td>
    <td width="10">&nbsp;</td>
  </tr>
</table>
<script>
var timeOut=setTimeout("mSnd()",500);

function mSnd()
{
	getHTMLText("onlineMen","online.php");
	if(timeOut)
	clearTimeout(timeOut);
}

setInterval("mSnd()",50000);
</script>
</body>
</html>