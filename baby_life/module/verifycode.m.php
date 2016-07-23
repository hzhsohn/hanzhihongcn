<?php 

/*****************************************************************
//Author:HanSohn
//Version:2.0.3
*****************************************************************/
/*
sample:
	新建一个调用页面 
	<img src="verifycode.m.php?action=verifycode"/>
	
	//在提交验证的页面使用
	<?php
	require_once("module/verifycode.m.php");
	if(0==strcmp($_REQUEST['txt_verify'],zhPhpVeryifyCodeResult()))
	{ echo '验证成功';	 }
	else
	{ echo '验证失败';	 }
	echo '<br/>';
	echo 'txt_verify='.$_REQUEST['txt_verify'].'<br/>';
	echo 'veryify_code='.zhPhpVeryifyCodeResult();
	zhPhpVeryifyCodeDestory();
	?>
*/


//////////////////////////////////////////////////////////////////
require_once('session.m.php');

//验证码图片生成 
//返回bool
function zhPhpVeryifyCodeCreate() 
{ 
    //通知浏览器将要输出PNG图片 
    Header('Content-type: image/PNG'); 
    //准备好随机数发生器种子  
    srand((double)microtime()*1000000); 
	
    //准备图片的相关参数   
    $im = imagecreate(62,22); 
    $font_col = ImageColorAllocate($im,0,0,0);  //字体
    $white = ImageColorAllocate($im, 255,255,255); //RGB白色标识符 
    $gray = ImageColorAllocate($im, 200,200,200); //RGB灰色标识符 
    //开始作图     
    imagefill($im,0,0,$gray); 
    
	$randval=rand()%100000;
	$_SESSION["__zh_login_check_num_"] = $randval.''; 
	//将四位整数验证码绘入图片	
	imagestring($im, rand(5,14), rand(3,10), rand(1,5), $randval, $font_col); 

    //加入干扰象素    
    for($i=0;$i<200;$i++){
        $randcolor = ImageColorallocate($im,rand(0,255),rand(0,255),rand(0,255)); 
        imagesetpixel($im, rand()%70 , rand()%30 , $randcolor); 
    } 
    //输出验证图片 
    ImagePNG($im); 
    //销毁图像标识符 
    ImageDestroy($im); 
	
	return zhPhpSessionExist('__zh_login_check_num_');
}

//返回验证码的内容
function zhPhpVeryifyCodeResult()
{
    return $_SESSION['__zh_login_check_num_'];
}

/*
销毁验证码 
*/
function zhPhpVeryifyCodeDestory()
{
    zhPhpSessionRemove('__zh_login_check_num_');
}


//调用此页面，如果下面的式子成立，则生成验证码图片 
if($_GET["action"]=="verifycode") 
{zhPhpVeryifyCodeCreate();}
?>