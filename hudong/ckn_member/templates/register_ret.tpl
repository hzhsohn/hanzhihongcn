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
  用户名不能为空
  <p><a href="javascript:history.back()">返回</a></p>
  {elseif 3==$result}
  该用户名已经存在
  <p><a href="javascript:history.back()">返回</a></p>
  {elseif 4==$result}
  服务器操作失败
  <p><a href="javascript:history.back()">返回</a></p>
  {elseif 5==$result}
  两次密码不一样
  <p><a href="javascript:history.back()">返回</a></p>
  {elseif 6==$result}
  无效操作
  <p><a href="javascript:history.back()">返回</a></p>
  {else}
  注册成功
 <form action="action_ret.php" method="post">
   <label>
     <input type="submit" name="button" id="button" value="立即激活账号" />
   </label>
   <input name="txt_username" type="hidden" id="txt_username" value="{$username}" />
   <input name="nocheck" type="hidden" id="nocheck" value="yes" />
   <input name="method" type="hidden" id="method" value="action" />
</form>
  {/if} </p>

</body>
</html>