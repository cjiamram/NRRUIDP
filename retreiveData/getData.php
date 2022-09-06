<?php
	header("content-type:application/json;charset=UTF-8");
	include_once "../config/database.php";
	include_once "../objects/data.php";

	$database=new Database();
	$db=$database->getConnection();
	$obj=new Data($db);

	$departmentId=isset($_GET["departmentId"])?$_GET["departmentId"]:"";
	$keyWord=isset($_GET["keyWord"])?$_GET["keyWord"]:"";

	$stmt=$obj->getRequest($departmentId,$keyWord);
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
				"description"=>$description,
				"budget"=>$budget,
				"departmentId"=>$departmentId,
				"createDate"=>$createDate,
				"yearPlan"=>$yearPlan
				);
			array_push($objArr, $objItem);
		}

		echo json_encode($objArr);
	}else{
		echo json_encode(array("message"=>false));
	}


?>