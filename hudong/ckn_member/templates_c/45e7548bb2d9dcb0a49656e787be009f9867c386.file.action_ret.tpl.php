<?php /* Smarty version Smarty-3.1.16, created on 2014-10-30 14:59:57
         compiled from ".\templates\action_ret.tpl" */ ?>
<?php /*%%SmartyHeaderCode:265325451e1ed7bd290-96475048%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '45e7548bb2d9dcb0a49656e787be009f9867c386' => 
    array (
      0 => '.\\templates\\action_ret.tpl',
      1 => 1414652114,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '265325451e1ed7bd290-96475048',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'result' => 0,
    'username' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_5451e1ed84f0c4_55243216',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5451e1ed84f0c4_55243216')) {function content_5451e1ed84f0c4_55243216($_smarty_tpl) {?><?php  $_config = new Smarty_Internal_Config("member.conf", $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars(null, 'local'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_smarty_tpl->getConfigVariable('title');?>
</title>
</head>
<body>
<p><?php if (1==$_smarty_tpl->tpl_vars['result']->value) {?> 
  验证码错误
  <p><a href="javascript:history.back()">返回</a></p>
  <?php } elseif (2==$_smarty_tpl->tpl_vars['result']->value) {?>
  邮箱格式不对
  <p><a href="javascript:history.back()">返回</a></p>
  <?php } elseif (3==$_smarty_tpl->tpl_vars['result']->value) {?>
  邮箱发送出错
  <p><a href="javascript:history.back()">返回</a></p>
  <?php } elseif (4==$_smarty_tpl->tpl_vars['result']->value) {?>
  找不到此用户
  <p><a href="javascript:history.back()">返回</a></p>
  <?php } elseif (5==$_smarty_tpl->tpl_vars['result']->value) {?>
  无效操作
  <p><a href="javascript:history.back()">返回</a></p>
  <?php } else { ?>
  激活邮件已经发送到<?php echo $_smarty_tpl->tpl_vars['username']->value;?>
的邮箱上面请查收
  <p><a href="login.php">登录</a></p>
  <?php }?> </p>

</body>
</html><?php }} ?>
