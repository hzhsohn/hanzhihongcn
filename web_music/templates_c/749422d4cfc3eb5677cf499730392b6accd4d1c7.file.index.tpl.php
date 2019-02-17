<?php /* Smarty version Smarty-3.1.16, created on 2018-12-27 16:40:51
         compiled from ".\templates\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:163535c20ad38d4bc07-09259538%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '749422d4cfc3eb5677cf499730392b6accd4d1c7' => 
    array (
      0 => '.\\templates\\index.tpl',
      1 => 1545900042,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '163535c20ad38d4bc07-09259538',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_5c20ad38d7a9e4_24686036',
  'variables' => 
  array (
    'ret' => 0,
    'j' => 0,
    'l' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5c20ad38d7a9e4_24686036')) {function content_5c20ad38d7a9e4_24686036($_smarty_tpl) {?><!doctype html>
<html class="no-js">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <title>韩讯联控产品跟进系统</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width">

    <link href="main.css" rel="stylesheet">
    <link href="../main.css" rel="stylesheet">
</head>
<body class="language-sc">

<div class="dynamic-nav-bar">
    <ul>
        <li><a href="./" class='active'><font size="+1"><strong>韩讯联控产品跟进系统</strong></font></a></li>
    </ul>
</div>

<div class="dynamic_content_wrapper">
    <div class="dynamic_content">
        <div id="function">
            <div id="function">
<?php if (1==$_smarty_tpl->tpl_vars['ret']->value) {?>
<div class="route-result" style="">
<div class="bill-title">缺少参数</div>
</div>
<?php } elseif (2==$_smarty_tpl->tpl_vars['ret']->value) {?>
<div class="route-result" style="">
<div class="bill-title">找不到记录</div>
</div>
<?php } else { ?>
                <div class="shipping-detail-page">
                    <div class="delivery-view">
                        <!-- 产品信息 -->
                        <div class="route-result" style="">
                            <div class="bill-title">产品信息</div>
                            <div class="delivery-wrapper">
                              <table width="100%" >
                                <tr>
                                  <th>生产地</th>
                                  <th>批次</th>
                                  <th>品种</th>
                                  <th>出厂日期</th>
                                </tr>                               
                                <tr>
                                  <td><?php echo $_smarty_tpl->tpl_vars['j']->value['place'];?>
</td>
                                  <td><?php echo $_smarty_tpl->tpl_vars['j']->value['batch'];?>
</td>
                                  <td><?php echo $_smarty_tpl->tpl_vars['j']->value['type'];?>
</td>
                                  <td><?php echo $_smarty_tpl->tpl_vars['j']->value['time'];?>
</td>
                                </tr>
                              </table>
                            
                            </div>
                        </div>
                        <div class="route-result" style="">
                            <div class="bill-title">跟进信息</div>
                                <div class="delivery-wrapper">
                                <div class="delivery">
                                    <div class="delivery-item send-out-item">
                                        <div class="routes-wrapper">
                                            <div class="route-list">
                                              <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['o'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['o']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['o']['name'] = 'o';
$_smarty_tpl->tpl_vars['smarty']->value['section']['o']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['l']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['o']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['o']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['o']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['o']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['o']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['o']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['o']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['o']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['o']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['o']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['o']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['o']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['o']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['o']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['o']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['o']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['o']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['o']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['o']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['o']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['o']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['o']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['o']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['o']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['o']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['o']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['o']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['o']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['o']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['o']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['o']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['o']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['o']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['o']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['o']['total']);
?>
                                                <ul class="route first ">
                                                  <li class="route-status-text"><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['o']['rownum'];?>
</li>
                                                  <li class="route-status-icon"><img src="status-signed.png"></li>
                                                  <li class="route-date-time"><span><?php echo $_smarty_tpl->tpl_vars['l']->value[$_smarty_tpl->getVariable('smarty')->value['section']['o']['index']]['time'];?>
</span></li>
                                                  <li class="route-desc"><span><?php echo $_smarty_tpl->tpl_vars['l']->value[$_smarty_tpl->getVariable('smarty')->value['section']['o']['index']]['mark'];?>
</span> - 操作员:<span><?php echo $_smarty_tpl->tpl_vars['l']->value[$_smarty_tpl->getVariable('smarty')->value['section']['o']['index']]['operater'];?>
</li>
                                                </ul>
                                                <?php endfor; endif; ?>
                                            </div>
                                        </div>
                                        <div class="separation-line"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<?php }?>
            </div>
        </div>

    </div>
</div>


</body>
</html><?php }} ?>
