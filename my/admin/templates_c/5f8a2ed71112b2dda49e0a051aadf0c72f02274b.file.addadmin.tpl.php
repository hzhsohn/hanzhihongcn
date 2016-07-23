<?php /* Smarty version Smarty-3.1.16, created on 2014-06-01 16:31:43
         compiled from ".\templates\addadmin.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10021538b4562427b52-51704430%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5f8a2ed71112b2dda49e0a051aadf0c72f02274b' => 
    array (
      0 => '.\\templates\\addadmin.tpl',
      1 => 1401640194,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10021538b4562427b52-51704430',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_538b45624a84d3_79102946',
  'variables' => 
  array (
    'result' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_538b45624a84d3_79102946')) {function content_538b45624a84d3_79102946($_smarty_tpl) {?><?php  $_config = new Smarty_Internal_Config("admin.conf", $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars("setup", 'local'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<title>添加管理员</title>
<body>
<div style="width:15%; float:left"><?php echo $_smarty_tpl->getSubTemplate ("leftbar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title'=>'leftbar'), 0);?>
</div>
<div style="width:84%; float:right">
<form id="form1" name="form1" method="post" action="">
      <table width="74%" height="18" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#D7D7D7">
        <tr>
          <td colspan="2" align="center"><?php if ($_smarty_tpl->tpl_vars['result']->value==1) {?>
          管理员添加成功
          <?php } elseif ($_smarty_tpl->tpl_vars['result']->value==2) {?>
          管理编号有重复,添加失败!!
          <?php }?></td>
        </tr>
        <tr>
          <td width="32%" align="right">用户名:</td>
          <td width="68%"><label>
            <input name="USERNAME" type="text" id="USERNAME" size="32" maxlength="16" />
          </label></td>
        </tr>
        <tr>
          <td align="right">密　码:</td>
          <td><input name="PASSWORD" type="text" id="PASSWORD" size="32" maxlength="16" /></td>
        </tr>
        <tr>
          <td align="right" valign="top">备　注:</td>
          <td><textarea name="REMARK" cols="30" rows="10" id="REMARK"></textarea></td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td align="right">&nbsp;</td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td align="left"><label>
            <input type="submit" name="Submit" value="确定添加管理员" onclick="confirm_post()" />
    
            <input name="method" type="hidden" id="method" value="insert" />
          </label></td>
        </tr>
      </table>
    </form>
</div>
</body>
<?php }} ?>
