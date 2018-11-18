<?php /* Smarty version Smarty-3.1.16, created on 2018-08-01 15:39:34
         compiled from "./templates/newdev.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12613094385b6163b63a8ca5-64393387%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '035392d65eec9c262a59a08c1f06bb932fb5bfb8' => 
    array (
      0 => './templates/newdev.tpl',
      1 => 1441092434,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12613094385b6163b63a8ca5-64393387',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'surplus_dev' => 0,
    'qr_data' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_5b6163b6401152_88739337',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b6163b6401152_88739337')) {function content_5b6163b6401152_88739337($_smarty_tpl) {?><?php  $_config = new Smarty_Internal_Config("admin.conf", $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars(null, 'local'); ?>
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
#mid #nav2 #form1 {
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 14px;
}
#mid #left {
	width: 22%;
	margin-right: auto;
	border-right-style: solid;
	border-right-width: 2px;
	border-right-color: #690;
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 12px;
	height: 400px;
}
#mid #nav2 #form1 p {
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

#msg {
	width: 960px; /* 自动边距（与宽度一起）会将页面居中 */
	margin-top: 0px;
	margin-right: auto;
	margin-left: auto;
	border-top-width: 2px;
	border-top-style: solid;
	border-top-color: #690;
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 12px;
}
#logobar #title #logo img {
	padding-top: 10px;
}

-->
</style>
</head>
<body bgcolor="#F8F8F8">
<div id="navigation">&nbsp;</div>
<?php echo $_smarty_tpl->getSubTemplate ("pub_top.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div id="mid">
  <div id="left" class="fltlft">
  <?php echo $_smarty_tpl->getSubTemplate ("pub_left_nav.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

  </div>
  <div id="nav2" class="fltrt">
    <h3>新增定位</h3>
    <hr/>
    <?php if ($_smarty_tpl->tpl_vars['surplus_dev']->value>0) {?>
    <div align="center"><img src="gen_qr.php?data=<?php echo $_smarty_tpl->tpl_vars['qr_data']->value;?>
" name="newdevadd_qr" width="280" height="280"></div>
    <div align="center"><?php echo $_smarty_tpl->tpl_vars['qr_data']->value;?>
</div>
    <p align="center"><strong>请打开被定位手机的应用扫一下</strong></p>
    <?php } else { ?>
    <div align="center">
      <p>你的定位设备已经达上限</p>
      <p><strong><a href="#">购买位置</a></strong></p>
    </div>
    <?php }?>
  </div>
  <br class="clearfloat" />
</div>
<div id="footer"><?php echo $_smarty_tpl->getConfigVariable('copyright');?>
</div>
</body>
</html><?php }} ?>
