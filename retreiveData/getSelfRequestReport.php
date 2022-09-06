<?php
	header("content-type:application/json;charset=UTF-8");
	include_once "../config/database.php";
	include_once "../objects/data.php";

	$database=new Database();
	$db=$database->getConnection();
	$obj=new Data($db);
	$userCode=isset($_GET["userCode"])?$_GET["userCode"]:"";
	$yearPlan=isset($_GET["yearPlan"])?$_GET["yearPlan"]:date("Y")+543;

	$stmt=$obj->getSelfRequestReport($userCode,$yearPlan);
	if($stmt->rowCount()>0){
		$objArr=array();
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			$status="";
			switch(intval($isAprove)){
				case 0:
					$status="รออนุมัติ";
					break;
				case 1:
					$status="อนุมัติ";
					break;
				case 2:
					$status="ไม่อนุมัติ";
					break;
				default:
					$status="รออนุมัติ";

			}

			$objItem=array(
				"id"=>$id,
				"pType"=>$pType,
				"pTypeCode"=>$pTypeCode,
				"topic"=>$Topic,
				"description"=>$description,
				"budget"=>$budget,
				"departmentId"=>$departmentId,
				"createDate"=>$createDate,
				"yearPlan"=>$yearPlan,
				"status"=>$status
				);
			array_push($objArr, $objItem);

		}

		echo json_encode($objArr);
	}else{
		echo json_encode(array("message"=>false));
	}

?>