<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once "../config/database.php";
include_once "../objects/tvisit.php";
$database = new Database();
$db = $database->getConnection();
$obj = new tvisit($db);
$data = json_decode(file_get_contents("php://input"));
$obj->userCode = $data->userCode;
$obj->visitObjective = $data->visitObjective;
$obj->projectDetail = $data->projectDetail;
$obj->expectation = $data->expectation;
$obj->budget = $data->budget;
$obj->joinGroup = $data->joinGroup;
$obj->yearPlan = $data->yearPlan;
$obj->createDate =date("Y-m-d");
$obj->duration = $data->duration;
$obj->monthPlan = $data->monthPlan;
$obj->isAprove = 0;
$obj->visitSite=$data->visitSite;
$obj->departmentId=$data->departmentId;

$obj->id = $data->id;
if($obj->update()){
		echo json_encode(array('message'=>true));
}
else{
		echo json_encode(array('message'=>false));
}
?>