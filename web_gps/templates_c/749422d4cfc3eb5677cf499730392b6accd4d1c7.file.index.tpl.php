<?php /* Smarty version Smarty-3.1.16, created on 2015-09-01 13:04:09
         compiled from ".\templates\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2669655e5622cd0fdc0-51927592%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '749422d4cfc3eb5677cf499730392b6accd4d1c7' => 
    array (
      0 => '.\\templates\\index.tpl',
      1 => 1441111585,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2669655e5622cd0fdc0-51927592',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_55e5622ce440e6_89594378',
  'variables' => 
  array (
    'account' => 0,
    'showAutoLogin' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55e5622ce440e6_89594378')) {function content_55e5622ce440e6_89594378($_smarty_tpl) {?><?php  $_config = new Smarty_Internal_Config("admin.conf", $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars(null, 'local'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_smarty_tpl->getConfigVariable('title');?>
</title>
</head>
<script type="text/javascript">
<!--
function refreshimg() {
	document.getElementById('verifyimg').src='module/verifycode.m.php?action=verifycode';
}
// -->
</script>
<body>
<form id="form1" name="form1" method="post" action="sign_in.php">
  <table width="522" border="1" align="center" cellpadding="10" cellspacing="0">
    <tr>
      <td height="81" colspan="3" align="center"><h1><strong>定位管理系统</strong></h1></td>
    </tr>
    <tr>
      <td align="right">账号</td>
      <td colspan="2"><label>
        <input name="account" type="text" id="account" value="<?php echo $_smarty_tpl->tpl_vars['account']->value;?>
" size="20" />
      </label></td>
    </tr>
    <tr>
      <td align="right">密码</td>
      <td colspan="2"><input name="passwd" type="password" id="passwd" size="15" /></td>
    </tr>
    <tr>
      <td align="right">校验码</td>
      <td colspan="2"><input name="txt_verify" type="text" id="txt_verify" size="15"  autocomplete="off" />
      <a href="javascript:refreshimg()"><img src="module/verifycode.m.php?action=verifycode" name="verifyimg" border="0" id="verifyimg"/></a></td>
    </tr>
    <tr>
      <td height="50" colspan="3" align="center"><label>
        <input name="ckb_autologin" type="checkbox" id="ckb_autologin" value="1" />
        允许一键登录
      </label>
      </td>
    </tr>
    <tr>
      <td height="50" align="center">&nbsp;</td>
      <td height="50" align="center"><input type="submit" name="button" id="button" value="登录" />
      <input name="method" type="hidden" id="method" value="login" /></td>
      <td align="center"><a href="reg.php">快速注册</a></td>
    </tr>
  </table>
</form>
<hr/>

<?php if ($_smarty_tpl->tpl_vars['showAutoLogin']->value) {?>
<form id="form1" name="form2" method="post" action="sign_in.php?method=autologin">
<div align="center"><input type="submit" value="<?php echo $_smarty_tpl->tpl_vars['account']->value;?>
 一键登录"  style="width:300px; height:100px"/></div>
</form>
<?php }?>
</body>
</html><?php }} ?>
