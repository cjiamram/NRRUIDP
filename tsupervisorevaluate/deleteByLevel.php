<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once "../config/database.php";
include_once "../objects/tsupervisorevaluate.php";
$database = new Database();
$db = $database->getConnection();
$obj = new tsupervisorevaluate($db);
$data = json_decode(file_get_contents("php://input"));
$departmentCode = isset($_GET['departmentCode']) ? $_GET['departmentCode'] : "";
$levelEvaluate = isset($_GET['levelEvaluate']) ? $_GET['levelEvaluate'] : 0;

$flag=$obj->deleteByLevel($departmentCode,$levelEvaluate);
if($flag){
		echo json_encode(array("message"=>true));
}
else{
		echo json_encode(array("message"=>false));
}
?>