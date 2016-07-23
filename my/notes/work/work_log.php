<?php

require_once('../config.php');
require_once('../../_module/mysql.m.php');
require_once('../../_module/encode.m.php');

//1.html
$method=$_REQUEST['method'];

$work_list_autoid=$_REQUEST['wlist_id'];
if(intval($work_list_autoid)<=0)
{
	echo 'err="wlist_id is null"';
	exit;
}

if(0==strcmp($method,'update_schedule'))
{
	//开始页数为0
	$schedule=$_REQUEST['schedule'];
	if(0==strcmp($schedule,''))
	{
		echo 'err="schedule is null"';
		exit;
	}
	
	$db=new PzhMySqlDB();	
	$db->open_mysql(cfg_db_host,cfg_db,cfg_db_username,cfg_db_passwd);
	$result=$db->query('update work_list set schedule='.$schedule.' where autoid='.$work_list_autoid,0,0);
	if($result)
	{
		echo 'update schedule success <a href="?method=html&wlist_id='.$work_list_autoid.'&page=0&showcount=0&sequence=0">done.</a>';
	}
	else
	{
		echo 'operator schedule <a href="?method=html&wlist_id='.$work_list_autoid.'&page=0&showcount=0&sequence=0">fail.</a>';
	}
	$db->close();
	exit;
}

/////////////////////////////////////////////////////////////////////
//显示页面

//开始页数为0
$page=$_REQUEST['page'];
if(0==strcmp($page,''))
{
	echo 'err="page is null,0=begin page"';
	exit;
}
//$showcount为0时显示全部
$showcount=$_REQUEST['showcount'];
if(0==strcmp($showcount,''))
{
	echo 'err="showcount is null,0=show all"';
	exit;
}
		
$db=new PzhMySqlDB();	
$db->open_mysql(cfg_db_host,cfg_db,cfg_db_username,cfg_db_passwd);
$db->query('select *from work_list where autoid='.$work_list_autoid,0,0);
if(!($rs=$db->read()))
{
	echo 'err="not found wlist_id '.$work_list_autoid.'"';
	$db->close();
	exit;
}

$select0='onclick="javascript:submit()"';
$select1='onclick="javascript:submit()"';
$select2='onclick="javascript:submit()"';
$select3='onclick="javascript:submit()"';
$select4='onclick="javascript:submit()"';
switch($rs['schedule'])
{
	case 0:
	$select0='checked="checked"';
	break;
	case 1:
	$select1='checked="checked"';
	break;
	case 2:
	$select2='checked="checked"';
	break;
	case 3:
	$select3='checked="checked"';
	break;
	case 4:
	$select4='checked="checked"';
	break;
}
	
?><table width="100%" border="1" cellpadding="10" cellspacing="0">
  <tr>
    <td><p style="padding-top:20px; padding-bottom:20px"><?php echo zhPhpTrHtml($rs['content']);?></p></td>
  </tr>
 <tr>
    <td><form action="?method=update_schedule&wlist_id=<?=$work_list_autoid?>" method="post" name="form1">
<input type="radio" name="schedule" id="schedule_0"  value="0" <?=$select0?> />未开始
    <input type="radio" name="schedule" id="schedule_1" value="1" <?=$select1?> />进行中
    <input type="radio" name="schedule" id="schedule_2" value="2" <?=$select2?> />维护期
    <input type="radio" name="schedule" id="schedule_3" value="3" <?=$select3?> />完成
    <input type="radio" name="schedule" id="schedule_4" value="4" <?=$select4?> />放弃
</form></td>
  </tr>
</table>

<?php

	$db->query('select *from work_log where work_list_autoid='.$work_list_autoid.' order by autoid',$showcount,$page);
	//输出表格
	echo '</br></br><a href="log_add.php?wlist_id='.$work_list_autoid.'" target="log_add">添加记录</a>';
	echo '&nbsp;&nbsp;&nbsp;&nbsp;<a href="?wlist_id='.$work_list_autoid.'&page='.$page.'&showcount='.$showcount.'">刷新</a>';
	echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
	echo '<table width=100% border=1 cellpadding=4 cellspacing=0>';
	echo '<tr bgcolor="#CCCCCC">';
	echo '<td>内容</td>';
	echo '<td>时间</td>';
	echo '<td>操作员</td>';
	echo '</tr>';
	while($rs=$db->read())
	{
		echo '<tr>';
		echo '<td>'.zhPhpTrHtml($rs['content']).'</td>';//执行内容
		echo '<td>'.zhPhpTrHtml($rs['time']).'</td>';//时间
		echo '<td>'.zhPhpTrHtml($rs['confirm']).'</td>';//授权签名
		echo '</tr>';
	}
	echo '</table>';
	echo '<br/><iframe name="log_add" border="0" src="" width="100%" height="200"></iframe>';
	if($showcount>0)
	{
		echo '</br>当前第'.($page+1).'页</br></br>';
		$n=$db->record_count()/$showcount;
		for($i=0;$i<=$n;$i++)
		{
			echo '<a href="?wlist_id='.$work_list_autoid.'&page='.$i.'&showcount='.$showcount.'&sequence='.$sequence.'">第'.($i+1).'页</a>&nbsp;&nbsp;&nbsp;&nbsp;';
		}
	}
	$db->close();
	


?>