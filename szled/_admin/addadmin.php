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

$_CON=new PzhMySqlDB();	

$USERNAME=$_REQUEST['USERNAME'];
$PASSWORD=$_REQUEST['PASSWORD'];
$CONENT=$_REQUEST['CONENT'];
$LEVEL=$_REQUEST['LEVEL'];

$USERNAME=zhPhpTrSql($USERNAME);
$CONENT=zhPhpTrSql($CONENT);

if($USERNAME && !$PASSWORD || $USERNAME &&!$CONENT)
echo "<script>alert('�����Ϣȫ����д����');</script>";

if($USERNAME && $PASSWORD  && $CONENT )
{
	 $CONENT=zhPhpTrSql($CONENT);
	 $PASSWORD=md5($PASSWORD);
	 $USERNAME=zhPhpTrSql($USERNAME);
	 $_CON->open_mysql(cfg_db_host,cfg_db_name,cfg_db_username,cfg_db_passwd);
	 $_CON->query("select*from tbAdmin where username='$USERNAME'");
	 if(!$_CON->read())
	 {
	   $_CON->query("insert into tbAdmin(username,password,lastlogin,level,whocreate,conent,ip) values('$USERNAME','$PASSWORD','$nowTime',$LEVEL,'$ADMIN_USER','$CONENT','0.0.0.0')");
			 echo "$USERNAME ����Ա��ӳɹ�!! <a href=?>�������</a>";exit;
		 }else{echo "$USERNAME ����Ա�������ظ�,���ʧ��!! <a href=?>�������</a>";exit;}
	 $_CON->close();
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>��ӹ���Ա</title>
<style type="text/css">
<!--
.STYLE1 {color: #FF0000}
body,td,th {
	font-size: 12px;
}
.STYLE2 {	color: #FF0000;
	text-decoration: none;
}
-->
</style>
</head>

<body>
<table width="100%" height="50" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="13"><div align="center" class="STYLE1">
      <div align="left">����Ա����&gt;&gt;��ӹ���Ա����������������������������������������*��ӹ���Ա (ֻ����
        <?=$ADMIN_MANGER_EXECUTE?>
        �������Ϲ���Ա��������¹���Ա) </div>
    </div></td>
  </tr>
  <tr>
    <td height="12"><hr /></td>
  </tr>
  <tr>
    <td valign="top"><form id="form1" name="form1" method="post" action="">
      <table width="74%" height="18" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#D7D7D7">
        <tr>
          <td width="32%" align="right">�û���:</td>
          <td width="68%"><label>
            <input name="USERNAME" type="text" id="USERNAME" size="32" maxlength="16" />
          </label></td>
        </tr>
        <tr>
          <td align="right">�ܡ���:</td>
          <td><input name="PASSWORD" type="text" id="PASSWORD" size="32" maxlength="16" /></td>
        </tr>
        <tr>
          <td align="right">������:</td>
          <td><label>
            <select name="LEVEL" id="LEVEL">
             <?php for($i=1;$i<=3;$i++){ ?>
			  <option value="<?=$i?>"><?=$i?></option>
			 <?php }?>
            </select>
          </label></td>
        </tr>
        <tr>
          <td align="right" valign="top" bgcolor="#FFFF99">&nbsp;</td>
<td bgcolor="#FFFF99">&nbsp;</td>
        </tr>
        <tr>
          <td align="right" valign="top">����ע:</td>
          <td><textarea name="CONENT" cols="30" rows="10" id="CONENT"></textarea></td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td align="right">&nbsp;</td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td align="left"><label>
            <input type="button" name="Submit" value="ȷ����ӹ���Ա" onclick="confirm_post()" />
			<script>
			<!--
			function confirm_post()
			{
			   if(confirm("�Ƿ�ȷ����ӹ���Ա?"))
			     {
				    form1.submit();
				 }  
			}	
			 -->	
			</script>
          </label></td>
        </tr>
      </table>
        </form>
    </td>
  </tr>
</table>
</body>
</html>
