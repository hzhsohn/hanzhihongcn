<?php /* Smarty version Smarty-3.1.16, created on 2015-06-03 04:32:40
         compiled from ".\templates\sign_in.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5134556e83688f6942-08941832%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e6723065995f555ef906f2700cd7929559486411' => 
    array (
      0 => '.\\templates\\sign_in.tpl',
      1 => 1393690558,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5134556e83688f6942-08941832',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'login_ret_msg' => 0,
    'username' => 0,
    'login_ret' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_556e8368ad43f7_62259454',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_556e8368ad43f7_62259454')) {function content_556e8368ad43f7_62259454($_smarty_tpl) {?><?php  $_config = new Smarty_Internal_Config("member.conf", $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars(null, 'local'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_smarty_tpl->getConfigVariable('title');?>
</title>
</head>
<body>
<div align="center">
<?php if (2==$_smarty_tpl->tpl_vars['login_ret_msg']->value) {?>
2. 登录成功
<?php } elseif (3==$_smarty_tpl->tpl_vars['login_ret_msg']->value) {?>
3. 你的账户还没激活,<a href="action.php?username=<?php echo $_smarty_tpl->tpl_vars['username']->value;?>
">立即激活</a> <?php } elseif (4==$_smarty_tpl->tpl_vars['login_ret_msg']->value) {?>
4. 自动登录失败,请确定密码是否已经修改
<?php } elseif (5==$_smarty_tpl->tpl_vars['login_ret_msg']->value) {?>
5. 登录失败,请检测用户名或密码
<?php } elseif (6==$_smarty_tpl->tpl_vars['login_ret_msg']->value) {?>
6. 验证码错误
<?php } elseif (7==$_smarty_tpl->tpl_vars['login_ret_msg']->value) {?>
7. 已经登录了,正在获取用户信息
<?php }?> </div><br />
<?php if ($_smarty_tpl->tpl_vars['login_ret']->value) {?>
<div align="center"><a href="manage.php">跳转至管理页面&gt;&gt;</a></div>
<?php } else { ?>
<div align="center"><a href="index.php">&lt;&lt;返回登录页面</a></div>
<p><?php }?></p>
</body>
</html><?php }} ?>
