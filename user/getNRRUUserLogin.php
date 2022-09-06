<?php
	//session_start();
	header ("Content-Type: application/json; charset=utf-8");
	//include_once "../config/config.php";
	//include_once "../config/database.php";
	//include_once "../objects/tteacher.php";
	require_once("../lib/nusoap.php");

	//$database=new Database();
	//$db=$database->getConnection();
	//$obj=new tteacher($db);

	
	//$program=$obj->getProgram($data["userName"]);
	//$_SESSION["program"]=$program;
	$data = json_decode(file_get_contents("php://input"));

	$client = new nusoap_client("http://entrance.nrru.ac.th/nrruwebservice/nrruWebService_userLogin.php?wsdl",true);
	$params = array(
		'userlogin' => $data["userName"],
		'password' => $data["password"]
	);
	$data = $client->call("getUserLogin",$params); 
	$student = json_decode($data,true);

?>