<?php
/*****************************************************************
//Author:HanSohn
//Version:2.0.3
*****************************************************************/
/*
//用法
	$rep_str=file_get_contents($filepath);
	//---------------------参数begin----------------------
	$rep_str=str_replace('$#ID',$ID,$rep_str);
	//---------------------参数end----------------------
	ob_start();
	echo $rep_str;			//页面内容
	$this_my_f= ob_get_contents(); 
	ob_end_clean();
	$filename = "$CourseAutoID.html";
	if(zhPhpCreatePage($filename,$this_my_f))
	echo "生成成功 $filename";
*/

//把生成文件的过程写出函数
function zhPhpCreatePage($file_cjjer_name,$file_cjjer_content)
{
	 if (is_file ($file_cjjer_name)){
	  //@unlink ($file_cjjer_name);
	 }
	@$cjjer_handle = fopen ($file_cjjer_name,"w");
	 if (!is_writable ($file_cjjer_name)){
	  return false;
	 }
	 if (!fwrite ($cjjer_handle,$file_cjjer_content)){
	  return false;
	 } 
	fclose ($cjjer_handle); //关闭指针
	return $file_cjjer_name;
}

/*
取得所有链接
获取$conent内容里面的所有超连接内容,
反正到数组列表里
*/
function zhPhpGetAllUrl($conent){ 
        preg_match_all('/<a\s+href=["|\']?([^>"\' ]+)["|\']?\s*[^>]*>([^>]+)<\/a>/i',$conent,$arr); 
        return array('name'=>$arr[2],'url'=>$arr[1]); 
}

/*
获取指定标记中的内容
$num是搜索$end到第几次出现的次数为结束

获取指定标识里面的内容例如 
$str="<a>hahahaha</a>";
zhGetTagDate($str,"<a>","</a>")
*/
function zhPhpGetTag($str, $start, $end,$num=1){
        if ( $start == '' || $end == '' ){
               return;
        }
        $str = explode($start, $str);
        $str = explode($end, $str[$num]);
        return $str[0]; 
}

?>