<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");

	$data = json_decode(file_get_contents("php://input"));

	rename($data->oldFileUrl,$data->newFileName);

?>