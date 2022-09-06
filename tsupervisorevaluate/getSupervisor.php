<?php
	header("content-type:application/json;charset=UTF-8");
	include_once "../config/database.php";
	include_once "../objects/tsupervisorevaluate.php";

	$database=new Database();
	$db=$database->getConnection();
	$obj=new  tsupervisorevaluate($db);
	$departmentCode=isset($_GET["departmentCode"])?$_GET["departmentCode"]:"";
	$level=isset($_GET["level"])?$_GET["level"]:0;
	$stmt=$obj->getSupervisor($departmentCode,$level);

	if($stmt->rowCount()>0){
		$row=$stmt->fetch(PDO::FETCH_ASSOC);
		extract($row);

		$objItem=array(
			"id"=>$id,
			"userCode"=>$userCode,
			"depPosition"=>$depPosition,
			"supervisorName"=>$supervisorName,
			"message"=>true
		);
		echo json_encode($objItem);
	}else{
		echo json_encode(array("message"=>false));
	}

?>