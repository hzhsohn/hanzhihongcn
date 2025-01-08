<?php /* Smarty version Smarty-3.1.16, created on 2024-02-24 14:32:58
         compiled from "./templates/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:140900164065d98d9abbd054-84228490%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c0360d049dff10f364dfc53ba2cc3958abf6ee6d' => 
    array (
      0 => './templates/index.tpl',
      1 => 1588668011,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '140900164065d98d9abbd054-84228490',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'err' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_65d98d9abc1cf3_12767886',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_65d98d9abc1cf3_12767886')) {function content_65d98d9abc1cf3_12767886($_smarty_tpl) {?>{config_load file="admin.conf" section="setup"}
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
            <?php if ($_smarty_tpl->tpl_vars['err']->value==1) {?>
            	登录失败,没有此用户或密码错误!
            <?php } elseif ($_smarty_tpl->tpl_vars['err']->value==2) {?>
            	页面超时,请重新登录!
            <?php }?>
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
<?php }} ?>
