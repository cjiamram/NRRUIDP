<?php
    header("Content-Type: application/json; charset=UTF-8");

	require_once("lib/nusoap.php");
	$data = json_decode(file_get_contents("php://input"));
	//print_r($data);
	$client = new nusoap_client("http://entrance.nrru.ac.th/nrruwebservice/nrruWebService_userLogin.php?wsdl",true);
	//$client = new nusoap_client("http://192.168.161.26/nrruwebservice/nrruWebService_userLogin.php?wsdl",true);
	
	//print_r($data);
	$params = array(
		'userlogin' => "chatchai.j",
		'password' => "chatchai.j"
	);


	$data = $client->call("getUserLogin",$params); 
	echo  $data;

?>