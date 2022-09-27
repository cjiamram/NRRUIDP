<?php
	header("content-type:application/json;charset=UTF-8");
	include_once "../config/database.php";
	include_once "../objects/tdepartment.php";

	$database=new Database();
	$db=$database->getconnection();
	$obj=new tdepartment($db);

	$stmt=$obj->getHeadDepartment();
	if($stmt->rowCount()>0){
		$objArr=array();
		$i=1;
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			$objItem=array("id"=>$id,
				"departmentId"=>$departmentId,
				"departmentName"=>$i." ".$departmentName);
			array_push($objArr, $objItem);

			$j=1;
			$stmt1=$obj->getChildDepartment($departmentId);
			if($stmt1->rowCount()>0){
				while($row1=$stmt1->fetch(PDO::FETCH_ASSOC)){
					extract($row1);
					$objItem1=array("id"=>$id,
						"departmentId"=>$childId,
						"departmentName"=>"&nbsp;&nbsp;&nbsp;".$i.".".$j." ".$childName);
						array_push($objArr, $objItem1);
						$j++;
					 }
					 
			}

			$i++;
			
		}

		echo json_encode($objArr);
	}
?>