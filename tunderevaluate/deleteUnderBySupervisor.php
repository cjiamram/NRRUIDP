<?php
	header("content-type:application/json;charset=UTF-8");
	include_once "../config/database.php";
	include_once "../objects/tunderevaluate.php";
	$database=new Database();
	$db=$database->getConnection();
	$obj=new tunderevaluate($db);
	$userCode=isset($_GET["userCode"])?$_GET["userCode"]:"";
	$supervisorCode=isset($_GET["supervisorCode"])?$_GET["supervisorCode"]:"";

	$flag=$obj->deleteUnderBySupervisor($userCode,$supervisorCode);
	echo json_encode(array("flag"=>$flag));

?>