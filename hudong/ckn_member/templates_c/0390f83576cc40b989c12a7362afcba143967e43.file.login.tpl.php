<?php /* Smarty version Smarty-3.1.16, created on 2014-08-29 16:25:52
         compiled from ".\templates\login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:136655400a99025dcb4-09376168%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0390f83576cc40b989c12a7362afcba143967e43' => 
    array (
      0 => '.\\templates\\login.tpl',
      1 => 1393690558,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '136655400a99025dcb4-09376168',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'username' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_5400a990298be6_86520699',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5400a990298be6_86520699')) {function content_5400a990298be6_86520699($_smarty_tpl) {?><?php  $_config = new Smarty_Internal_Config("member.conf", $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars(null, 'local'); ?>
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
	//document.getElementById('verifyimg').src='module/verifycode.m.php?action=verifycode';
}
// -->
</script>
<body>
<form id="form1" name="form1" method="post" action="sign_in.php">
  <table width="522" border="1" align="center" cellspacing="0">
    <tr>
      <td height="81" align="center"><a href="register.php">注册</a></td>
      <td height="81" align="center">登录</td>
    </tr>
    <tr>
      <td height="50" colspan="2" align="center">用户名
        <label>
          <input name="txt_username" type="text" id="txt_username" value="<?php echo $_smarty_tpl->tpl_vars['username']->value;?>
" size="20" maxlength="300" />
      </label></td>
    </tr>
    <tr>
      <td height="50" colspan="2" align="center">密码
      <input name="txt_passwd" type="password" id="txt_passwd" size="15" maxlength="100" /></td>
    </tr>
    <tr>
      <td height="50" colspan="2" align="center">校验码
        <input name="txt_verify" type="text" id="txt_verify" size="8" maxlength="10"  autocomplete="off" />
      <a href="javascript:refreshimg()"><img src="module/verifycode.m.php?action=verifycode" name="verifyimg" border="0" id="verifyimg" /></a></td>
    </tr>
    <tr>
      <td height="50" colspan="2" align="center"><p>
        <input type="submit" name="button" id="button" value="登录" />
        <input name="method" type="hidden" id="method" value="login" />
      </p>
      <p><a href="forgot.php">忘记密码</a></p></td>
    </tr>
  </table> 
</form>
</body>
</html><?php }} ?>
