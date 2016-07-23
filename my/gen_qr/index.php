<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
require_once('../_module/folder.m.php');
include "phpqrcode/qrlib.php"; 

function getIP() /*获取客户端IP*/ 

{ 
    if (@$_SERVER["HTTP_X_FORWARDED_FOR"]) 
    $ip = $_SERVER["HTTP_X_FORWARDED_FOR"]; 
    else if (@$_SERVER["HTTP_CLIENT_IP"]) 
    $ip = $_SERVER["HTTP_CLIENT_IP"]; 
    else if (@$_SERVER["REMOTE_ADDR"]) 
    $ip = $_SERVER["REMOTE_ADDR"]; 
    else if (@getenv("HTTP_X_FORWARDED_FOR")) 
    $ip = getenv("HTTP_X_FORWARDED_FOR"); 
    else if (@getenv("HTTP_CLIENT_IP")) 
    $ip = getenv("HTTP_CLIENT_IP"); 
    else if (@getenv("REMOTE_ADDR")) 
    $ip = getenv("REMOTE_ADDR"); 
    else 
    $ip = "Unknown"; 
    return $ip; 
} 

?>
<p><a href="../">返回档案</a></p>
<table width="100%" border="1" cellpadding="5" cellspacing="0">
  <tr>
    <td><form action="?" method="post">
      <p>请填入内容
        <br />
        <label>
          <textarea name="data" cols="50" rows="10" id="data"><?=$data?></textarea>
        </label>
      </p>
      <p>
        <input type="submit" name="button" id="button" value=" 生成二维码 " />
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?='我的IP:'.getIP()?>
      </p>
    </form></td>
    <td width="50%"><?php
    

/*
    $data 数据
    $filename 保存的图片名称
    $errorCorrectionLevel 错误处理级别
    $matrixPointSize 每个黑点的像素
    $margin 图片外围的白色边框像素
*/
zhPhpMkDir('./qr_img/');
$data=$_REQUEST['data'];
$filename='./qr_img/'.getIP().'-'.time().".png";
if(strcmp($data,''))
{	
	$errorCorrectionLevel="L"; 
	$matrixPointSize="5";
	$margin="4";
	QRcode::png($data, $filename, $errorCorrectionLevel, $matrixPointSize, $margin);
	echo '<img src="'.$filename.'"/>';
}

/*
显示旧图片
*/
$old_pic=$_REQUEST['old_pic'];
if(strcmp($old_pic,''))
{
echo '<img src="'.$old_pic.'"/>';
}
?></td>
  </tr>
</table>
<p><?php
//获得所有文件
function  zhDirFiles($dir) {
	  $handle=opendir($dir);   
	  $i=0;   
	  while($file=readdir($handle)) {   
	  if (($file!=".")and($file!="..")) {   
	  $list[$i]=$file;   
	  $i=$i+1;   
	  }   
  }   
  closedir($handle);     
  return   $list;   
}


//删除文件
$method=$_REQUEST['method'];
if(0==strcmp($method,'del') )
{
	$fn=$_REQUEST['fn'];
	unlink('./qr_img/'.$project_id.'/'.$fn);
}

echo '<div>';
$ary=zhDirFiles('./qr_img/'.$project_id);
if($ary)
{
	
	foreach($ary as  $s)
	{
		//$s=iconv("GB2312","UTF-8",$s); 
		$ln_str=urlencode("qr_img/$s");
		echo "<a href=\"?old_pic=$ln_str\">$s</a>";
		echo ' ------------------------------ <a href="?method=del&fn='.urlencode($s).'">删除</a></br>'; 
	}
}
else
{
	echo '找不到任何文件';
}
echo '</div>';
?>
</p>