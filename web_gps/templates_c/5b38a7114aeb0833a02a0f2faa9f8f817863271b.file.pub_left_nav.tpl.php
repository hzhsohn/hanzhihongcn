<?php /* Smarty version Smarty-3.1.16, created on 2015-09-01 04:10:03
         compiled from ".\templates\pub_left_nav.tpl" */ ?>
<?php /*%%SmartyHeaderCode:778055e5251b963b59-54300474%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5b38a7114aeb0833a02a0f2faa9f8f817863271b' => 
    array (
      0 => '.\\templates\\pub_left_nav.tpl',
      1 => 1440854966,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '778055e5251b963b59-54300474',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'userid' => 0,
    'account' => 0,
    'surplus_dev' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_55e5251b9da4a3_20857646',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55e5251b9da4a3_20857646')) {function content_55e5251b9da4a3_20857646($_smarty_tpl) {?><ul>
 <li>ID: <?php echo $_smarty_tpl->tpl_vars['userid']->value;?>
</li>
 <li><?php echo $_smarty_tpl->tpl_vars['account']->value;?>
 -<a href="sign_out.php"> 退出</a></li>
</ul>
<hr />
<ul>
 <li><a href="manage.php">位置信息</a></li>
 <li><a href="newdev.php">新增定位<strong style=" color:#F00">(<?php echo $_smarty_tpl->tpl_vars['surplus_dev']->value;?>
)</strong></a></li>
 <li><a href="password.php">密码更改</a></li>
</ul><?php }} ?>
