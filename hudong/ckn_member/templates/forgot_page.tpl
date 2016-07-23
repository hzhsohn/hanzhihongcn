{config_load file="member.conf"}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{#title#}</title>
</head>
<body>
{if 1==$result} 
cd码错误
<p><a href="forgot.php">返回</a></p>
{elseif 2==$result}
cd码为空
<p><a href="forgot.php">返回</a></p>
{elseif 3==$result}
忘记密码邮件已经过期
{else}
<form id="form1" name="form1" method="post" action="forgot_page_ret.php">
  <p>输入新密码
  <input type="password" name="pwd1" id="pwd1" />
  </p>
  <p>确认新密码
    <input type="password" name="pwd2" id="pwd2" />
  </p>
  <p>
    <input type="submit" name="button" id="button" value="提交" />
    <input name="method" type="hidden" id="method" value="modify" />
    <input name="uid" type="hidden" id="uid" value="{$userid}" />
    <input name="rid" type="hidden" id="rid" value="{$randid}" />
  </p>
</form>
{/if}
</body>
</html>