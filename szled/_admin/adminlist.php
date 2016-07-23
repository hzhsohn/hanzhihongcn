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


$RS_NUM=10;    //每页记录数
if($_GET['PAGE']==null or $_GET['PAGE']<1)
$PAGE=1;
else
$PAGE=$_GET['PAGE'];


$_CON=new PzhMySqlDB();	
$_CON->open_mysql(cfg_db_host,cfg_db_name,cfg_db_username,cfg_db_passwd);

$del=$_GET["del"];
if($del!=null)
  $_CON->query("delete from tbAdmin where username='$del'");
  
  
$_CON->query("select count(*) as m_count from tbAdmin");
$rs=$_CON->read();
$m_count=$rs["m_count"];


$FINDS=$_REQUEST['FINDS'];
if($FINDS!=null)
$_CON->query("select*from tbAdmin where username like '%$FINDS%' order by lastlogin desc"); 
else
$_CON->query("select*from tbAdmin order by lastlogin desc");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>管理员列表</title>
<style type="text/css">
<!--
.STYLE1 {
	color: #FF0000;
	text-decoration: none;
}
body,td,th {
	font-size: 12px;
}
.dline {
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-bottom-style: solid;
	border-top-color: #999999;
	border-right-color: #999999;
	border-bottom-color: #999999;
	border-left-color: #999999;
}
a:link {
	text-decoration: none;
	color: #0033FF;
}
a:visited {
	text-decoration: none;
	color: #0000FF;
}
a:hover {
	text-decoration: none;
	color: #FF0000;
}
a:active {
	text-decoration: none;
	color: #33CC00;
}
.STYLE2 {color: #FF0000}
-->
</style>


<script>
<!--
function finds(link_s)
{

MM_goToURL('self','?FINDS='+link_s)
}
function finds2(b,e)
{
if(b=="")
alert("请输入开始日期");
else
if(e=="")alert("请输入终止日期");
else

MM_goToURL('self','?begin='+b+'&end='+e)
}

function MM_goToURL() { //v3.0
var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}

function topage(n)
{
MM_goToURL('self','?PAGE='+n+'&FINDS=<?=$_GET['FINDS']?>')
}

function del(link_str)
{
if(confirm("确定删除吗?"))
MM_goToURL('self','?PAGE=<?=$PAGE?>&del='+link_str)
}
 -->
</script>
<script src="../js/showDialog.js"></script>
</head>
<body>
<table width="100%" height="50" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="13" colspan="6"><div align="left" class="STYLE1">
	  管理员设置&gt;&gt;管理员列表　　　　　　　　　    　　　　　　　</div></td>
  </tr>
  <tr>
    <td height="12" colspan="6"><hr></td>
  </tr>
  <tr>
    <td width="4%" valign="top">&nbsp;</td>
    <td valign="top">
      请输入管理员账号	  
      <input name="findname" type="text" id="findname" value="<?=$_GET['FINDS']?>" size="23" />
      <input type="button" name="Submit" onclick="finds(findname.value)" value="查找" />      <label></label></td>
    <td align="center" valign="bottom">当前为第<span class="STYLE2">
      <?=$PAGE?>
    </span>页</td>
    <td width="9%" align="center" valign="bottom"><a href="javascript:topage(<?=$PAGE-1?>);">上一页</a></td>
    <td width="10%" valign="bottom"><a href="javascript:topage(<?=$PAGE+1?>);">下一页</a> </td>
    <td width="6%" valign="bottom"><select name="select1" onchange="topage(select1.options[select1.selectedIndex].value)">
      <?php  for($i=1;$i<=($_CON->record_count()/$RS_NUM)+1 ;$i++){?>
      <option value="<?=$i?>" <?php if ($PAGE==$i)echo 'selected=selected'?>>
      <?=$i?>
      </option>
      <?php }?>
    </select>       </td>
  </tr>
  <tr>
    <td colspan="6" valign="top">
	

	
	<table width="94%" border="0" align="center" cellpadding="4" cellspacing="0">
      <tr>
        <td height="12" colspan="8"></td>
      </tr>
      <tr>
        <td  height="12"><strong>管理员账号</strong></td>
        <td align="center"><strong>账号级别</strong></td>
        <td align="center"><strong>最后登录时间</strong></td>
        <td align="center"><strong>最后登录IP</strong></td>
        <td align="center"><strong>修改人员</strong></td>
        <td align="center"><strong>备　注</strong></td>
        <td colspan="2" align="center"><strong>操作</strong></td>
      </tr>
  
	  <?php
	  $_CON->record_move(($PAGE-1)*$RS_NUM);
	  for($i=0;$i<$RS_NUM;$i++)
      if($rs=$_CON->read())
	    {?>
      <tr>
        <td height="5" colspan="8" class="dline"></td>
        </tr>
      <tr>
        <td  valign="top" bgcolor="#DFDFDF" class="dline">
          <?=$rs['username']?>         </td>
        <td align="center" valign="top" bgcolor="#EFEFEF" class="dline"><?=$ADMIN_LEVEL>=$rs['level']?$rs['level']:'*'?></td>
        <td valign="top" bgcolor="#DFDFDF" class="dline"><?=$rs['lastlogin']?></td>
        <td valign="top" bgcolor="#EFEFEF" class="dline"><?=$rs['ip']?></td>
        <td valign="top" bgcolor="#DFDFDF" class="dline"><?=$rs['whocreate']?></td>
        <td valign="top" bgcolor="#EFEFEF" class="dline"><?=$rs['conent']?></td>
        <td bgcolor="#FFFF66" class="dline" align="center">&nbsp;<?php if( $ADMIN_LEVEL>=3){
		echo "<a href=javascript:void(0)  onclick=window.open('admin.edit.php?EDITNAME=".urlencode($rs['username'])."','adminedit','width=600,height=400')>修改</a>";}?></td>
        <td bgcolor="#FFFF66" class="dline" align="center">&nbsp;<?php if($ADMIN_USER!=$rs['username'] &&  $ADMIN_LEVEL>=3 && $ADMIN_LEVEL>=intval($rs['level'])){?><a href="javascript:void(0)" onclick="del('<?=$rs['username']?>')">删除</a><?php }?></td>
      </tr>
	  <?php
	  }
	  ?>
    </table></td>
  </tr>
  <tr>
    <td colspan="6" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td colspan="5" valign="top"><strong>[详细数据]</strong></td>
  </tr>
  <tr>
    <td colspan="6" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td colspan="5" valign="top">查找到<?=$m_count?>条记录</td>
  </tr>
  <tr>
    <td colspan="6" valign="top">&nbsp;</td>
  </tr>
  
  <tr>
    <td valign="top">&nbsp;</td>
    <td colspan="5" valign="top">&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php $_CON->close();?>
