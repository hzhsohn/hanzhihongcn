{config_load file="admin.conf" section="setup"}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{#title#}</title>
<style type="text/css">
<!--
.STYLE1 {
	color: #FF0000;
	text-decoration: none;
}
body,td,th {
	font-size: 12px;
}
.dline {
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-bottom-style: solid;
	border-top-color: #999999;
	border-right-color: #999999;
	border-bottom-color: #999999;
	border-left-color: #999999;
}
a:link {
	text-decoration: none;
	color: #0033FF;
}
a:visited {
	text-decoration: none;
	color: #0000FF;
}
a:hover {
	text-decoration: none;
	color: #FF0000;
}
a:active {
	text-decoration: none;
	color: #33CC00;
}
.STYLE2 {
	color: #FF0000
}
-->
</style>

</head>
<body>
<span class="STYLE1">管理员列表</span>
<hr />

<div style="width:15%; float:left">{include file="leftbar.tpl" title=leftbar}</div>
<div style="width:84%; float:right"><table width="100%" border="0" align="center" cellpadding="4" cellspacing="0">
  <tr>
    <td  height="12"><strong>管理员账号</strong></td>
    <td align="center"><strong>备　注</strong></td>
    <td align="center"><strong>最后登录时间</strong></td>
    <td align="center"><strong>最后登录IP</strong></td>
    <td colspan="2" align="center"><strong>操作</strong></td>
  </tr>
{section name=t loop=$rs_list}
  <tr>
    <td height="5" colspan="6" class="dline"></td>
  </tr>
  <tr>
    <td  valign="top" bgcolor="#DFDFDF" class="dline">{$rs_list[t].username}</td>
    <td align="center" valign="top" bgcolor="#EFEFEF" class="dline">{$rs_list[t].remark}</td>
    <td valign="top" bgcolor="#DFDFDF" class="dline">{$rs_list[t].lastlogin}</td>
    <td valign="top" bgcolor="#EFEFEF" class="dline">{$rs_list[t].ip}</td>
    <td bgcolor="#FFFF66" class="dline" align="center">
      <a href="information.php?editname={$rs_list[t].username}" target="hzh_admin_modify" >修改</a></td>
    <td bgcolor="#FFFF66" class="dline" align="center">
      {if $username!=$rs_list[t].username}
      <a href="?method=delete&username={$rs_list[t].username}">删除</a>
      {/if}
    </td>
  </tr>
 {/section}
</table>
</div>
<br style="clear:both"/>
</body>
</html>
