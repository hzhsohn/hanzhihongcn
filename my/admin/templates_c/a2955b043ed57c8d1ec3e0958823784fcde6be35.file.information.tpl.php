<?php /* Smarty version Smarty-3.1.16, created on 2014-06-01 16:32:04
         compiled from ".\templates\information.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3305538b5584370309-37072281%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a2955b043ed57c8d1ec3e0958823784fcde6be35' => 
    array (
      0 => '.\\templates\\information.tpl',
      1 => 1401640195,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3305538b5584370309-37072281',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'result' => 0,
    'editname' => 0,
    'remark' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_538b558442d349_00182389',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_538b558442d349_00182389')) {function content_538b558442d349_00182389($_smarty_tpl) {?><?php  $_config = new Smarty_Internal_Config("admin.conf", $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars(null, 'local'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_smarty_tpl->getConfigVariable('title');?>
</title>
<style type="text/css">
<!--
#navigation {
	width: 960px; /* 自动边距（与宽度一起）会将页面居中 */
	margin-top: 0;
	margin-right: auto;
	margin-bottom: 18;
	margin-left: auto;
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 12px;
}
#mid #left {
	width: 22%;
	margin-right: auto;
	border-right-style: solid;
	border-right-width: 2px;
	border-right-color: #690;
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 12px;
	height: 450px;
}
#mid #nav2 #form1 table {
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 14px;
}
#logobar {
	width: 100%;
	background-color: #060;
	height: 80px;
	margin-bottom: 18px;
}
#logobar #title {
	margin-right: auto;
	margin-left: auto;
	width: 960px;
	vertical-align: middle;
}
#mid #nav2 #form1 p {
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 12px;
	color: #F00;
}
#mid {
	width: 960px; /* 自动边距（与宽度一起）会将页面居中 */
	margin-top: 0px;
	margin-right: auto;
	margin-left: auto;
	margin-bottom: 25px;
}
#mid #right {
	width: 79%;
	margin-left: auto;
	height: 380px;
}

#mid #nav2 {
	width: 76%;
}

#mid nav2 ol {
	color: #111;
	font-weight: normal;
	font-family: Tahoma, Geneva, sans-serif;
}

.fltrt { /* 此类可用来使页面中的元素向右浮动。浮动元素必须位于页面上要与之相邻的元素之前。 */
	float: right;
	margin-left: 8px;
}
.fltlft { /* 此类可用来使页面上的元素向左浮动 */
	float: left;
	margin-right: 8px;
}

.clearfloat { /* 此类应当放在 div 或 break 元素上，而且该元素应当是完全包含浮动的容器关闭之前的最后一个元素 */
	clear:both;
    height:0;
    font-size: 1px;
    line-height: 0px;
}

#footer {
	width: 100%; /* 自动边距（与宽度一起）会将页面居中 */
	margin-top: 28px;
	margin-right: auto;
	margin-bottom: 28px;
	margin-left: auto;
	border-top-width: 2px;
	border-top-style: solid;
	border-top-color: #090;
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 12px;
	color: #666;
	height: 50px;
	padding-top: 10px;
	text-align: center;
}
#logobar #title #logo {
	width: 22%;
}
#logobar #title #nav {
	width: 76%;
	text-align: center;
}

#mid a:link {
 color: #000000;
 TEXT-DECORATION: none
}
#mid a:visited {
 COLOR: #000000;
 TEXT-DECORATION: none
}
#mid a:hover {
 COLOR: #ff7f24;
 text-decoration: underline;
}
#mid a:active {
 COLOR: #ff7f24;  
 text-decoration: underline;
}

#mid #left ul li {
	padding-bottom: 6px;
}
#logobar #title #logo img {
	padding-top: 10px;
}

-->
</style>
</head>
<body bgcolor="#F8F8F8">
<div id="mid">

    <form id="form1" name="form1" method="post" action="">
    <h3>修改资料</h3>
    <p><?php if ($_smarty_tpl->tpl_vars['result']->value==1) {?>
    *更新成功
    <?php } elseif ($_smarty_tpl->tpl_vars['result']->value==2) {?>
    *修改失败
    <?php } elseif ($_smarty_tpl->tpl_vars['result']->value==3) {?>
    *你妹的,备注太长了!!<?php }?> </p>
    <table width="100%" border="0" cellpadding="10" cellspacing="0">
      <tr>
        <td width="13%">账号:</td>
        <td width="87%"><?php echo $_smarty_tpl->tpl_vars['editname']->value;?>
</td>
      </tr>
      <tr>
        <td>备注:</td>
        <td><textarea name="mark" id="mark" cols="45" rows="6"><?php echo $_smarty_tpl->tpl_vars['remark']->value;?>
</textarea></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><input type="submit" name="button" id="button" value="提交" /></td>
        <td><input name="method" type="hidden" id="method" value="update" /></td>
      </tr>
    </table>
  </form>
</div>
<div id="footer"><?php echo $_smarty_tpl->getConfigVariable('copyright');?>
</div>
</body>
</html><?php }} ?>
