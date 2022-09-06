<?php
session_start();
require_once "vendor/autoload.php";
include_once "config/config.php";
require('html2text/html2text.php');
$cnf=new Config();
$rootPath=$cnf->path;
$yearPlan=isset($_GET["yearPlan"])?$_GET["yearPlan"]:2565;
$userCode=isset($_SESSION["UserName"])?$_SESSION["UserName"]:"chatchai.j";

//print_r($rootPath);

try {
    $mpdf = new \Mpdf\Mpdf([
        'mode' => 'utf-8',
        'default_font_size' =>  16,
        'default_font' => 'sarabun',
        'tempDir' => __DIR__ . '/tmp'
    ]);
    $url=$cnf->restURL."selfReport.php?yearPlan=".$yearPlan."&userCode=".$userCode;
    //print_r($url);
    $html = file_get_contents($url);
  

   $mpdf->WriteHTML($html);
   $mpdf->Output();
} catch (\Mpdf\MpdfException $e) { // Note: safer fully qualified exception
    // name used for catch
    // Process the exception, log, print etc.
    echo $e->getMessage();
}


?>