{config_load file="admin.conf"}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{#title#}</title>
<style type="text/css">
<!--
#navigation {
	width: 960px; /* 自动边距（与宽度一起）会将页面居中 */
	margin-top: 0;
	margin-right: auto;
	margin-bottom: 18;
	margin-left: auto;
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 12px;
}
#mid #nav2 #form1 {
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 14px;
}
#mid #left {
	width: 22%;
	margin-right: auto;
	border-right-style: solid;
	border-right-width: 2px;
	border-right-color: #690;
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 12px;
	height: 400px;
}
#mid #nav2 #form1 p {
	color: #F00;
}
#logobar {
	width: 100%;
	background-color: #060;
	height: 80px;
	margin-bottom: 18px;
}
#logobar #title {
	margin-right: auto;
	margin-left: auto;
	width: 960px;
	vertical-align: middle;
}
#mid {
	width: 960px; /* 自动边距（与宽度一起）会将页面居中 */
	margin-top: 0px;
	margin-right: auto;
	margin-left: auto;
	margin-bottom: 25px;
}
#mid #right {
	width: 79%;
	margin-left: auto;
	height: 380px;
}

#mid #nav2 {
	width: 76%;
}

#mid nav2 ol {
	color: #111;
	font-weight: normal;
	font-family: Tahoma, Geneva, sans-serif;
}

.fltrt { /* 此类可用来使页面中的元素向右浮动。浮动元素必须位于页面上要与之相邻的元素之前。 */
	float: right;
	margin-left: 8px;
}
.fltlft { /* 此类可用来使页面上的元素向左浮动 */
	float: left;
	margin-right: 8px;
}

.clearfloat { /* 此类应当放在 div 或 break 元素上，而且该元素应当是完全包含浮动的容器关闭之前的最后一个元素 */
	clear:both;
    height:0;
    font-size: 1px;
    line-height: 0px;
}

#footer {
	width: 100%; /* 自动边距（与宽度一起）会将页面居中 */
	margin-top: 28px;
	margin-right: auto;
	margin-bottom: 28px;
	margin-left: auto;
	border-top-width: 2px;
	border-top-style: solid;
	border-top-color: #090;
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 12px;
	color: #666;
	height: 50px;
	padding-top: 10px;
	text-align: center;
}
#logobar #title #logo {
	width: 22%;
}
#logobar #title #nav {
	width: 76%;
	text-align: center;
}

#mid a:link {
 color: #000000;
 TEXT-DECORATION: none
}
#mid a:visited {
 COLOR: #000000;
 TEXT-DECORATION: none
}
#mid a:hover {
 COLOR: #ff7f24;
 text-decoration: underline;
}
#mid a:active {
 COLOR: #ff7f24;  
 text-decoration: underline;
}

#mid #left ul li {
	padding-bottom: 6px;
}

#msg {
	width: 960px; /* 自动边距（与宽度一起）会将页面居中 */
	margin-top: 0px;
	margin-right: auto;
	margin-left: auto;
	border-top-width: 2px;
	border-top-style: solid;
	border-top-color: #690;
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 12px;
}
#logobar #title #logo img {
	padding-top: 10px;
}

-->
</style>
</head>
<body bgcolor="#F8F8F8">
<div id="mid">
  <div id="left" class="fltlft">
  {include file="leftbar.tpl" title=leftbar}
  </div>
  <div id="nav2" class="fltrt">
  <form id="form1" name="form1" method="post" action="">
    <h3>更改密码</h3>
    <hr/>
    <p>
    {if $result==1}
    *两次密码不相同
    {elseif $result==2}
    *修改密码成功
    {elseif $result==3}
    *密码更改失败
    {elseif $result==4}
    *旧密码不对
    {elseif $result==5}
    *亲,密码不要留空哦!
    {/if}
    </p>
    <table width="100%" border="0" cellpadding="10" cellspacing="0">
      <tr>
        <td>用户名:</td>
        <td>{$username}</td>
      </tr>
      <tr>
        <td width="12%">旧密码: </td>
        <td width="88%"><input name="oldpassword" type="password" id="oldpassword" size="30" maxlength="20" /></td>
      </tr>
      <tr>
        <td>新密码</td>
        <td><input name="password" type="password" id="password" size="30" maxlength="20" /></td>
      </tr>
      <tr>
        <td>确认密码:</td>
        <td><input name="password2" type="password" id="password2" size="30" maxlength="20" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><input type="submit" name="button" id="button" value="提交" />
          <input name="method" type="hidden" id="method" value="update" /></td>
      </tr>
    </table>
  </form>
  </div>
  <br class="clearfloat" />
</div>
<div id="footer">{#copyright#}</div>
</body>
</html>