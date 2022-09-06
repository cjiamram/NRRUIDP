<?php
header("content-type:application/json;charset=UTF-8");
include_once "../config/database.php";
include_once "../objects/data.php";
$database=new Database();
$db=$database->getConnection();
$obj=new Data($db);
$sYear=isset($_GET["sYear"])?$_GET["sYear"]:date("Y")+543;
$fYear=isset($_GET["fYear"])?$_GET["fYear"]:date("Y")+548;
$depArr=isset($_GET["depArr"])?$_GET["depArr"]:"";


$stmt=$obj->getPivot($sYear,$fYear,$depArr);
if($stmt->rowCount()>0){
	$objArr=array();
	while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
		extract($row);
		/*$objItem=array("departmentName"=>$departmentName,
			"yearPlan"=>$yearPlan,
			"DevlopmentType"=>$pType,
			"PlanNo"=>$CNT,
			"Budget"=>$Budget	
			);*/
		$objItem=array("หน่วยงาน"=>$departmentName,
			"ปี"=>$yearPlan,
			"ประเภทแผน"=>$pType,
			"จำนวนแผน"=>$CNT,
			"งบประมาณ"=>$Budget	
			);
		array_push($objArr, $objItem);
	}
	echo json_encode($objArr);

} else{
	echo json_encode(array("message"=>false));
} 

?>