<?php
	header("content-type:application/json;charset=UTF-8");
	include_once "../config/database.php";
	include_once "../objects/tunderevaluate.php";
	$database=new Database();
	$db=$database->getConnection();
	$obj=new tunderevaluate($db);
	$departmentCode=isset($_GET["departmentCode"])?$_GET["departmentCode"]:"";
	$supervisorCode=isset($_GET["supervisorCode"])?$_GET["supervisorCode"]:"";

	$flag=$obj->deleteBySupervisor($departmentCode,$supervisorCode);
	echo json_encode(array("flag"=>$flag));

?>