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
	//document.getElementById('verifyimg').src='module/verifycode.m.php?action=verifycode';
}
// -->
</script>
<body>
<form id="form1" name="form1" method="post" action="register_ret.php">
  <table width="522" border="1" align="center" cellspacing="0">
    <tr>
      <td height="81" align="center">注册</td>
      <td height="81" align="center"><a href="login.php">登录</a></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><p><div>
          <label>用户名
            <input name="txt_username" type="text" id="txt_username" maxlength="100" />
        </label></div>
      </p>
      <p>&nbsp;</p>
      <div>
        <label>呢称
          <input name="txt_nickname" type="text" id="txt_nickname" maxlength="32" />
        </label>
      </div>
      <p> <div>
        <label>密码
          <input name="txt_password1" type="password" id="txt_password1" maxlength="32" />
        </label>
      </div>
      <div>
        <label>确定密码
<input name="txt_password2" type="password" id="txt_password2" maxlength="32" />
        </label>
      </div></p>
     
      <p>&nbsp;</p>
      <div>安全邮箱
        <input name="txt_email" type="text" id="txt_email" maxlength="256" />
      </div>
      <p>验证码
        <input name="txt_verify" type="text" id="txt_verify" size="8" maxlength="10"  autocomplete="off" />
      <a href="javascript:refreshimg()"><img src="module/verifycode.m.php?action=verifycode" name="verifyimg" border="0" id="verifyimg" /></a></p>
      <p>
        <input type="submit" name="button" id="button" value="提交" />
        <input name="method" type="hidden" id="method" value="register" />
      </p></td>
    </tr>
  </table> 
</form>
</body>
</html>