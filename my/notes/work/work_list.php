<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
<!--
.tim {
	font-family: "Times New Roman", Times, serif;
	font-size: 13px;
	color: #555;
	text-decoration: none;
	padding-top: 2px;
	padding-left: 2px;
	padding-bottom: 5px;
}
-->
</style>

<?php
require_once('../config.php');
require_once('../../_module/mysql.m.php');
require_once('../../_module/encode.m.php');
require_once('assist.php');

$method=$_REQUEST['method'];

//开始页数为0
$page=$_REQUEST['page'];
if(0==strcmp($page,''))
{
	$page=0;//默认
}
//$showcount为0时显示全部
$showcount=$_REQUEST['showcount'];
if(0==strcmp($showcount,''))
{
	$showcount=10; //默认
}
//&sequence排序0为顺序,1为倒序
$sequence=$_REQUEST['sequence'];
if(0==strcmp($sequence,''))
{
	$sequence=1;
}

if($sequence==0)
{$orderby=' asc';}
else
{$orderby=' desc';}

//进度默认设置,全部
$where_str='';
$schedule=$_REQUEST['schedule'];
if(0==strcmp($schedule,''))
{
	$schedule='-1';//加载页面默认进度是全部
}

?>
<a href="work_add.php" target="detailFrame">添加新项目</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?='?method='.$method.'&page='.$page.'&showcount='.$showcount.'&sequence='.$sequence.'&schedule='.$schedule?>">刷新</a>
</p>
<?php
if(intval($schedule)!=-1)
{$where_str.='where schedule='.$schedule;}
$select_a='onclick="javascript:submit()"';
$select0='onclick="javascript:submit()"';
$select1='onclick="javascript:submit()"';
$select2='onclick="javascript:submit()"';
$select3='onclick="javascript:submit()"';
$select4='onclick="javascript:submit()"';
switch(intval($schedule))
{
	case -1:
	$select_a='checked="checked"';
	break;
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

$schedule_ary=array('未开始','进行中','维护期' ,'完成','放弃');

echo '<form action="?page=0&showcount='.$showcount.'&sequence='.$sequence.'&schedule='.$schedule.'" method="post" name="form1">';
echo '<label><input type="radio" name="schedule" id="schedule_A" value="-1" '.$select_a.'/>全部</label> ';
	echo '<label><input type="radio" name="schedule" id="schedule_0" value="0" '.$select0.'/>未开始</label> ';
	echo '<label><input type="radio" name="schedule" id="schedule_1" value="1" '.$select1.'/>进行中</label> ';
	echo '<label><input type="radio" name="schedule" id="schedule_2" value="2" '.$select2.'/>维护期</label> ';
	echo '<label><input type="radio" name="schedule" id="schedule_3" value="3" '.$select3.'/>完成</label> ';
	echo '<label><input type="radio" name="schedule" id="schedule_4" value="4" '.$select4.'/>放弃</label> ';
echo '</form>';

$db=new PzhMySqlDB();	
$db->open_mysql(cfg_db_host,cfg_db,cfg_db_username,cfg_db_passwd);
$db->query('select count(*) from work_list '.$where_str);
$rs=$db->read();
$allrecdcount=$rs[0];
$db->query('select *from work_list '.$where_str.' order by time'.$orderby,$showcount,$page);
?>
<table width=100% border=1 cellpadding=4 cellspacing=0>
<tr bgcolor="#CCCCCC">
<td>&nbsp;</td>
<td>&nbsp;</td>
<td><strong>项目内容</strong></td>
<td>&nbsp;</td>
<td><strong>进度</strong></td>
<td>&nbsp;</td>
</tr>
<?php
$iii=$page*$showcount+1;
while($rs=$db->read())
{
	$autoid=$rs['autoid'];
	$set_name=zhPhpTrHtml($rs['set_name']);
	$check_name=zhPhpTrHtml($rs['check_name']);
	$content=zhPhpTrHtml($rs['content']);
	$gitadr=rep_cmd($rs['git_adr']);
	$time=$rs['time'];
	$time=explode(" ",$time);
	$time=$time[0];
	$schedule_str=$schedule_ary[intval($rs['schedule'])];
?>
  <tr>
	<td><?=$iii++?></td>
	<td><div style="padding:2px">负责:<?php echo $set_name ?></div>
    <div style="padding:2px">监督:<?php echo $check_name?></div></td>
	<td>
	<div class="tim"><?=$time ?></div><?=$content?><div><?=$gitadr?></div></td>
	<td><a href="project_modify.php?autoid=<?=$autoid?>" target="detailFrame">修改</a></td>
	<td><?php echo $schedule_str?></td>
	<td><a href="work_log.php?wlist_id=<?php echo $rs['autoid']?>&page=0&showcount=0" target="detailFrame">详细</a></td>
	</tr>
<?php
}
?>
</table>
<?php
if($showcount>0)
{
	echo '</br>当前第'.($page+1).'页</br></br>';
	$n=$allrecdcount/$showcount;
	for($i=0;$i<=$n;$i++)
	{
		echo '<a href="?page='.$i.'&showcount='.$showcount.'&sequence='.$sequence.'&schedule='.$schedule.'">第'.($i+1).'页</a>&nbsp;&nbsp;&nbsp;&nbsp;';
	}
}
$db->close();

?>