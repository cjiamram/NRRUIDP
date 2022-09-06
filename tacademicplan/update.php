<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once "../config/database.php";
include_once "../objects/tacademicplan.php";
$database = new Database();
$db = $database->getConnection();
$obj = new tacademicplan($db);
$data = json_decode(file_get_contents("php://input"));
$obj->userCode = $data->userCode;
$obj->educationPlan = $data->educationPlan;
$obj->degree = $data->degree;
$obj->eduCertificate = $data->eduCertificate;
$obj->budget = $data->budget;
$obj->yearPlan = $data->yearPlan;
$obj->fundSource = $data->fundSource;
$obj->sourceType = $data->sourceType;
$obj->createDate = date("Y-m-d");
$obj->isAprove = 0;
$obj->university = $data->university;
$obj->description = $data->description;
$obj->placeType = $data->placeType;
$obj->departmentId=$data->departmentId;
$obj->duration=$data->duration;
$obj->eduType=$data->eduType;

$obj->id = $data->id;
if($obj->update()){
		echo json_encode(array('message'=>true));
}
else{
		echo json_encode(array('message'=>false));
}
?>