<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once "../config/database.php";
include_once "../objects/district.php";
$database = new Database();
$db = $database->getConnection();
$obj = new district($db);
$data = json_decode(file_get_contents("php://input"));
$obj->code = $data->code;
$obj->disName_Th = $data->disName_Th;
$obj->disName_En = $data->disName_En;
$obj->prv_Code = $data->prv_Code;
$obj->id = $data->id;
if($obj->update()){
		echo json_encode(array('message'=>true));
}
else{
		echo json_encode(array('message'=>false));
}
?>