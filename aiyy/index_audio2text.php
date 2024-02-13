<?php
//------------------------------------------------------------
//电脑上传
set_time_limit(0);
if(isset($_FILES['uploadinput']))
{
$path='./';
if(strcmp($_FILES['uploadinput']['name'],'') )
{
$fileName=urlencode($_FILES['uploadinput']['name']);
$ttName=$path.'/'.$fileName;
move_uploaded_file($_FILES['uploadinput']['tmp_name'],$ttName);
rename($ttName,'2.pcm');

echo file_get_contents('http://'.$_SERVER['HTTP_HOST'] .'/aiyy/to2text.php?pcm=2.pcm');

}
}
?>
</br></br></br></br></br>
<form action="?" method="post" enctype="multipart/form-data" name="form1">
    PCM file:<input name="uploadinput" type="file" />
    <input type="submit" name="Submit" value=" 提交 ">
    <input type="hidden" name="MAX_FILE_SIZE" value="4000000000"> 
</form>


