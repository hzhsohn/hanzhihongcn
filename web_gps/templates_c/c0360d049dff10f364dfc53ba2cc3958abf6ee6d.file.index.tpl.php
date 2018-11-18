<?php /* Smarty version Smarty-3.1.16, created on 2018-08-01 15:31:21
         compiled from "./templates/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8161437565b615eb9a32b05-04960148%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c0360d049dff10f364dfc53ba2cc3958abf6ee6d' => 
    array (
      0 => './templates/index.tpl',
      1 => 1533108140,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8161437565b615eb9a32b05-04960148',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_5b615eb9a80c98_27093621',
  'variables' => 
  array (
    'account' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b615eb9a80c98_27093621')) {function content_5b615eb9a80c98_27093621($_smarty_tpl) {?><?php  $_config = new Smarty_Internal_Config("admin.conf", $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars(null, 'local'); ?>
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
      <td height="50" colspan="3" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td height="50" align="center">&nbsp;</td>
      <td height="50" align="center"><input type="submit" name="button" id="button" value="登录" />
      <input name="method" type="hidden" id="method" value="login" /></td>
      <td align="center"><a href="reg.php">快速注册</a></td>
    </tr>
  </table>
</form>
</body>
</html><?php }} ?>
