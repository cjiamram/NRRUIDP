<?php
include_once "../config/config.php";
require_once __DIR__ . '/vendor/autoload.php';
$str=__DIR__ . '/vendor/autoload.php';
$cnf=new Config();
$url=$cnf->restURL;
$rootPath=$cnf->path;
$yearPlan=isset($_GET["yearPlan"])?$_GET["yearPlan"]:2565;
$userCode=isset($_GET["userCode"])?$_GET["userCode"]:"chatchai.j";
$staffId=isset($_GET["staffId"])?$_GET["staffId"]:"25141";


try {
    $mpdf = new \Mpdf\Mpdf([
        'format' => [300, 300],
        'mode' => 'utf-8',
        'default_font_size' => 12,
        'default_font' => 'sarabun',
        'orientation' => 'P',
        'SetMargins' => '(0, 0, 0)',

        'tempDir' => __DIR__ . '/vendor/mpdf/mpdf/tmp'
    ]);
    //$html="<table><tr><td></td></tr></table>";

    //$url=$cnf->restURL."front/getPayment.php?id=".$id;
    //print_r($url);
    $t=date("Y-m-h h:m:s");
    $url=$url."retreiveData/selfReport.php?yearPlan=".$yearPlan."&userCode=".$userCode."&staffId=".$staffId;
    //print_r($strHtml);



    $html = file_get_contents($url);

    //$html="<table><tr><td>ระบบการทำงาน MIS</td></tr></table>\n";

    //print_r($html);


    $mpdf->WriteHTML($html);
    $mpdf->Output();

} catch (\Mpdf\MpdfException $e) { // Note: safer fully qualified exception
    // name used for catch
    // Process the exception, log, print etc.
    echo $e->getMessage();
}


?>