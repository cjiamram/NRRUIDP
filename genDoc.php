<?php
require  "pdfcrowd.php";
include_once "config/config.php";

try
{
    $cnf=new Config();
    $url=$cnf->restURL;
    $yearPlan=isset($_GET["yearPlan"])?$_GET["yearPlan"]:2565;
    $userCode=isset($_GET["userCode"])?$_GET["userCode"]:"chatchai.j";
    $staffId=isset($_GET["staffId"])?$_GET["staffId"]:"25141";
    $t=date("Y-m-h h:m:s");
    //print_r($staffId);
    $strHtml="http://nrruapp.nrru.ac.th/NRRUIDP/selfReport.php?yearPlan=".$yearPlan."&userCode=".$userCode."&staffId=".$staffId;
    //print_r($strHtml);
    $client = new \Pdfcrowd\HtmlToPdfClient("cjiamram", "a43cbcc6f3a27fc1b7acbf22ad56b720");

    // run the conversion and write the result to a file
    $strPath=__DIR__."/PDF/RPT-".$t."-".$userCode.".pdf";
    $strFile=$url."PDF/RPT-".$t."-".$userCode.".pdf";
    $client->convertUrlToFile($strHtml,  $strPath);

    // Store the file name into variable
    $file = $strFile;
    $filename = $strFile;
      
    // Header content type
    header('Content-type: application/pdf');
      
    header('Content-Disposition: inline; filename="' . $filename . '"');
      
    header('Content-Transfer-Encoding: binary');
      
    header('Accept-Ranges: bytes');
      
    // Read the file
    @readfile($file);

}
catch(\Pdfcrowd\Error $why)
{
    // report the error
    error_log("Pdfcrowd Error: {$why}\n");

    // rethrow or handle the exception
    throw $why;
}

?>