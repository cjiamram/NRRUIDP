<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once "../config/database.php";
include_once "../objects/tresearch.php";
$database = new Database();
$db = $database->getConnection();
$obj = new tresearch($db);
$data = json_decode(file_get_contents("php://input"));
$obj->userCode = $data->userCode;
$obj->research = $data->research;
$obj->detail = $data->detail;
$obj->createDate = date("Y-m-d");
$obj->yearPlan = $data->yearPlan;
$obj->isAprove = 0;
$obj->budget=$data->budget;
$obj->budgetType=$data->budgetType;
$obj->researchSource=$data->researchSource;
$obj->departmentId=$data->departmentId;

if($obj->create()){
		echo json_encode(array('message'=>true));
}
else{
		echo json_encode(array('message'=>false));
}
?>