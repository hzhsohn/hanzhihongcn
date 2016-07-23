<?php /* Smarty version Smarty-3.1.16, created on 2014-06-01 16:29:58
         compiled from ".\templates\adminlist.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4281538b45cd5588e9-68092637%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0f5f59ef36fe97c6459406de6d94cf378c4c4160' => 
    array (
      0 => '.\\templates\\adminlist.tpl',
      1 => 1401640195,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4281538b45cd5588e9-68092637',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_538b45cd63dd20_83035625',
  'variables' => 
  array (
    'rs_list' => 0,
    'username' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_538b45cd63dd20_83035625')) {function content_538b45cd63dd20_83035625($_smarty_tpl) {?><?php  $_config = new Smarty_Internal_Config("admin.conf", $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars("setup", 'local'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_smarty_tpl->getConfigVariable('title');?>
</title>
<style type="text/css">
<!--
.STYLE1 {
	color: #FF0000;
	text-decoration: none;
}
body,td,th {
	font-size: 12px;
}
.dline {
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-bottom-style: solid;
	border-top-color: #999999;
	border-right-color: #999999;
	border-bottom-color: #999999;
	border-left-color: #999999;
}
a:link {
	text-decoration: none;
	color: #0033FF;
}
a:visited {
	text-decoration: none;
	color: #0000FF;
}
a:hover {
	text-decoration: none;
	color: #FF0000;
}
a:active {
	text-decoration: none;
	color: #33CC00;
}
.STYLE2 {
	color: #FF0000
}
-->
</style>

</head>
<body>
<span class="STYLE1">管理员列表</span>
<hr />

<div style="width:15%; float:left"><?php echo $_smarty_tpl->getSubTemplate ("leftbar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title'=>'leftbar'), 0);?>
</div>
<div style="width:84%; float:right"><table width="100%" border="0" align="center" cellpadding="4" cellspacing="0">
  <tr>
    <td  height="12"><strong>管理员账号</strong></td>
    <td align="center"><strong>备　注</strong></td>
    <td align="center"><strong>最后登录时间</strong></td>
    <td align="center"><strong>最后登录IP</strong></td>
    <td colspan="2" align="center"><strong>操作</strong></td>
  </tr>
<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['t'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['t']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['name'] = 't';
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['rs_list']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['total']);
?>
  <tr>
    <td height="5" colspan="6" class="dline"></td>
  </tr>
  <tr>
    <td  valign="top" bgcolor="#DFDFDF" class="dline"><?php echo $_smarty_tpl->tpl_vars['rs_list']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['username'];?>
</td>
    <td align="center" valign="top" bgcolor="#EFEFEF" class="dline"><?php echo $_smarty_tpl->tpl_vars['rs_list']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['remark'];?>
</td>
    <td valign="top" bgcolor="#DFDFDF" class="dline"><?php echo $_smarty_tpl->tpl_vars['rs_list']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['lastlogin'];?>
</td>
    <td valign="top" bgcolor="#EFEFEF" class="dline"><?php echo $_smarty_tpl->tpl_vars['rs_list']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['ip'];?>
</td>
    <td bgcolor="#FFFF66" class="dline" align="center">
      <a href="information.php?editname=<?php echo $_smarty_tpl->tpl_vars['rs_list']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['username'];?>
" target="hzh_admin_modify" >修改</a></td>
    <td bgcolor="#FFFF66" class="dline" align="center">
      <?php if ($_smarty_tpl->tpl_vars['username']->value!=$_smarty_tpl->tpl_vars['rs_list']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['username']) {?>
      <a href="?method=delete&username=<?php echo $_smarty_tpl->tpl_vars['rs_list']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['username'];?>
">删除</a>
      <?php }?>
    </td>
  </tr>
 <?php endfor; endif; ?>
</table>
</div>
<br style="clear:both"/>
</body>
</html>
<?php }} ?>
