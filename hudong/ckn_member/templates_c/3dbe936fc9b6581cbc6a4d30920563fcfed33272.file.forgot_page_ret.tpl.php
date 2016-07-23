<?php /* Smarty version Smarty-3.1.16, created on 2014-10-22 17:21:19
         compiled from ".\templates\forgot_page_ret.tpl" */ ?>
<?php /*%%SmartyHeaderCode:98975403e96796ef68-61251101%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3dbe936fc9b6581cbc6a4d30920563fcfed33272' => 
    array (
      0 => '.\\templates\\forgot_page_ret.tpl',
      1 => 1413969664,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '98975403e96796ef68-61251101',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_5403e9679f5d57_68116024',
  'variables' => 
  array (
    'result' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5403e9679f5d57_68116024')) {function content_5403e9679f5d57_68116024($_smarty_tpl) {?><?php  $_config = new Smarty_Internal_Config("member.conf", $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars(null, 'local'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_smarty_tpl->getConfigVariable('title');?>
</title>
</head>
<body>
<?php if (1==$_smarty_tpl->tpl_vars['result']->value) {?> <br />
密码已经修改成功<br />
<p><a href="index.php">回到主页</a></p>
<?php } elseif (2==$_smarty_tpl->tpl_vars['result']->value) {?> <br />
没有操作参数<br />
<p><a href="forgot.php">返回</a></p>
<?php } elseif (3==$_smarty_tpl->tpl_vars['result']->value) {?><br />
无效cd码<br />
<p><a href="forgot.php">返回</a></p>
<?php } elseif (4==$_smarty_tpl->tpl_vars['result']->value) {?><br />
无效账户<br />
<p><a href="forgot.php">返回</a></p>
<?php } elseif (5==$_smarty_tpl->tpl_vars['result']->value) {?><br />
数据库操作失败<br />
<p><a href="forgot.php">返回</a></p>
<?php } elseif (6==$_smarty_tpl->tpl_vars['result']->value) {?><br /> 
两次密码不一样
<br />
<p><a href="forgot.php">返回</a></p>
<?php }?>

</body>
</html><?php }} ?>
