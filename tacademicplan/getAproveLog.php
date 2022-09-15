<?php
	header("content-type:application/json;charset=UTF-8");
	include_once "../config/database";
	include_once "../objects/tacademicplan.php";
	$database=new Database();
	$db=$database->getConnection();
	$obj=new tacademicplan($db);
	$id=isset($_GET["id"])?$_GET["id"]:0;
	$stmt=$obj->getAproveLog($id);
	if($stmt->rowCount()>0){
		$objArr=array();
		while($row=$stmt->fetch(PDO::ASSOC)){
			extract($row);
			
			$objItem=array("isAprove"=>$isAprove,
				"levelStatusCode"=>$levelStatusCode,
				"status"=>$status,
				"levelStatus"=>$levelStatus,
				"fullName"=>$fullName
				);
			array_push($objArr, $objItem);

		}
		return json_encode($objArr);
	}else
	{
		json_encode("message"=>$false);
	}

?>