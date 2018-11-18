<?php
require_once("module/Smarty-3.1.16/libs/Smarty.class.php");
require_once("module/encode.m.php");
require_once("_config.php");
require_once "module/phpqrcode/qrlib.php"; 

//获取SESSION的各种值
$data='#dw://'.$_REQUEST['data'];

$errorCorrectionLevel="L"; 
$matrixPointSize="5";
$margin="4";
QRcode::png($data,false, $errorCorrectionLevel, $matrixPointSize, $margin);

// benchmark
//QRtools::timeBenchmark();    
?>
