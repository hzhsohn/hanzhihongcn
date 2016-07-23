<?php /* Smarty version Smarty-3.1.16, created on 2014-08-29 16:23:57
         compiled from ".\templates\forgot.tpl" */ ?>
<?php /*%%SmartyHeaderCode:65635400a16a6665f7-82407765%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '22ea2c75c4e4ca5f8eb4e0818e9eba96d8be4dcc' => 
    array (
      0 => '.\\templates\\forgot.tpl',
      1 => 1409329434,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '65635400a16a6665f7-82407765',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_5400a16a6958f0_52376234',
  'variables' => 
  array (
    'email' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5400a16a6958f0_52376234')) {function content_5400a16a6958f0_52376234($_smarty_tpl) {?><?php  $_config = new Smarty_Internal_Config("member.conf", $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars(null, 'local'); ?>
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
<form id="form1" name="form1" method="post" action="forgot_ret.php">
  <table width="522" border="1" align="center" cellspacing="0">
    <tr>
      <td height="81" align="center"><strong>忘记密码</strong></td>
    </tr>
    <tr>
      <td align="center">邮箱
        <label>
          <input name="email" type="text" id="email" value="<?php echo $_smarty_tpl->tpl_vars['email']->value;?>
" size="20" maxlength="300" />
      </label></td>
    </tr>
    <tr>
      <td height="50" align="center"><div>
         验证码
        <input name="txt_verify" type="text" id="txt_verify" size="8" maxlength="10"  autocomplete="off" />
      <a href="javascript:refreshimg()"><img src="module/verifycode.m.php?action=verifycode" name="verifyimg" border="0" id="verifyimg" /></a></div></td>
    </tr>
    <tr>
      <td height="50" align="center"><p>
        <input type="submit" name="button" id="button" value="发送激活邮件" />
        <input name="method" type="hidden" id="method" value="forgot" />
      </p></td>
    </tr>
  </table> 
</form>
</body>
</html><?php }} ?>
