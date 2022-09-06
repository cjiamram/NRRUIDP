<?php
	header ("Content-Type: application/json; charset=utf-8");

	session_start();	
	require_once("../lib/nusoap.php");

	$data = json_decode(file_get_contents("php://input"));
	$userCode=$data->userName;
	//print_r($userCode);

	$client = new nusoap_client("http://entrance.nrru.ac.th/nrruwebservice/nrruWebService_userLogin.php?wsdl",true);
	$params = array(
		'userlogin' => $data->userName,
		'password' => $data->password
	);

	//print_r($params);
	$data = $client->call("getUserLogin",$params); 
	$user = json_decode($data,true);
	//print_r($user);

	if($user[0]["status"]==1){
			foreach ($user as $row) {
					$_SESSION["UserCode"]=$userCode;
					$_SESSION["UserName"]=$row["username"];
					$_SESSION["FullName"]=$row["firstname"].' '.$row["lastname"]  ;
					$_SESSION["Picture"]=$row["picture"];
					$_SESSION["DepartmentId"]=$row["departmentid"];
					echo json_encode(array("UserCode"=>$row["username"],"message"=>true)) ;

				}
	}else
	echo json_encode(array("message"=>false));


	
?>