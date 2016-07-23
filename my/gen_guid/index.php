<?php
function create_guid() {
 $charid = strtoupper(md5(uniqid(mt_rand(), true)));
 $hyphen = chr(45);// "-"
 $uuid = chr(123)// "{"
 .substr($charid, 0, 8).$hyphen
 .substr($charid, 8, 4).$hyphen
 .substr($charid,12, 4).$hyphen
 .substr($charid,16, 4).$hyphen
 .substr($charid,20,12)
 .chr(125);// "}"
 return $uuid;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>生成GUID</title><style type="text/css">
<!--

.text1 {
	font-family: "Arial Black", Gadget, sans-serif;
	font-size: 18px;
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
	color: #FFF;
	text-decoration: none;
}

.table {
	background-color: #DDD;
}
body {
	background-color: #333;
}

a:link {
	color: #FFF;
	text-decoration: none;
}
a:visited {
	color: #FFF;
	text-decoration: none;
}
a:active {
	color: #FC0;
	text-decoration: none;
}
a:hover {
	text-decoration: none;
}
-->
</style></head>

<body>
<a href="../">返回档案</a><br />
<br />
<br />
<br />
<br />
<table width="800" border="1" align="center" cellspacing="0" class="table">
  <tr>
    <td height="33" align="center" valign="top" bgcolor="#336666" ><span class="text1">GUID</span></td>
    <td valign="top" bgcolor="#336666">&nbsp;</td>
  </tr>
  <tr>
    <td height="100" align="center" valign="middle" bgcolor="#336666" ><span class="text2"><?=create_guid()?></span></td>
    <td valign="middle" bgcolor="#336666" ><a href="?">刷新</a></td>
  </tr>
</table>
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<div class="text3">
Copyright@2013 , Design By Han.zh , 粤ICP备13015372号</div>
</body>
</html>
