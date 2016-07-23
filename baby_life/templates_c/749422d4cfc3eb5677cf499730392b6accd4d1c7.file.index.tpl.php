<?php /* Smarty version Smarty-3.1.16, created on 2016-02-09 12:08:36
         compiled from ".\templates\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3121456b9d50d5cefb7-05367035%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '749422d4cfc3eb5677cf499730392b6accd4d1c7' => 
    array (
      0 => '.\\templates\\index.tpl',
      1 => 1455019712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3121456b9d50d5cefb7-05367035',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_56b9d50d6516a5_95187420',
  'variables' => 
  array (
    'counts' => 0,
    'msgs_ary' => 0,
    'page' => 0,
    'pages' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56b9d50d6516a5_95187420')) {function content_56b9d50d6516a5_95187420($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_smarty_tpl->getConfigVariable('title');?>
</title>
<style type="text/css">
<!--
#msg #page li {
	padding-top: 5px;
	padding-bottom: 10px;
	width: 10%;
	float: left;
}

.js_move{
 background-color:#FFF;
}

.js_move:hover{
 background-color:#FF6;
}
-->
</style>
</head>
<body>
<hr/>
<div id="msg">
  <div>共<?php echo $_smarty_tpl->tpl_vars['counts']->value;?>
条记录</div>
  <div id="chat">
    <ul>
    	<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['msg'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['msg']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['msg']['name'] = 'msg';
$_smarty_tpl->tpl_vars['smarty']->value['section']['msg']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['msgs_ary']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['msg']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['msg']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['msg']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['msg']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['msg']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['msg']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['msg']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['msg']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['msg']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['msg']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['msg']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['msg']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['msg']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['msg']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['msg']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['msg']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['msg']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['msg']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['msg']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['msg']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['msg']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['msg']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['msg']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['msg']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['msg']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['msg']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['msg']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['msg']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['msg']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['msg']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['msg']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['msg']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['msg']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['msg']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['msg']['total']);
?>
      <li class="js_move"><?php echo $_smarty_tpl->tpl_vars['msgs_ary']->value[$_smarty_tpl->getVariable('smarty')->value['section']['msg']['index']]['content'];?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[<?php echo $_smarty_tpl->tpl_vars['msgs_ary']->value[$_smarty_tpl->getVariable('smarty')->value['section']['msg']['index']]['uptime'];?>
]&nbsp;&nbsp;&nbsp;&nbsp;<a href="?method=delete&autoid=<?php echo $_smarty_tpl->tpl_vars['msgs_ary']->value[$_smarty_tpl->getVariable('smarty')->value['section']['msg']['index']]['autoid'];?>
&page=<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
">[删除]</a></li>
        <?php endfor; endif; ?>
    </ul>
    </div>
    <div id="page">
    	<ul>
    	<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['page'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['page']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['page']['name'] = 'page';
$_smarty_tpl->tpl_vars['smarty']->value['section']['page']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['pages']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['page']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['page']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['page']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['page']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['page']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['page']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['page']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['page']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['page']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['page']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['page']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['page']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['page']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['page']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['page']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['page']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['page']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['page']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['page']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['page']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['page']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['page']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['page']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['page']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['page']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['page']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['page']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['page']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['page']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['page']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['page']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['page']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['page']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['page']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['page']['total']);
?>
      <li><a href="?page=<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['page']['index'];?>
">第<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['page']['index']+1;?>
页</a></li>
        <?php endfor; endif; ?>
        </ul>
    </div>
  <table width="100%" border="0" cellpadding="2" cellspacing="0">
  <tr>
    <td><form action="?" method="post" name="form1" onsubmit="if(form1.c.value==''){ alert('不要为空!');return false; }">
      <label>站内小短信:
        <input name="c" type="text" id="c" maxlength="1000" autocomplete="off"/>
        </label>
      <input type="submit" name="btn_submit" id="btn_submit" value="确定" />
      <input name="method" type="hidden" id="method" value="add" />
      <input name="reback" type="hidden" id="reback" value="?" />
      </form>   
    </td>
    </tr>
</table>
</div>
</body>
</html><?php }} ?>
