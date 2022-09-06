<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once "../config/database.php";
include_once "../objects/timproveplan.php";
$database = new Database();
$db = $database->getConnection();
$obj = new timproveplan($db);
$data = json_decode(file_get_contents("php://input"));
$obj->staffCode = $data->staffCode;
$obj->topic = $data->topic;
$obj->improvementType = $data->improvementType;
$obj->yearPlan = $data->yearPlan;
$obj->description = $data->description;
$obj->academicYear = $data->academicYear;
$obj->budget = $data->budget;
$obj->sourceDepartment = $data->sourceDepartment;
$obj->sourceType = $data->sourceType;
$obj->duration = $data->duration;
$obj->monthPlan = $data->monthPlan;
if($obj->create()){
		echo json_encode(array('message'=>true));
}
else{
		echo json_encode(array('message'=>false));
}
?>