<?php
	header("content-type:application/json;charset=UTF-8");
	include_once "../config/database.php";
	include_once "../objects/data.php";

	$database=new Database();
	$db=$database->getConnection();
	$obj=new Data($db);
	$Year=isset($_GET["Year"])?$_GET["Year"]:date("Y")+543;
	$depArr=isset($_GET["depArr"])?$_GET["depArr"]:"";


	$stmt=$obj->getCountDepartmentByYear($Year,$depArr);
	if($stmt->rowCount()>0){
		$objArr=array();
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			$objItem=array("departmentName"=>$departmentName,"countPlan"=>$countPlan);
			array_push($objArr, $objItem);
		}
		echo json_encode($objArr);
	}else{
		echo json_encode(array("message"=>false));
	}

?>