{config_load file="admin.conf"}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{#title#}</title>
</head>
<script type="text/javascript">
<!--
function refreshimg() {
	document.getElementById('verifyimg').src='module/verifycode.m.php?action=verifycode';
}
// -->
</script>
<body>
<form id="form1" name="form1" method="post" action="sign_in.php">
  <table width="522" border="1" align="center" cellpadding="10" cellspacing="0">
    <tr>
      <td height="81" colspan="3" align="center"><h1><strong>定位管理系统</strong></h1></td>
    </tr>
    <tr>
      <td align="right">账号</td>
      <td colspan="2"><label>
        <input name="account" type="text" id="account" value="{$account}" size="20" />
      </label></td>
    </tr>
    <tr>
      <td align="right">密码</td>
      <td colspan="2"><input name="passwd" type="password" id="passwd" size="15" /></td>
    </tr>
    <tr>
      <td height="50" colspan="3" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td height="50" align="center">&nbsp;</td>
      <td height="50" align="center"><input type="submit" name="button" id="button" value="登录" />
      <input name="method" type="hidden" id="method" value="login" /></td>
      <td align="center"><a href="reg.php">快速注册</a></td>
    </tr>
  </table>
</form>
</body>
</html>