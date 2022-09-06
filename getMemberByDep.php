<?php
	
	ini_set('memory_limit', '-1');
	require_once("lib/nusoap.php");
    header("content-type application/json;charset=UTF-8");
    $departmentCode=isset($_GET["departmentCode"])?$_GET["departmentCode"]:"";
	$client = new nusoap_client("http://entrance.nrru.ac.th/nrruwebservice/nrruWebService_getStaffByDepartmentcode.php?wsdl",true); 
	$params = array(
		'departmentcode' => $departmentCode
	);
	$data = $client->call("getDepartmentCode",$params); 
	echo $data;	
?>