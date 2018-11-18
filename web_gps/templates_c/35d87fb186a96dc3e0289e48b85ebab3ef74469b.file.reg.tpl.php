<?php /* Smarty version Smarty-3.1.16, created on 2018-08-01 15:31:38
         compiled from "./templates/reg.tpl" */ ?>
<?php /*%%SmartyHeaderCode:363011625b6161da5cd966-94999339%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '35d87fb186a96dc3e0289e48b85ebab3ef74469b' => 
    array (
      0 => './templates/reg.tpl',
      1 => 1441120235,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '363011625b6161da5cd966-94999339',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_5b6161da60fec8_14176441',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b6161da60fec8_14176441')) {function content_5b6161da60fec8_14176441($_smarty_tpl) {?><?php  $_config = new Smarty_Internal_Config("admin.conf", $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars(null, 'local'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_smarty_tpl->getConfigVariable('title');?>
</title>

<style type="text/css">
<!--
a:link {
	color: #66F;
	text-decoration: none;
}
a:hover {
	color: #F90;
}
-->
</style></head>
<style>
.inptx{
	width:99%;
}
</style>
<script type="text/javascript" src="js/jquery-1.3.1.min.js"></script>
<script type="text/javascript">
	function checkUsername(){
		var username=$("#username").val();
		$.ajax({
             type: "POST",
             url: "checkuser.php",
             data: { account:username},
             dataType: "text",
             success: function(data){
					if(data==1){
						$("#checkuser").html("<font color=green><strong>可以注册</strong></font>");
					}else{
						$("#checkuser").html("<font color=red><strong>用户名重复</strong></font>");
					}
             }

         });


	}

	function submitForm(){
		var username=$("#username").val();
		var pwd1=$("#pwd1").val();
		var pwd2=$("#pwd2").val();
		var question=$("#question").val();
		var answer=$("#answer").val();
		
		if(username=="" || username==null ){
			$("#checkuser").html("<font color=red><strong>用户名不能为空</strong></font>");
			return false;
		}
		
		if(pwd1=="" || pwd1==null ){
			$("#pwd1msg").html("<font color=red><strong>密码不能为空</strong></font>");
			return false;
		}
		
		if(pwd2=="" || pwd2==null ){
			$("#pwd2msg").html("<font color=red><strong>确认密码不能为空</strong></font>");
			return false;
		}
		
		if(pwd1 != pwd2 ){
			$("#pwd2msg").html("<font color=red><strong>两次密码不一致</strong></font>");
			return false;
		}
		
		if(question=="" || question==null ){
			$("#questionmsg").html("<font color=red><strong>安全问题不能为空</strong></font>");
			return false;
		}
		
		if(answer=="" || answer==null ){
			$("#answernmsg").html("<font color=red><strong>问题答案不能为空</strong></font>");
			return false;
		}
		
		$("#form1").submit();
	}
	
	function checkpwd()
	{
		var pwd1=$("#pwd1").val();
		var pwd2=$("#pwd2").val();
		if(pwd1 != pwd2 && pwd2!='' ){
			$("#pwd2msg").html("<font color=red><strong>两次密码不一致</strong></font>");
		}
		else
		{
			$("#pwd2msg").html("");
		}
	}

</script>
<body>
<form id="form1" name="form1" method="post" action="reg_ret.php">
  <table width="500" border="1" align="center" cellpadding="5" cellspacing="0">
    <tr>
      <td height="75" colspan="2" align="center"><h1>用户注册</h1></td>
    </tr>
    <tr>
      <td width="121">用户名:</td>
      <td ><input type="text" name="username" id="username"  onblur="checkUsername()"/><span id="checkuser"></span></td>
    </tr>
    <tr>
      <td>密码:</td>
      <td><input type="password" name="pwd1" id="pwd1" onblur="checkpwd()" /><span id="pwd1msg"></span></td>
    </tr>
    <tr>
      <td>确认密码:</td>
      <td><input type="password" name="pwd2" id="pwd2" onblur="checkpwd()" /><span id="pwd2msg"></span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>安全问题:</td>
      <td><input class="inptx" type="text" name="question" id="question" /><span id="questionmsg"></span></td>
    </tr>
    <tr>
      <td>问题答案:</td>
      <td><input class="inptx1" type="text" name="answer" id="answer" /><span id="answernmsg"></span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><a href="index.php">&lt;&lt;登录</a></td>
      <td><input type="button" name="button" id="button" value="注册" onclick="submitForm();"/> <input name="exc" type="hidden" id="exc" value="add" /></td>
    </tr>
  </table>
</form>
</body>
</html><?php }} ?>
