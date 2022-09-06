<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once "../config/database.php";
include_once "../objects/tsemina.php";
$database = new Database();
$db = $database->getConnection();
$obj = new tsemina($db);
$data = json_decode(file_get_contents("php://input"));
//$obj->id = $data->id;
//$obj->isAprove = $data->isAprove;


if($obj->setAprove($data->id,$data->isAprove)){
		echo json_encode(array('message'=>true));
}
else{
		echo json_encode(array('message'=>false));
}
?>