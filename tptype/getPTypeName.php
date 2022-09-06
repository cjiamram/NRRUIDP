<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once "../config/database.php";
include_once "../objects/tptype.php";
$database = new Database();
$db = $database->getConnection();
$obj = new tptype($db);
$code = isset($_GET['code']) ? $_GET['code'] : 0;
$stmt=$obj->getPTypeName($code);
$num=$stmt->rowCount();
if($num>0){
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		extract($row);
		$item = array(

			"pType" =>  $pType
		);
}
echo(json_encode($item));
?>