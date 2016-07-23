<?php /* Smarty version Smarty-3.1.16, created on 2014-09-01 11:32:52
         compiled from ".\templates\forgot_page.tpl" */ ?>
<?php /*%%SmartyHeaderCode:241005400b0a988f217-62759057%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '78d295e5e81e35891d2cbca692d560441432f97d' => 
    array (
      0 => '.\\templates\\forgot_page.tpl',
      1 => 1409542367,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '241005400b0a988f217-62759057',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_5400b0a98ffe38_22151036',
  'variables' => 
  array (
    'result' => 0,
    'userid' => 0,
    'randid' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5400b0a98ffe38_22151036')) {function content_5400b0a98ffe38_22151036($_smarty_tpl) {?><?php  $_config = new Smarty_Internal_Config("member.conf", $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars(null, 'local'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_smarty_tpl->getConfigVariable('title');?>
</title>
</head>
<body>
<?php if (1==$_smarty_tpl->tpl_vars['result']->value) {?> 
cd码错误
<p><a href="forgot.php">返回</a></p>
<?php } elseif (2==$_smarty_tpl->tpl_vars['result']->value) {?>
cd码为空
<p><a href="forgot.php">返回</a></p>
<?php } elseif (3==$_smarty_tpl->tpl_vars['result']->value) {?>
忘记密码邮件已经过期
<?php } else { ?>
<form id="form1" name="form1" method="post" action="forgot_page_ret.php">
  <p>输入新密码
  <input type="password" name="pwd1" id="pwd1" />
  </p>
  <p>确认新密码
    <input type="password" name="pwd2" id="pwd2" />
  </p>
  <p>
    <input type="submit" name="button" id="button" value="提交" />
    <input name="method" type="hidden" id="method" value="modify" />
    <input name="uid" type="hidden" id="uid" value="<?php echo $_smarty_tpl->tpl_vars['userid']->value;?>
" />
    <input name="rid" type="hidden" id="rid" value="<?php echo $_smarty_tpl->tpl_vars['randid']->value;?>
" />
  </p>
</form>
<?php }?>
</body>
</html><?php }} ?>
