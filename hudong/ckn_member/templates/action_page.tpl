{config_load file="member.conf"}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{#title#}</title>
</head>
<body>
<p>
  {if 1==$result} 
  账号成功激活
  <p><a href="login.php">登录</a></p>
  {elseif 2==$result}
  code码为空或出错
  <p><a href="action.php?username={$username}">重新激活</a></p>
  {elseif 3==$result}
  账户已经被激活过了
  <p><a href="login.php">登录</a></p>
  {elseif 4==$result} 
  激活邮件已经过期
  <p><a href="action.php?username={$username}">重新激活</a></p>
  {elseif 5==$result}
  操作数据库失败
  <p><a href="action.php?username={$username}">重新激活</a></p>
  {elseif 6==$result}
  用户还未注册
  <p><a href="register.php">注册用户</a></p>
  {elseif 7==$result}
  查询数据库失败
  <p><a href="action.php?username={$username}">重新激活</a></p>
  {/if}
</p>
</body>
</html>