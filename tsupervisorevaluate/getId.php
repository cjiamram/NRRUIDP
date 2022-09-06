<?php
	header("content-type:application/json;charset=UTF-8");
	include_once "../config/database.php";
	include_once "../objects/tsupervisorevaluate.php";

	$database=new Database();
	$db=$database->getConnection();
	$obj=new tsupervisorevaluate($db);
	$userCode=isset($_GET["userCode"])?$_GET["userCode"]:"";
	$id=$obj->getId($userCode);

	echo json_encode(array("id"=>$id));


?>