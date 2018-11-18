{config_load file="admin.conf"}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{#title#}</title>
<style type="text/css">
<!--
-->
</style></head>
<style>
.inptx{
	width:99%;
}
</style>
<body>
<div align="center">
  <p>
  {if 1==$result}
  <font color="#FF3300"><strong>*注册成功</strong></font>
  <p><a href="index.php">返回登录</a></p>
    {else if 2==$result}
    <font color="#FF3300"><strong>*已经存在重复用户</strong></font>
    <p><a href="reg.php">返回注册</a></p>
    {else}
    <font color="#FF3300"><strong>数据库连接失败</strong></font>
    <p><a href="reg.php">返回注册</a></p>
    {/if}
  </p>
  
</div>
</body>
</html>