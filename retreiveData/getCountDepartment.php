<?php
header("content-type:application/json;charset=UTF-8");
include_once "../config/config.php";
include_once "../config/database.php";
include_once "../objects/data.php";
$database=new Database();
$db=$database->getConnection();
$obj=new Data($db);
$sYear=isset($_GET["sYear"])?$_GET["sYear"]:date("Y")+543;
$fYear=isset($_GET["fYear"])?$_GET["fYear"]:date("Y")+548;
$depArr=isset($_GET["depArr"])?$_GET["depArr"]:"";

//print_r($depArr);

$stmt=$obj->getCountDepartment($sYear,$fYear,$depArr);
if($stmt->rowCount()>0){
	$objArr=array();
	while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
		extract($row);
		$objItem=array("departmentName"=>$departmentName,
					   "departmentCode"=>$departmentCode,
					   "budget"=>$Budget,
					   "CNT"=>$CNT
			);
		array_push($objArr, $objItem);
	}
	echo json_encode($objArr);
}
?>