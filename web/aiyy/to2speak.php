<meta content="text/html; charset=utf-8" http-equiv="content-type" />

<?php
$url = "http://vop.baidu.com/server_api";

$speakMsg=$_REQUEST['txt'];
if(''==$speakMsg)
{
echo 'no parameter = txt';
exit;
}

echo $tokenUrl="http://www.hanzhihong.cn/aiyy/token.php";
$j = file_get_contents($tokenUrl);
$j = json_decode(trim($j,chr(239).chr(187).chr(191)),true);
$token=$j['token'];
$cuid=$j['cuid'];

$url = "http://tsn.baidu.com/text2audio?";
$param = "per=4&spd=3&tex=$speakMsg&lan=zh&ctp=1&cuid=$cuid&tok=$token";
$url =  $url.$param;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
$response = curl_exec($ch);
if(curl_errno($ch))
{
    print curl_error($ch);
}

curl_close($ch);

echo "<br />";
//var_dump($response);


//删除文件
$iter = new RecursiveDirectoryIterator("./");
foreach (new RecursiveIteratorIterator($iter, RecursiveIteratorIterator::CHILD_FIRST)
as $f) {
  if (substr(strrchr($f->getPathname(), '.'), 1)=='mp3') {
    unlink($f->getPathname());
  }
}

//创建播放文件
$mp3file=time(NULL).".mp3";
file_put_contents($mp3file, $response, FILE_APPEND);

?>

<audio controls="controls" autoplay="autoplay">
  <source src="<?=$mp3file?>" type="audio/mpeg" />
</audio>
