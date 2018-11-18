<?php /* Smarty version Smarty-3.1.16, created on 2015-09-01 11:24:31
         compiled from ".\templates\devlst.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2316655e4fd827688f8-78534108%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6d7619bb2f820ea0b82f878bc1ee52133c6c3afe' => 
    array (
      0 => '.\\templates\\devlst.tpl',
      1 => 1441106669,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2316655e4fd827688f8-78534108',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_55e4fd82922831_29508035',
  'variables' => 
  array (
    'userid' => 0,
    'saveok' => 0,
    'ary_device_count' => 0,
    'ary_device' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55e4fd82922831_29508035')) {function content_55e4fd82922831_29508035($_smarty_tpl) {?><?php  $_config = new Smarty_Internal_Config("admin.conf", $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars(null, 'local'); ?>
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

.andtext a:link {
	color:#F60;
	TEXT-DECORATION: none;
	font-weight: bold;
}

.andtext a:hover {
	COLOR: #36F;
	text-decoration: underline;
}

-->
</style>

<script src="js/base64.js"></script>
<script language="javascript">

function MM_goToURL() 
{ //v3.0
    var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
    for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
function del(aid)
{
	if(confirm("是否要删除?"))
	MM_goToURL('self','?exc=del&p0='+<?php echo $_smarty_tpl->tpl_vars['userid']->value;?>
+'&p1='+aid);
}
function alter(aid,text)
{
	var base64 = new Base64();  
	text=base64.encode(encodeURIComponent(text));
	MM_goToURL('self','?exc=alter&p0='+<?php echo $_smarty_tpl->tpl_vars['userid']->value;?>
+'&p1='+aid+'&p2='+text);
	base64=NULL;
}
</script>
</head>
<body bgcolor="#F8F8F8">
<div id="navigation">&nbsp;</div>
<?php echo $_smarty_tpl->getSubTemplate ("pub_top.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div id="mid">
<div>
<strong>定位列表管理</strong>
<div>
  <p><a href="index.php">主页</a></p>
</div>
  <hr />
    <div>
    <p>
    <?php if (1==$_smarty_tpl->tpl_vars['saveok']->value) {?>
    <font color="#FF3300"><strong>*修改成功</strong></font>
    <?php } elseif (2==$_smarty_tpl->tpl_vars['saveok']->value) {?>
    <font color="#FF3300"><strong>*删除成功</strong></font>
    <?php }?>
    </p>
      <?php if ($_smarty_tpl->tpl_vars['ary_device_count']->value>0) {?>
      <form name="form1" id="form1" action="" method="post">
      
  <table width="100%" border="1" cellspacing="0" cellpadding="8">
  <tr>
    <td bgcolor="#BBBBBB"><strong>定位ID</strong></td>
    <td align="center" bgcolor="#BBBBBB"><strong>呢称</strong></td>
    <td colspan="2" align="center" bgcolor="#BBBBBB"><strong>操作</strong></td>
    </tr>
<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['devlst'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['devlst']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['devlst']['name'] = 'devlst';
$_smarty_tpl->tpl_vars['smarty']->value['section']['devlst']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['ary_device']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['devlst']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['devlst']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['devlst']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['devlst']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['devlst']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['devlst']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['devlst']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['devlst']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['devlst']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['devlst']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['devlst']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['devlst']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['devlst']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['devlst']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['devlst']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['devlst']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['devlst']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['devlst']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['devlst']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['devlst']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['devlst']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['devlst']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['devlst']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['devlst']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['devlst']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['devlst']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['devlst']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['devlst']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['devlst']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['devlst']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['devlst']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['devlst']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['devlst']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['devlst']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['devlst']['total']);
?>
  <tr>
    <td bgcolor="#EEEEEE"><?php echo $_smarty_tpl->tpl_vars['ary_device']->value[$_smarty_tpl->getVariable('smarty')->value['section']['devlst']['index']]['post_coodr_id'];?>
</td>
    <td bgcolor="#EEEEEE"><input name="t<?php echo $_smarty_tpl->tpl_vars['ary_device']->value[$_smarty_tpl->getVariable('smarty')->value['section']['devlst']['index']]['autoid'];?>
" id="t<?php echo $_smarty_tpl->tpl_vars['ary_device']->value[$_smarty_tpl->getVariable('smarty')->value['section']['devlst']['index']]['autoid'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['ary_device']->value[$_smarty_tpl->getVariable('smarty')->value['section']['devlst']['index']]['remark'];?>
" style="
    width:99%"/> </td>
    <td align="center" bgcolor="#EEEEEE"><a href="javascript:del(<?php echo $_smarty_tpl->tpl_vars['ary_device']->value[$_smarty_tpl->getVariable('smarty')->value['section']['devlst']['index']]['autoid'];?>
)">删除</a></td>
    <td align="center" bgcolor="#EEEEEE"><a href="javascript:alter(<?php echo $_smarty_tpl->tpl_vars['ary_device']->value[$_smarty_tpl->getVariable('smarty')->value['section']['devlst']['index']]['autoid'];?>
,form1.t<?php echo $_smarty_tpl->tpl_vars['ary_device']->value[$_smarty_tpl->getVariable('smarty')->value['section']['devlst']['index']]['autoid'];?>
.value)">修改</a></td>
  </tr>
<?php endfor; endif; ?>
</table>

      </form>  
      <?php } else { ?>
      <div align="center">
        <p>你还没有任何定位设备</p>
        <p><strong><a href="newdev.php">我要添加定位</a></strong></span>
        <?php }?>
        </div>
      </div>
  </div>
<br class="clearfloat" />
</div>
<div id="footer"><?php echo $_smarty_tpl->getConfigVariable('copyright');?>
</div>
</body>
</html><?php }} ?>
