{config_load file="member.conf"}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{#title#}</title>
</head>
<body>
<p>{if 1==$result} 
  验证码错误
  <p><a href="javascript:history.back()">返回</a></p>
  {elseif 2==$result}
  邮箱格式不对
  <p><a href="javascript:history.back()">返回</a></p>
  {elseif 3==$result}
  邮箱发送出错
  <p><a href="javascript:history.back()">返回</a></p>
  {elseif 4==$result}
  找不到此用户
  <p><a href="javascript:history.back()">返回</a></p>
  {elseif 5==$result}
  无效操作
  <p><a href="javascript:history.back()">返回</a></p>
  {else}
  激活邮件已经发送到{$username}的邮箱上面请查收
  <p><a href="login.php">登录</a></p>
  {/if} </p>

</body>
</html>