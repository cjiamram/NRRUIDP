<?php
	header("content-type:application/json;charset=UTF-8");
	include_once "../config/database.php";
	include_once "../objects/data.php";

	$database=new Database();
	$db=$database->getConnection();
	$obj=new Data($db);

	$userCode=isset($_GET["userCode"])?$_GET["userCode"]:"";

	$stmt=$obj->getWaitAproveByLevel($userCode);
	if($stmt->rowCount()>0){
		$objArr=array();
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			$status="";
			switch($planStatus){
				case 0:
					$status="รออนุมัติ";
					break;
				case 1:
					$status="อนุมัติ";
					break;
				case 2:
					$status="ไม่อนุมัติ";
					break;
				case 3:
					$status="สำเร็จ";
				case 5:
					$status="ไม่สำเร็จ";
					break;
				default:
					$status="รออนุมัติ";
			}

			$objItem=array(
				"id"=>$id,
				"pType"=>$pType,
				"pTypeCode"=>$pTypeCode,
				"userCode"=>$userCode,
				"fullName"=>$fullName,
				"topic"=>$Topic,
				"description"=>$description,
				"budget"=>$budget,
				"departmentId"=>$departmentId,
				"createDate"=>$createDate,
				"yearPlan"=>$yearPlan,
				"status"=>$status,
				"planStatus"=>$planStatus,
				"levelStatus"=>$levelStatus
				);
			array_push($objArr, $objItem);
		}

		echo json_encode($objArr);
	}else{
		echo json_encode(array("message"=>false));
	}


?>