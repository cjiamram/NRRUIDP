<?php
	header("content-type:application/json;charset=UTF-8");
	include_once "../config/database.php";
	include_once "../objects/tunderevaluate.php";

	$database=new Database();
	$db=$database->getConnection();

	$departmentCode=isset($_GET["departmentCode"])?$_GET["departmentCode"]:"";
	$levelEvaluate=isset($_GET["levelEvaluate"])?$_GET["levelEvaluate"]:0;


	$obj=new tunderevaluate($db);
	$flag=$obj->getHasUnder($departmentCode,$levelEvaluate);

	echo json_encode(array("flag"=>$flag));

?>