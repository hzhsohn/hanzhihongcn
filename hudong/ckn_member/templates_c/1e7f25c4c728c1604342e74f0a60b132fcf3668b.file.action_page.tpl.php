<?php /* Smarty version Smarty-3.1.16, created on 2014-10-30 15:17:00
         compiled from ".\templates\action_page.tpl" */ ?>
<?php /*%%SmartyHeaderCode:309275451e0a60a3520-88890260%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1e7f25c4c728c1604342e74f0a60b132fcf3668b' => 
    array (
      0 => '.\\templates\\action_page.tpl',
      1 => 1414653146,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '309275451e0a60a3520-88890260',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_5451e0a624f552_92785273',
  'variables' => 
  array (
    'result' => 0,
    'username' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5451e0a624f552_92785273')) {function content_5451e0a624f552_92785273($_smarty_tpl) {?><?php  $_config = new Smarty_Internal_Config("member.conf", $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars(null, 'local'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_smarty_tpl->getConfigVariable('title');?>
</title>
</head>
<body>
<p>
  <?php if (1==$_smarty_tpl->tpl_vars['result']->value) {?> 
  账号成功激活
  <p><a href="login.php">登录</a></p>
  <?php } elseif (2==$_smarty_tpl->tpl_vars['result']->value) {?>
  code码为空或出错
  <p><a href="action.php?username=<?php echo $_smarty_tpl->tpl_vars['username']->value;?>
">重新激活</a></p>
  <?php } elseif (3==$_smarty_tpl->tpl_vars['result']->value) {?>
  账户已经被激活过了
  <p><a href="login.php">登录</a></p>
  <?php } elseif (4==$_smarty_tpl->tpl_vars['result']->value) {?> 
  激活邮件已经过期
  <p><a href="action.php?username=<?php echo $_smarty_tpl->tpl_vars['username']->value;?>
">重新激活</a></p>
  <?php } elseif (5==$_smarty_tpl->tpl_vars['result']->value) {?>
  操作数据库失败
  <p><a href="action.php?username=<?php echo $_smarty_tpl->tpl_vars['username']->value;?>
">重新激活</a></p>
  <?php } elseif (6==$_smarty_tpl->tpl_vars['result']->value) {?>
  用户还未注册
  <p><a href="register.php">注册用户</a></p>
  <?php } elseif (7==$_smarty_tpl->tpl_vars['result']->value) {?>
  查询数据库失败
  <p><a href="action.php?username=<?php echo $_smarty_tpl->tpl_vars['username']->value;?>
">重新激活</a></p>
  <?php }?>
</p>
</body>
</html><?php }} ?>
