{config_load file="admin.conf"}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{#title#}</title>
</head>
<body>
<div align="center">
{if 1==$result}
1. 登录成功
<div align="center"><a href="manage.php">跳转至管理页面&gt;&gt;</a></div>
{else if 2==$result}
2. 你的用户角色没有管理员权限
<div align="center"><a href="index.php">&lt;&lt;返回登录页面</a></div>
{else if 3==$result}
3. 账号已经被禁用
<div align="center"><a href="index.php">&lt;&lt;返回登录页面</a></div>
{else if 4==$result}
4. 账号未注册
<div align="center"><a href="index.php">&lt;&lt;返回登录页面</a></div>
{else if 5==$result}
5. 登录失败,请检测用户名或密码
<div align="center"><a href="index.php">&lt;&lt;返回登录页面</a></div>
{else if 6==$result}
6. 验证码错误
<div align="center"><a href="index.php">&lt;&lt;返回登录页面</a></div>
{else if 7==$result}
7. 已经登录了,正在获取管理员信息
<div align="center"><a href="index.php">&lt;&lt;返回登录页面</a></div>
{else if 8==$result}
8. 一键登录失败,请确认密码是否已经修改
<div align="center"><a href="index.php">&lt;&lt;返回登录页面</a></div>
{else}
数据库信息错误
<div align="center"><a href="index.php">&lt;&lt;返回登录页面</a></div>
{/if}
</div>
</body>
</html>