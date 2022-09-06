<?php
	header("content-type:application/json;charset=UTF-8");
	include_once "../config/database.php";
	include_once "../objects/tsupervisorevaluate.php";

	$database=new Database();
	$db=$database->getConnection();
	$obj=new tsupervisorevaluate($db);
	$departmentCode=isset($_GET["departmentCode"])?$_GET["departmentCode"]:"";
	$level=isset($_GET["level"])?$_GET["level"]:0;
	$flag=$obj->getHasSupervisor($departmentCode,$level);

	echo json_encode(array("flag"=>$flag));

?>