<?php
/*****************************************************************
//Author:HanSohn
//Version:2.0.3
*****************************************************************/
/*
   保存到数据库时使用的函数
*/
function zhPhpTrSql($theString)
{	
		if($theString==null)return;
		$theString = str_replace('"','&quot;',  $theString);
		$theString = str_replace("'",'&acute;',  $theString);
		$theString = str_replace("′",'&acute;',  $theString);
		$theString = str_replace('>','&gt;',$theString);
		$theString = str_replace('<','&lt;',$theString);
		return $theString; 
}

/*
   将纯文本转成HTML文本
*/
function zhPhpTrHtml($theString)
{	
		if($theString==null)return;
		$theString = htmlspecialchars( stripslashes($theString) ); 
		$theString = str_replace("\n", '<br/>',$theString);
		$theString = str_replace(' ','&nbsp;',$theString);
		return $theString; 
}

//中文字符截取
function zhPhpSubstrGb2312($str, $start, $len)    
{   
 $tmpstr = "";   
 $strlen = $start + $len;     
	 for($i = 0; $i < $strlen; $i++) 
	 {         
		 if(ord(substr($str, $i, 1)) > 0xa0) 
			 {             
			 $tmpstr .= substr($str, $i, 2);             
			 $i++;         
			 } 
		 else             
			 $tmpstr .= substr($str, $i, 1);    
	  }     
  return $tmpstr; 
} 
?>