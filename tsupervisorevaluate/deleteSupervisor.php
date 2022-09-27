<?php
	header("content-type:application/json;charset=UTF-8");
	include_once "../config/database.php";
	include_once "../objects/tsupervisorevaluate.php";
	$database=new Database();
	$db=$database->getConnection();
	$obj=new tsupervisorevaluate($db);
	$departmentCode=isset($_GET["departmentCode"])?$_GET["departmentCode"]:"";
	$userCode=isset($_GET["userCode"])?$_GET["userCode"]:"";
	$flag=$obj->deleteSupervisor($departmentCode,$userCode);
	echo json_encode(array("flag"=>$flag));
?>