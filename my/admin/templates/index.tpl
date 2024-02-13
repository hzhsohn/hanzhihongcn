{config_load file="admin.conf" section="setup"}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<style type="text/css">
<!--
body {
	background-image: url();
	background-color: #CCCCCC;
}
.box {
	height: 18px;
	width: 100px;
}
body,td,th {
	font-size: 14px;
	color: #000000;
}
.up {
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-style: none;
	border-top-color: #6699FF;
	border-right-color: #6699FF;
	border-bottom-color: #6699FF;
	border-left-color: #6699FF;
	border-bottom-style: solid;
}
.STYLE3 {
	font-size: 36px;
	font-weight: bold;
	color: #FFFFCC;
	font-family: Arial, Helvetica, sans-serif;
}
.STYLE7 { 
	font-size: 24px;
	}
.STYLE8 {
	font-weight: bold;
	color: #339900;
	text-decoration: none;
}
.STYLE9 {
	font-size: 12px;
	font-family: Arial, Helvetica, sans-serif;
	color: #0066FF;
	text-decoration: none;
}
.STYLE10 {
	color: #FFFFFF
}
-->
</style>
<title>管理员系统</title>
<body topmargin="10">
<div style="background-color:#FFF;width:80%;height:100%; margin-left:auto; margin-right:auto"><br>
              <br>
              <table  height="225" border="0" align="center" cellpadding="2" cellspacing="0" bgcolor="#F0F0F0">
  <tr>
    <td width="430" height="70" align="center" bgcolor="#3399FF"><span class="STYLE3"><span class="STYLE7">
      {#title#}
      </span></span></td>
    </tr>
  <tr>
    <td><form action="?" method="post" name="form1" id="form1" autocomplete="off">
      <table width="100%" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td  colspan="3" align="center" bgcolor="#FFFFCC">
          <span class="STYLE8">
            {if $err==1}
            	登录失败,没有此用户或密码错误!
            {else if $err==2}
            	页面超时,请重新登录!
            {/if}
		</span></td>
            </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td width="35%" align="right"><strong>账　号:</strong></td>
            <td width="65%" colspan="2"><input name="username" type="text" id="username" value="{$hzhcn_username}" size="15" maxlength="18"></td>
            </tr>
        <tr>
          <td align="right"><strong>密　码:</strong></td>
            <td colspan="2"><input name="passwd" type="password" class="box" id="passwd" maxlength="20"/></td>
        </tr>
        <tr>
          <td height="37" colspan="3" align="center" class="up">&nbsp;</td>
        </tr>
        <tr>
          <td height="37" colspan="3" align="center" class="up"><input type="submit" name="Submit" value="   登陆   " />
            <input type="hidden" name="method" value="login"> <input type="hidden" name="reback" value="{$reback}"></td>
        </tr>
        </table>
          </form>
      </td>
    </tr>
  <tr>
    <td align="center" bgcolor="#858585"><span class="STYLE10"> {#copyright#}</span></td>
    </tr>
  </table>
              <br>
              <br />
              <br />
              <br />
              <br />
              <br>
              <br>
              <br>
</div></body>
