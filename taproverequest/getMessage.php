<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once "../config/database.php";
include_once "../objects/taproverequest.php";
$database = new Database();
$db = $database->getConnection();
$obj = new taproverequest($db);
$data = json_decode(file_get_contents("php://input"));
$requestId = isset($_GET['requestId']) ? $_GET['requestId'] : 12;
$pType = isset($_GET['pType']) ? $_GET['pType'] : 5;

$stmt=$obj->getMessage($requestId,$pType);
$num=$stmt->rowCount();
 
if($num>0){
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		extract($row);
		$item = array(
			
			"messageAprove" =>  $message
		);
		echo(json_encode($item));

}else 
	echo json_encode(array("message"=>false));
?>