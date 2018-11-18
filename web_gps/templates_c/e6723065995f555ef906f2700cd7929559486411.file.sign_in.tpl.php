<?php /* Smarty version Smarty-3.1.16, created on 2015-09-01 08:31:07
         compiled from ".\templates\sign_in.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2439155e5624ba816b3-60572018%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e6723065995f555ef906f2700cd7929559486411' => 
    array (
      0 => '.\\templates\\sign_in.tpl',
      1 => 1413737545,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2439155e5624ba816b3-60572018',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'result' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_55e5624bc1f393_34088872',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55e5624bc1f393_34088872')) {function content_55e5624bc1f393_34088872($_smarty_tpl) {?><?php  $_config = new Smarty_Internal_Config("admin.conf", $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars(null, 'local'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_smarty_tpl->getConfigVariable('title');?>
</title>
</head>
<body>
<div align="center">
<?php if (1==$_smarty_tpl->tpl_vars['result']->value) {?>
1. 登录成功
<div align="center"><a href="manage.php">跳转至管理页面&gt;&gt;</a></div>
<?php } elseif (2==$_smarty_tpl->tpl_vars['result']->value) {?>
2. 你的用户角色没有管理员权限
<div align="center"><a href="index.php">&lt;&lt;返回登录页面</a></div>
<?php } elseif (3==$_smarty_tpl->tpl_vars['result']->value) {?>
3. 账号已经被禁用
<div align="center"><a href="index.php">&lt;&lt;返回登录页面</a></div>
<?php } elseif (4==$_smarty_tpl->tpl_vars['result']->value) {?>
4. 账号未注册
<div align="center"><a href="index.php">&lt;&lt;返回登录页面</a></div>
<?php } elseif (5==$_smarty_tpl->tpl_vars['result']->value) {?>
5. 登录失败,请检测用户名或密码
<div align="center"><a href="index.php">&lt;&lt;返回登录页面</a></div>
<?php } elseif (6==$_smarty_tpl->tpl_vars['result']->value) {?>
6. 验证码错误
<div align="center"><a href="index.php">&lt;&lt;返回登录页面</a></div>
<?php } elseif (7==$_smarty_tpl->tpl_vars['result']->value) {?>
7. 已经登录了,正在获取管理员信息
<div align="center"><a href="index.php">&lt;&lt;返回登录页面</a></div>
<?php } elseif (8==$_smarty_tpl->tpl_vars['result']->value) {?>
8. 一键登录失败,请确认密码是否已经修改
<div align="center"><a href="index.php">&lt;&lt;返回登录页面</a></div>
<?php } else { ?>
数据库信息错误
<div align="center"><a href="index.php">&lt;&lt;返回登录页面</a></div>
<?php }?>
</div>
</body>
</html><?php }} ?>
