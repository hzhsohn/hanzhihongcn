<?php
require_once('../public/encode.m.php');
require_once('../public/mysql.m.php');
require_once('../public/redirect.m.php');
require_once('../public/session.m.php');
require_once('../public/_config.php');

$ADMIN_INFO=zhPhpSessionGet("ADMIN_INFO");
if($ADMIN_INFO)
{
 $EX_INFO=explode(',',$ADMIN_INFO);
 $ADMIN_USER=$EX_INFO[0];
 $ADMIN_LEVEL=$EX_INFO[1];
}
else
zhPhpRedirect("../login.php?err=2");

if( $ADMIN_LEVEL<3)
{
echo '权限级别不足,要3级才能修改';
exit();
}

$_CON=new PzhMySqlDB();	

$_CON->open_mysql(cfg_db_host,cfg_db_name,cfg_db_username,cfg_db_passwd);

$conent=$_REQUEST['conent'];
$EDITNAME=$_REQUEST['EDITNAME'];
$LEVEL=$_REQUEST['LEVEL'];
if(trim($conent)!=null)
{
	$conent=zhPhpTrSql($conent);
	$EDITNAME=zhPhpTrSql($EDITNAME);
	$LEVEL=intval($LEVEL);
    $_CON->query("update tbAdmin set level=$LEVEL,conent='$conent',whocreate='$ADMIN_USER' where username='$EDITNAME'");
	echo '<script>window.close()</script>';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?=$_GET["EDITNAME"]?>备注信息</title>
<style type="text/css">
<!--
body,td,th {
	font-size: 14px;
	color: #FFFFFF;
	font-weight: bold;
}
body {
	background-image: url();
	background-color: #CCCCCC;
}
-->
</style>

</head>
<script>
<!--
function sendok()
{
document.form1.submit();
opener.location.reload();
}
 -->
</script>
<body topmargin="0" leftmargin="0">
<table width="100%" border="0" align="center" cellpadding="4" cellspacing="0" bgcolor="#000000">
  <tr>
    <td align="center" height="22"><?php  $_CON->query("select*from tbAdmin where username='$EDITNAME'");if(!$rs=$_CON->read())exit();?><span class="STYLE2">管理员&lt;<?=$EDITNAME?>&gt;的信息</span><hr></td>
  </tr>
  <tr>
    <td><form id="form1" name="form1" method="post" action="?">
      <table width="90%" border="1" align="center" cellpadding="3" cellspacing="0" bgcolor="#666633">
        <tr>
          <td>管理级别:</td>
          <td><select name="LEVEL" id="LEVEL">
              <?php 
				  if($_GET['EDITNAME']!=$ADMIN_USER)
				  for($i=1;$i<=3;$i++){ ?>
              <option value="<?=$i?>" <?php if ($rs["level"]==$i)echo "selected='selected'"?>>------- <?=$i?>级 -------</option>
              <?php }  else  {?>
              <option value="<?=$ADMIN_LEVEL?>" selected="selected">
                <?=$ADMIN_LEVEL?>
                </option>
              <?php }?>
            </select>
            <input name="EDITNAME" type="hidden" id="EDITNAME" value="<?=$_GET['EDITNAME']?>" /></td>
        </tr>
        <tr>
          <td valign="top">备注信息:</td>
          <td><textarea name="conent" cols="50" rows="5"  id="conent"><?=$rs['conent']?></textarea></td>
        </tr>
        <tr>
          <td valign="bottom">
            <div align="center">
              <input type="button" name="Submit" value="确定修改" disabled="disabled" onclick="sendok()" />
            </div></td>
          <td><label>
            <input name="alterComfrim" type="checkbox" id="alterComfrim" onclick="if(this.checked)form1.Submit.disabled=false;else form1.Submit.disabled=true" value="checkbox" />
            确定修改
          </label></td>
        </tr>
      </table>
    </form></td>
  </tr>
</table>
</body>
</html>
<?php $_CON->close();?>