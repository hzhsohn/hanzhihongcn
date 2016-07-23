<?php
require_once('config.php');
require_once('../_module/mysql.m.php');
require_once('../_module/encode.m.php');
require_once("../_module/session.m.php");

//判断登录的SESSION
$userinfo=json_decode($_SESSION['ADMIN_INFO']);
if(is_null($userinfo))
{
	echo '<meta http-equiv="refresh" content="0;url=../admin/?reback=../notes/type.php">';
	echo'no userinfo';
	exit; 
}

$exc=$_REQUEST['exc'];
if(strcmp($exc,''))
{
	switch($exc){
	case 'oneadd':
		$p1=$_REQUEST['p1'];	
		$p1=zhPhpTrSql($p1);
		$db=new PzhMySqlDB();	
		$db->open_mysql(cfg_db_host,cfg_db,cfg_db_username,cfg_db_passwd);
		$db->query("insert into typeone(type_text) values('$p1')");
		$db->close();
		break;
	case 'onealter':
		$p1=$_REQUEST['one_p1'];
		$p2=$_REQUEST['one_p2'];
		$p2=urldecode(base64_decode($p2));
		$p2=zhPhpTrSql($p2);
		//echo $p2;
		$db=new PzhMySqlDB();	
		$db->open_mysql(cfg_db_host,cfg_db,cfg_db_username,cfg_db_passwd);
		$db->query("update typeone set type_text='$p2' where autoid=$p1");
		$db->close();
		break;
	case 'onedel':
		$p1=$_REQUEST['one_p1'];
		$db=new PzhMySqlDB();	
		$db->open_mysql(cfg_db_host,cfg_db,cfg_db_username,cfg_db_passwd);
		$db->query("select autoid from typetwo where typeone_id=$p1");
		if($rsChk=$db->read())
		{echo '操作失败. 原因:此分类还存子分类! <a href=?>继续操作</a>';exit;}
		else
		{$db->query("delete from typeone where autoid=$p1");}
		$db->close();
		break;
	case 'twoadd':
		$p1=$_REQUEST['two_add_p1'];
		$p2=$_REQUEST['two_add_p2'];
		$p1=zhPhpTrSql($p1);
		$p2=intval($p2);
		$db=new PzhMySqlDB();	
		$db->open_mysql(cfg_db_host,cfg_db,cfg_db_username,cfg_db_passwd);
		$db->query("insert into typetwo(type_text,typeone_id) values('$p1',$p2)");
		$db->query("select @@IDENTITY");
		$rs=$db->read();
		$rs=null;
		$db->close();
		break;
	case 'twoalter':
		$p1=$_REQUEST['alter_p1'];//ID
		$p2=$_REQUEST['alter_p2'];//类型
		$p3=$_REQUEST['alter_p3'];//名称
		$p1=intval($p1);
		$p2=intval($p2);
		$p3=urldecode(base64_decode($p3));
		$p3=zhPhpTrSql($p3);
		$db=new PzhMySqlDB();	
		$db->open_mysql(cfg_db_host,cfg_db,cfg_db_username,cfg_db_passwd);
	    $db->query("update typetwo set type_text='$p3',typeone_id=$p2 where autoid=$p1"); 
		$db->close();		
		break;
	case 'twodel':
		$p1=$_REQUEST['two_p1'];
		$db=new PzhMySqlDB();	
		$db->open_mysql(cfg_db_host,cfg_db,cfg_db_username,cfg_db_passwd);
		$db->query("delete from typetwo where autoid=$p1");
		//0是未分类
		$db->query("update information set typetwo_id=0 where typetwo_id=$p1");
		$db->close();
		break;
	}
	echo '操作成功.<a href="index.php" target="_parent">返回</a>';exit;
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>记事本类别管理</title>
<style type="text/css">
<!--
li {
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-bottom-style: dashed;
	border-top-color: #CCCCCC;
	border-right-color: #CCCCCC;
	border-bottom-color: #CCCCCC;
	border-left-color: #CCCCCC;
	padding-top: 5px;
	padding-bottom: 5px;
}
body {
	background-color: #EEE;
}
-->
</style>
<script src="js/base64.js" ></script>
<script>
function MM_goToURL() {
    var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
    for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}

var base64 = new Base64();  

</script>
</head>
<body>
<p>分类管理</p>
<hr />
<table width="98%" border="1">
  <tr>
    <td bgcolor="#CCCCCC">文章分类</td>
  </tr>
  <tr>
    <td><ol>
 <?php 
	 	$db=new PzhMySqlDB();	
		$db->open_mysql(cfg_db_host,cfg_db,cfg_db_username,cfg_db_passwd);
	 	$db->query("select * from typeone");
		 while($rs=$db->read()){
		 		$typeoneClassID[]=$rs['autoid'];
		 		$typeoneClass[]=$rs['type_text'];
		  		$alterName='typeone'.$rs['autoid'];
	?>
            <li><input name="<?=$alterName?>" id="<?=$alterName?>" type="text" value="<?=$rs['type_text']?>" maxlength="20" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <a href="javascript:void(0)" onclick="var str=base64.encode(encodeURIComponent(<?=$alterName?>.value));MM_goToURL('self','?exc=onealter&one_p1=<?=$rs['autoid']?>&one_p2='+str)">修改</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" onclick="if(confirm('确定删除 '+<?=$alterName?>.value+' 吗?'))MM_goToURL('self','?exc=onedel&one_p1=<?=$rs['autoid']?>')">删除</a></li>
            <?php 
			}
			$db->close();
			?>
	</ol></td>
  </tr>
  <tr>
    <td><form id="form1" name="form1" method="post" action="?">
        <label>
          增加一级分类
      <input name="p1" type="type_text" id="p1" />
        <input type="submit" name="Submit" value="提交" />
        </label>
        <input name="exc" type="hidden" id="exc" value="oneadd" />
    </form>    </td>
  </tr>
  </table>
<hr />
  
<table width="98%" border="1">
  <tr>
    <td bgcolor="#CCCCCC">子分类</td>
  </tr>
  <tr>
    <td><ol><?php 
				$db=new PzhMySqlDB();	
		$db->open_mysql(cfg_db_host,cfg_db,cfg_db_username,cfg_db_passwd);
				$db->query("select * from typetwo order by autoid,typeone_id");
		  		while($rs=$db->read()){
				$typeName='two_typeone'.$rs['autoid'];
				$alterName='type_text'.$rs['autoid'];				
		  ?>
            <li>
              <select name="<?=$typeName?>" id="<?=$typeName?>">
			  <option value="-1">无效类型</option>
			  <?php 
				for ($i=0;$i<count($typeoneClassID);$i++){
					if($typeoneClassID[$i]==$rs['typeone_id'])
					{ $select='Selected'; }
					else 
					{ $select=''; }
					echo '<option value="'.$typeoneClassID[$i].'"'.$select.'>'.$typeoneClass[$i].'</option>';
				}
			  ?>
              </select>
              <input name="<?=$alterName?>" type="text" id="<?=$alterName?>" value="<?=$rs['type_text']?>" maxlength="20" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <a href="javascript:void(0)" onclick="var str=base64.encode(encodeURIComponent(<?=$alterName?>.value));MM_goToURL('self','?exc=twoalter&alter_p1=<?=$rs['autoid']?>&alter_p2='+<?=$typeName?>.value +'&alter_p3='+str)">修改</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" onclick="if(confirm('确定删除 '+<?=$alterName?>.value+' 吗?'))MM_goToURL('self','?exc=twodel&two_p1=<?=$rs['autoid']?>')">删除</a></li>
     <?php 
	 }
	 $db->close();
	 ?></ol></td>
  </tr>
  <tr>
    <td><form id="form1" name="form1" method="post" action="?">
          增加子分类<select name="two_add_p2" id="two_add_p2">
                <?php
			  		for ($i=0;$i<count($typeoneClassID);$i++){
                		echo '<option value="'.$typeoneClassID[$i].'">'.$typeoneClass[$i].'</option>';
			 		}
			 	?>
              </select>
        <input name="two_add_p1" type="text" id="two_add_p1" />
        <input type="submit" name="Submit" value="提交" />
        </label>
        <input name="exc" type="hidden" id="exc" value="twoadd" />
    </form>  </td>
  </tr>
</table>
</body>
</html>