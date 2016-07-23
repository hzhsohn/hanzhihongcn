{config_load file="member.conf"}
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
<form id="form1" name="form1" method="post" action="action_ret.php">
  <table width="522" border="1" align="center" cellspacing="0">
    <tr>
      <td height="81" align="center"><strong>激活账号</strong></td>
    </tr>
    <tr>
      <td align="center">账号
        <label>
          <input name="em" type="text" id="em" value="{$username}" size="20" maxlength="300" />
      </label></td>
    </tr>
    <tr>
      <td height="50" align="center"><div>
         验证码
        <input name="txt_verify" type="text" id="txt_verify" size="8" maxlength="10"  autocomplete="off" />
      <a href="javascript:refreshimg()"><img src="module/verifycode.m.php?action=verifycode" name="verifyimg" border="0" id="verifyimg" /></a></div></td>
    </tr>
    <tr>
      <td height="50" align="center"><p>
        <input type="submit" name="button" id="button" value="发送激活邮件" />
        <input name="method" type="hidden" id="method" value="action" />
      </p></td>
    </tr>
  </table> 
</form>
</body>
</html>