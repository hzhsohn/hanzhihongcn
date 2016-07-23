<?php 
/////////////////////
function rep_cmd($str)
{
	//Ìæ»»IP
	$str=str_replace("%ip",$_SERVER['SERVER_NAME'],$str);
	return $str;
}
/////////////////////

?>