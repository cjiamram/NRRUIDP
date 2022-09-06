<?php
header("content-type:application/json;charset=UTF-8");
include_once "../config/database.php";
include_once "../objects/tspecialize.php";

$database=new Database();
$db=$database->getConnection();
$obj=new tspecialize($db);
$levelNo=isset($_GET["levelNo"])?$_GET["levelNo"]:0;
$parent=isset($_GET["parent"])?$_GET["parent"]:"";
$groupType=isset($_GET["groupType"])?$_GET["groupType"]:2;
$stmt=$obj->listTree($levelNo,$parent,$groupType);
if($stmt->rowCount()>0){
	$objArr=array();
	while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
		extract($row);
		$objItem=array("id"=>$id,
			"code"=>$code,
			"specialize"=>$specialize,
			"parent"=>$parent,
			"levelNo"=>$levelNo,
			"orderNo"=>$orderNo,
			"enable"=>intval($enable)
			);
		array_push($objArr,$objItem);
	}
	echo json_encode($objArr);
}else{
	echo json_encode(array("message"=>false));
}


?>