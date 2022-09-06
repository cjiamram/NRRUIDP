<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once "../config/database.php";
include_once "../objects/trequest.php";
$database = new Database();
$db = $database->getConnection();
$obj = new trequest($db);
$userCode=isset($_GET["userCode"]) ? $_GET["userCode"] : "";
//print_r($userCode);
$stmt = $obj->getData($userCode);
$num = $stmt->rowCount();
if($num>0){
		$objArr=array();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
				$objItem=array(
					"id"=>$id,
					"userCode"=>$userCode,
					"fullName"=>$fullName,
					"description"=>$description,
					"createDate"=>$createDate,
					"progressStatus"=>$progressStatus,
					"requestType"=>$requestType,
				);
				array_push($objArr, $objItem);
			}
			echo json_encode($objArr);
}
else{
			echo json_encode(array("message" => false));
}
?>