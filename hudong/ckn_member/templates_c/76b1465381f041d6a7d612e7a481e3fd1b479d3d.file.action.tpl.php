<?php /* Smarty version Smarty-3.1.16, created on 2014-10-30 07:24:30
         compiled from ".\templates\action.tpl" */ ?>
<?php /*%%SmartyHeaderCode:128925451e1d5228287-30917991%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '76b1465381f041d6a7d612e7a481e3fd1b479d3d' => 
    array (
      0 => '.\\templates\\action.tpl',
      1 => 1414653857,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '128925451e1d5228287-30917991',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_5451e1d5259d93_04948630',
  'variables' => 
  array (
    'username' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5451e1d5259d93_04948630')) {function content_5451e1d5259d93_04948630($_smarty_tpl) {?><?php  $_config = new Smarty_Internal_Config("member.conf", $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars(null, 'local'); ?>
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
<form id="form1" name="form1" method="post" action="action_ret.php">
  <table width="522" border="1" align="center" cellspacing="0">
    <tr>
      <td height="81" align="center"><strong>激活账号</strong></td>
    </tr>
    <tr>
      <td align="center">账号
        <label>
          <input name="em" type="text" id="em" value="<?php echo $_smarty_tpl->tpl_vars['username']->value;?>
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
        <input name="method" type="hidden" id="method" value="action" />
      </p></td>
    </tr>
  </table> 
</form>
</body>
</html><?php }} ?>
