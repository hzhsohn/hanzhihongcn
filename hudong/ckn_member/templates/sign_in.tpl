{config_load file="member.conf"}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{#title#}</title>
</head>
<body>
<div align="center">
{if 2==$login_ret_msg}
2. 登录成功
{else if 3==$login_ret_msg}
3. 你的账户还没激活,<a href="action.php?username={$username}">立即激活</a> {else if 4==$login_ret_msg}
4. 自动登录失败,请确定密码是否已经修改
{else if 5==$login_ret_msg}
5. 登录失败,请检测用户名或密码
{else if 6==$login_ret_msg}
6. 验证码错误
{else if 7==$login_ret_msg}
7. 已经登录了,正在获取用户信息
{/if} </div><br />
{if $login_ret}
<div align="center"><a href="manage.php">跳转至管理页面&gt;&gt;</a></div>
{else}
<div align="center"><a href="index.php">&lt;&lt;返回登录页面</a></div>
<p>{/if}</p>
</body>
</html>