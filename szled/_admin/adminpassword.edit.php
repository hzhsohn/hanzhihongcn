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

//var_dump($ADMIN_USER);

$_CON=new PzhMySqlDB();	
$_CON->open_mysql(cfg_db_host,cfg_db_name,cfg_db_username,cfg_db_passwd);
$oldpwd=$_REQUEST['oldpwd'];
$PASSWORD=$_REQUEST['PASSWORD'];
$PASSWORD2=$_REQUEST['PASSWORD2'];
if($_POST["PASSWORD"]!=null && $_POST["PASSWORD2"]!=null && $oldpwd!=null)
{
   if($_POST["PASSWORD"]==$_POST["PASSWORD2"])
   {
		$oldpwd=md5($oldpwd);
		$PASSWORD=md5($PASSWORD);
		$_CON->query("select username from tbAdmin where username='$ADMIN_USER' and password='$oldpwd'");
		//echo "select username from tbAdmin where username='$ADMIN_USER' and password='$oldpwd'";
		if($rsCk=$_CON->read())
			{
   				$_CON->query("update tbAdmin set [password]='$PASSWORD' where username='$ADMIN_USER' and password='$oldpwd'");
				 echo "�����޸ĳɹ�  <a href='adminlist.php'>�������Ա�б�</a>";
				 exit;
			 }
		else
			{
			echo "<script>alert('�����벻����,�޸�ʧ��');</script>";
			}
   }
   else
	{echo "<script>alert('�������벻��ͬ');</script>";}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>�޸�����</title>
<style type="text/css">
<!--
body,td,th {
	font-size: 14px;
}
.STYLE2 {
	font-size: 24px;
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>
</head>
<body>
<table width="100%" height="164" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td height="35" align="center" bgcolor="#CCCC00" class="STYLE2">�޸�����</td>
  </tr>
  <tr>
    <td height="12"><hr /></td>
  </tr>
  <tr>
    <td valign="top"><form id="form1" name="form1" method="post" action="?"  autocomplete="off">
      <table width="74%" height="18" border="0" align="center" cellpadding="5" cellspacing="0">
        <tr>
          <td align="right">�����������:</td>
          <td><input name="oldpwd" type="password" id="oldpwd" maxlength="20" />
           </td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td width="41%" align="right">����������:</td>
          <td width="59%"><label>
            <input name="PASSWORD" type="password" id="PASSWORD" maxlength="16"/>
          </label></td>
        </tr>
        <tr>
          <td align="right">ȷ��������:</td>
          <td><input name="PASSWORD2" type="password" id="PASSWORD2" maxlength="16" /></td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td align="right">&nbsp;</td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td align="left"><label>
            <input type="submit" name="Submit" value="ȷ���޸�" />
          </label></td>
        </tr>
      </table>
    </form></td>
  </tr>
</table>
</body>
</html>
<?php
$_CON->close();
?>