<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once "../config/database.php";
include_once "../objects/trequest.php";
include_once "../objects/manage.php";
$database = new Database();
$db = $database->getConnection();
$obj = new trequest($db);
$data = json_decode(file_get_contents("php://input"));
$obj->id = isset($_GET['id']) ? $_GET['id'] : 0;
$stmt=$obj->readOne();
$num=$stmt->rowCount();
if($num>0){
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		extract($row);
		$item = array(
			"id"=>$id,
			"userCode" =>  $userCode,
			"fullName" =>  $fullName,
			"description" =>  $description,
			"createDate" =>   Format::getSystemDate($createDate),
			"progressStatus" =>  $progressStatus,
			"requestType" =>  $requestType
		);
}
echo(json_encode($item));
?>