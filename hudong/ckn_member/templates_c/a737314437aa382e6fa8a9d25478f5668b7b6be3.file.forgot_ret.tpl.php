<?php /* Smarty version Smarty-3.1.16, created on 2014-08-30 00:25:49
         compiled from ".\templates\forgot_ret.tpl" */ ?>
<?php /*%%SmartyHeaderCode:168905400a347857e01-07610961%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a737314437aa382e6fa8a9d25478f5668b7b6be3' => 
    array (
      0 => '.\\templates\\forgot_ret.tpl',
      1 => 1409329543,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '168905400a347857e01-07610961',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_5400a3478b79f7_18448662',
  'variables' => 
  array (
    'result' => 0,
    'username' => 0,
    'email' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5400a3478b79f7_18448662')) {function content_5400a3478b79f7_18448662($_smarty_tpl) {?><?php  $_config = new Smarty_Internal_Config("member.conf", $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars(null, 'local'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_smarty_tpl->getConfigVariable('title');?>
</title>
</head>
<body>
<p>
  <?php if (0==$_smarty_tpl->tpl_vars['result']->value) {?> 
  激活邮件已经发送到<?php echo $_smarty_tpl->tpl_vars['username']->value;?>
的邮箱上面请查收
  <p><a href="index.php">回到主页</a></p>
  <?php } elseif (1==$_smarty_tpl->tpl_vars['result']->value) {?> 
  验证码错误
  <p><a href="forgot.php?email=<?php echo $_smarty_tpl->tpl_vars['email']->value;?>
">返回</a></p>
  <?php } elseif (2==$_smarty_tpl->tpl_vars['result']->value) {?>
  邮箱格式不对
  <p><a href="forgot.php?email=<?php echo $_smarty_tpl->tpl_vars['email']->value;?>
">返回</a></p>
  <?php } elseif (3==$_smarty_tpl->tpl_vars['result']->value) {?>
  邮箱发送出错
  <p><a href="forgot.php?email=<?php echo $_smarty_tpl->tpl_vars['email']->value;?>
">返回</a></p>
  <?php } elseif (4==$_smarty_tpl->tpl_vars['result']->value) {?>
  找不到此用户
  <p><a href="forgot.php?email=<?php echo $_smarty_tpl->tpl_vars['email']->value;?>
">返回</a></p>
  <?php } elseif (5==$_smarty_tpl->tpl_vars['result']->value) {?>
  无效操作
  <p><a href="forgot.php?email=<?php echo $_smarty_tpl->tpl_vars['email']->value;?>
">返回</a></p>
  <?php }?>
</p>
</body>
</html><?php }} ?>
