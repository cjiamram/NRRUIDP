<?php
	header("content-type:application/json;charset=UTF-8");

	include_once "../objects/taproverequest.php";
	include_once "../config/database.php";

	$database=new Database();
	$db=$database->getConnection();
	$obj=new taproverequest($db);
	$requestId=isset($_GET["requestId"])?$_GET["requestId"]:0;
	$pType=isset($_GET["pType"])?$_GET["pType"]:0;
	$message=$obj->getAproveMessage($requestId,$pType);

	echo json_encode(array("message"=>$message));

?>