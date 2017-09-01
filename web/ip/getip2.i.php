<?php
$title=$_REQUEST['title'];

$filen="../ip/db.txt";

$fp=fopen($filen,"r");
if($fp)
{
  $json=fread($fp,filesize($filen));
  $json=json_decode($json);
  $obj=$json->$title;  
  if($obj)
  {
    echo $obj->ipv;
  }
}
else
{
  echo '0.0.0.0';
}
fclose($fp);


?>