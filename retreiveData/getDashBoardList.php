<?php
	header("content-type:application/json;charset=UTF-8");
	include_once "../config/database.php";
	include_once "../objects/data.php";

	$database=new Database();
	$db=$database->getConnection();
	$obj=new Data($db);

	$departmentId=isset($_GET["departmentId"])?$_GET["departmentId"]:"";
	$pType=isset($_GET["pType"])?$_GET["pType"]:"";
	$sYear=isset($_GET["sYear"])?$_GET["sYear"]:date("Y")+543;
    $fYear=isset($_GET["fYear"])?$_GET["fYear"]:date("Y")+548;
    $staffType=isset($_GET["staffType"])?$_GET["staffType"]:2;


	$stmt=$obj->getDashboardList_1($departmentId,$pType,$sYear,$fYear,$staffType);


	if($stmt->rowCount()>0){
		$objArr=array();
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			$objItem=array(
				"id"=>$id,
				"pType"=>$pType,
				"pTypeCode"=>$pTypeCode,
				"userCode"=>$userCode,
				"fullName"=>$fullName,
				"topic"=>$Topic,
				"budget"=>$budget,
				"departmentName"=>$departmentName,
				"createDate"=>$createDate,
				"yearPlan"=>$yearPlan,
				"planStatus"=>$planStatus,
				"staffType"=>$staffGroup
				);
			array_push($objArr, $objItem);
		}

		echo json_encode($objArr);
	}else{
		echo json_encode(array("message"=>false));
	}


?>