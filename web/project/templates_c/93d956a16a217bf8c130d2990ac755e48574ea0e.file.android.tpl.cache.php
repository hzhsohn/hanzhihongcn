<?php /* Smarty version Smarty-3.1.16, created on 2017-09-23 01:15:17
         compiled from "./templates/android.tpl" */ ?>
<?php /*%%SmartyHeaderCode:188131469259c52c0932e723-37603367%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '93d956a16a217bf8c130d2990ac755e48574ea0e' => 
    array (
      0 => './templates/android.tpl',
      1 => 1506100491,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '188131469259c52c0932e723-37603367',
  'function' => 
  array (
  ),
  'cache_lifetime' => 120,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_59c52c0936d455_42331263',
  'variables' => 
  array (
    'APP' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59c52c0936d455_42331263')) {function content_59c52c0936d455_42331263($_smarty_tpl) {?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Android App</title>
<link href="./android.css" rel="stylesheet" type="text/css" />
<link href="../android.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="divContent" >
  <h3><img src="android/android_logo.png" /></h3>
  <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['outer'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['outer']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['name'] = 'outer';
$_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['APP']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['total']);
?>
  <div class="raised"> <b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
    <h4><img src="android/android_root.png"/><?php echo $_smarty_tpl->tpl_vars['APP']->value[$_smarty_tpl->getVariable('smarty')->value['section']['outer']['index']]['appname'];?>
</h4>
    <div class="boxcontent">
      <table border="0" cellpadding="0" cellspacing="0" >
        <tr>
          <td width="64" valign="top"><img src="<?php echo $_smarty_tpl->tpl_vars['APP']->value[$_smarty_tpl->getVariable('smarty')->value['section']['outer']['index']]['icon'];?>
" /></td>
          <td valign="top" ><p><strong>内容提要</strong></p><p><?php echo $_smarty_tpl->tpl_vars['APP']->value[$_smarty_tpl->getVariable('smarty')->value['section']['outer']['index']]['content'];?>
 <br /></p>
            <?php if ($_smarty_tpl->tpl_vars['APP']->value[$_smarty_tpl->getVariable('smarty')->value['section']['outer']['index']]['video']) {?><p><strong>视频观看</strong></p><p><a href="<?php echo $_smarty_tpl->tpl_vars['APP']->value[$_smarty_tpl->getVariable('smarty')->value['section']['outer']['index']]['video'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['APP']->value[$_smarty_tpl->getVariable('smarty')->value['section']['outer']['index']]['video'];?>
</a></p><?php }?>
            <p><strong>下载地址</strong></p><?php if ($_smarty_tpl->tpl_vars['APP']->value[$_smarty_tpl->getVariable('smarty')->value['section']['outer']['index']]['apk']) {?><p><a href="<?php echo $_smarty_tpl->tpl_vars['APP']->value[$_smarty_tpl->getVariable('smarty')->value['section']['outer']['index']]['apk'];?>
" target="_blank">----APK-----</a></p><?php } else { ?><p>已下架</p><?php }?>
            </td>
        </tr>
      </table>
    </div>
    <b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b> </div>
  <?php endfor; endif; ?>
  <div id="divFooter">Copyright@2012</div>
</div>
</body>
</html>
<?php }} ?>
