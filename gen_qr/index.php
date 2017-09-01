<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
require_once('../_module/folder.m.php');
include "phpqrcode/qrlib.php"; 

set_time_limit(0);

//获得所有文件
function  zhShowFileCount($dir) {
    $handle=opendir($dir);   
	$i=0;   
	while($file=readdir($handle)) {   
	  if (($file!=".")and($file!="..")) {   
	  $list[$i]=$file;   
	  $i=$i+1;   
	  }   
  }   
  closedir($handle);  
  return $i;
}

//获得所有文件
function  zhDeleetAllFiles($dir) {
  $handle=opendir($dir);   
  $i=0;   
  while($file=readdir($handle)) {   
  if (($file!=".")and($file!="..")) {   
  $list[$i]=$file;   
  $i=$i+1;   
  }   
  }   
  closedir($handle);  
  if($list)
  {
	foreach($list as $df)
	{
	  $delfn="$dir/$df";
	  unlink($delfn);  
	}
  }
  //重定向浏览器 
  header("Location: ?");
}

//删除文件
$method=$_REQUEST['method'];
if(0==strcmp($method,'del_all') )
{
	zhDeleetAllFiles('./qr_img/');
}

//
$data=$_REQUEST['data'];

?>
<body>
<p><a href="../">返回档案</a></p>
<table width="80%" border="1" align="center" cellpadding="5" cellspacing="0">
<form action="?" method="post">
  <tr>
    <td>
      <p>请填入内容,内容不允许有逗号,多行即生成多个二维码</p>
      <p>
        <label>
          <textarea name="data" cols="50" rows="10" id="data" style="width:100%"><?=$data?></textarea>
        </label>
      </p>
    </td>
    <td width="25%" align="center"><input type="submit" name="button" id="button" value=" 生成二维码 "  style="width:100px;height:100px"/></td>
    <td width="25%" align="center"><p>
      <input type="button" name="button2" id="button2" value="删除缓存文件"  style="width:100px;height:100px" onclick="location.href='?method=del_all'"/>
    </p>
      <p>当前文件数量:<span id="imgcount"><?=zhShowFileCount('./qr_img/')?></span></p></td>
  </tr>
  </form>
</table>
</p>

<table width="80%" border="1" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td width="9%">&nbsp;</td>
    <td width="16%"><strong>名称</strong></td>
    <td width="15%"><strong>二维码</strong></td>
    <td width="60%"><strong>备注</strong></td>
  </tr>

<?php
    

/*
    $data 数据
    $filename 保存的图片名称
    $errorCorrectionLevel 错误处理级别
    $matrixPointSize 每个黑点的像素
    $margin 图片外围的白色边框像素
*/
zhPhpMkDir('./qr_img/');
if(strcmp($data,''))
{
	$i=0;
	$ex=str_replace("\n",",",$data);
	$ex=explode(',',$ex);
	//var_dump($ex);
	foreach($ex as $aa)
	{
		$aa=trim($aa);
		if($aa!='')
		{
			$filename='./qr_img/'.urlencode($aa).".png";
			$errorCorrectionLevel="L"; 
			$matrixPointSize="5";
			$margin="2";
			QRcode::png($aa, $filename, $errorCorrectionLevel, $matrixPointSize, $margin);
			//echo $aa;
	
?><tr>
    <td align="center"><strong><?=$i+1?></strong></td>
    <td><?=$aa?></td>
    <td><?="<img src=\"$filename\"/>"?></td>
    <td>&nbsp;</td>
  </tr>
<?php
			$i++;
  	    }	
	}
}
?>
</table>
<script language="javascript">
var imgCount=parseInt(document.getElementById("imgcount").innerHTML);
imgCount+=<?=$i?>;
document.getElementById("imgcount").innerHTML=imgCount;
</script>
</body>