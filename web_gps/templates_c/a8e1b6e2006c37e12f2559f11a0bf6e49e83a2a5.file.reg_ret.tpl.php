<?php /* Smarty version Smarty-3.1.16, created on 2018-08-01 15:31:45
         compiled from "./templates/reg_ret.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3890774285b6161e10f5bd2-11809702%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a8e1b6e2006c37e12f2559f11a0bf6e49e83a2a5' => 
    array (
      0 => './templates/reg_ret.tpl',
      1 => 1441118042,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3890774285b6161e10f5bd2-11809702',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'result' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_5b6161e1132b76_48807873',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b6161e1132b76_48807873')) {function content_5b6161e1132b76_48807873($_smarty_tpl) {?><?php  $_config = new Smarty_Internal_Config("admin.conf", $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars(null, 'local'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_smarty_tpl->getConfigVariable('title');?>
</title>
<style type="text/css">
<!--
-->
</style></head>
<style>
.inptx{
	width:99%;
}
</style>
<body>
<div align="center">
  <p>
  <?php if (1==$_smarty_tpl->tpl_vars['result']->value) {?>
  <font color="#FF3300"><strong>*注册成功</strong></font>
  <p><a href="index.php">返回登录</a></p>
    <?php } elseif (2==$_smarty_tpl->tpl_vars['result']->value) {?>
    <font color="#FF3300"><strong>*已经存在重复用户</strong></font>
    <p><a href="reg.php">返回注册</a></p>
    <?php } else { ?>
    <font color="#FF3300"><strong>数据库连接失败</strong></font>
    <p><a href="reg.php">返回注册</a></p>
    <?php }?>
  </p>
  
</div>
</body>
</html><?php }} ?>
