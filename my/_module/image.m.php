<?php
/*****************************************************************
//Author:HanSohn
//Version:2.0.3
*****************************************************************/
function zhPhpStringImage($string,$width=100,$height=30)
{
	$im = imagecreate($width, $height);
	$r=rand(150,255);
	$g=rand(150,255);
	$b=rand(150,255);
	$black = imagecolorallocate ($im,$r,$g,$b);
	$font = imagecolorallocate ($im,255-$r,255-$g,255-$b);
	for($i=0;$i<strlen($string);$i++)
	imagestring($im,12,15*$i+10,rand(1,10),substr($string,$i,1),$font);
	imagepng ($im);
	imagedestroy ($im);
}
?>