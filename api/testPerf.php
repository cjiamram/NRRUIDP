<?php
	session_start();	
	require_once("../lib/nusoap.php");
	header ("Content-Type: application/json; charset=utf-8");

	$data = json_decode(file_get_contents("php://input"));
	$userCode=$data->userName;
	//print_r($userCode);

	$client = new nusoap_client("http://entrance.nrru.ac.th/nrruwebservice/nrruWebService_userLogin.php?wsdl",true);
	$params = array(
		'userlogin' => "chatchai.j",
		'password' => "chatchai.j"
	);

	//print_r($params);
	$data = $client->call("getUserLogin",$params); 
	$user = json_decode($data,true);
	//print_r($user[0]);

	if($user[0]["status"]==1){
			foreach ($user as $row) {
					$_SESSION["UserCode"]=$userCode;
					$_SESSION["UserName"]=$row["username"];
					$_SESSION["FullName"]=$row["firstname"].' '.$row["lastname"]  ;
					$_SESSION["Picture"]=$row["picture"];
					$_SESSION["DepartmentId"]=$row["departmentid"];
					$_SESSION["facultyCode"]=$row["faculty"];
					echo json_encode(array("UserCode"=>$row["username"],"message"=>true)) ;

				}
	}else
	echo json_encode(array("message"=>false));


	
?>