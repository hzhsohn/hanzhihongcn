<?php
/*****************************************************************
//Author:HanSohn
//Version:2.0.3
*****************************************************************/
//检查文件夹
function zhPhpMkDir($directoryName)
{
		$directoryName = str_replace("\\","/",$directoryName);
		$dirNames = explode('/', $directoryName);
		$total = count($dirNames) ;
		$temp = '';
		for($i=0; $i<$total; $i++) {
			$temp .= $dirNames[$i].'/';
			if (!is_dir($temp)) {
				$oldmask = umask(0);
				if (!mkdir($temp, 0777)) 
				{          
          //exit("不能建立目录 $temp");
          return false;
				} 
				umask($oldmask);
			}
		}
		return true;
}

//删除文件夹
function zhPhpDeleteDir($dir) {
  if(!is_dir($dir))return false;
  $dh=opendir($dir);
  while ($file=readdir($dh)) {
    if($file!="." && $file!="..") {
      $fullpath=$dir."/".$file;
      if(!is_dir($fullpath)) {
          unlink($fullpath);
      } else {
          deldir($fullpath);
      }
    }
  }

  closedir($dh);  
  if(rmdir($dir)) {
    return true;
  } else {
    return false;
  }
}
//获得所有文件
function  zhPhpGetFiles($dir)   {   
  $handle=opendir($dir);   
  $i=0;   
  while($file=readdir($handle))   {   
  if   (($file!=".")and($file!=".."))   {   
  $list[$i]=$file;   
  $i=$i+1;   
  }   
  }   
  closedir($handle);     
  return   $list;   
  }   
?>