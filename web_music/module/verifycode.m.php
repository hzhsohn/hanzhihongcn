<?php 

/*****************************************************************
//Author:Han zhi hong
//Version:2.0.4
*****************************************************************/
/*
sample:
	新建一个调用页面 
	<img src="verifycode.m.php?action=verifycode"/>
	
	//在提交验证的页面使用
	<?php
	require_once("module/verifycode.m.php");
	if(zhPhpVeryifyCode($_REQUEST['txt_verify']))
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
  vCode(4, 22);
	return zhPhpSessionExist('__zh_login_check_num_');
}

 //4个数字，显示大小为15  
function vCode($num = 4, $size = 20, $width = 0, $height = 0) {   
    !$width && $width = $num * $size * 5 / 5 + 5;   
    !$height && $height = $size + 10;    
    // 去掉了 0 1 O l 等  
    $str = "23456789abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVW";
    $code = '';
    //准备好随机数发生器种子  
    srand((double)microtime()*1000000); 
    for ($i = 0; $i < $num; $i++) {   
        $code .= $str[rand(0, strlen($str)-1)];   
    }    
    // 画图像  
    $im = imagecreatetruecolor($width, $height);    
    // 定义要用到的颜色  
    $back_color = imagecolorallocate($im, 235, 236, 237);   
    $boer_color = imagecolorallocate($im, 118, 151, 199);   
    $text_color = imagecolorallocate($im, rand(0, 200), rand(0, 120), rand(0, 120));    
    // 画背景  
    imagefilledrectangle($im, 0, 0, $width, $height, $back_color);    
    // 画边框  
    imagerectangle($im, 0, 0, $width-1, $height-1, $boer_color);    
    // 画干扰线  
    for($i = 0;$i < 5;$i++) {   
        $font_color = imagecolorallocate($im, rand(0, 255), rand(0, 255), rand(0, 255));   
        imagearc($im, rand(- $width, $width), rand(- $height, $height), rand(30, $width * 2), rand(20, $height * 2), rand(0, 360), rand(0, 360), $font_color);   
    }    
    // 画干扰点  
    for($i = 0;$i < 50;$i++) {   
        $font_color = imagecolorallocate($im, rand(0, 255), rand(0, 255), rand(0, 255));   
        imagesetpixel($im, rand(0, $width), rand(0, $height), $font_color);   
    }    
    // 画验证码  
    @imagefttext($im, $size , 0, 5, $size + 3, $text_color, "font.ttf", $code);   
    //imagestring($im, $size*6 ,$size/2 , $size/4+rand(1,5), $code, $text_color); 
    $_SESSION['__zh_login_check_num_']=$code;
    imagepng($im);   
    imagedestroy($im);   
}  

//返回验证码的内容
function zhPhpVeryifyCodeResult()
{
    return $_SESSION['__zh_login_check_num_'];
}

//返回验证码验证
function zhPhpVeryifyCode($code)
{
    return 0==strcasecmp($code,$_SESSION['__zh_login_check_num_']);
}

/*
销毁验证码 
*/
function zhPhpVeryifyCodeDestory()
{
    zhPhpSessionRemove('__zh_login_check_num_');
}

//调用此页面，如果下面的式子成立，则生成验证码图片 
if(0==strcasecmp($_GET["action"],"verifycode")) 
{zhPhpVeryifyCodeCreate();}
?>