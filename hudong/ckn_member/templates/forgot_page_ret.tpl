{config_load file="member.conf"}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{#title#}</title>
</head>
<body>
{if 1==$result} <br />
密码已经修改成功<br />
<p><a href="index.php">回到主页</a></p>
{elseif 2==$result} <br />
没有操作参数<br />
<p><a href="forgot.php">返回</a></p>
{elseif 3==$result}<br />
无效cd码<br />
<p><a href="forgot.php">返回</a></p>
{elseif 4==$result}<br />
无效账户<br />
<p><a href="forgot.php">返回</a></p>
{elseif 5==$result}<br />
数据库操作失败<br />
<p><a href="forgot.php">返回</a></p>
{elseif 6==$result}<br /> 
两次密码不一样
<br />
<p><a href="forgot.php">返回</a></p>
{/if}

</body>
</html>