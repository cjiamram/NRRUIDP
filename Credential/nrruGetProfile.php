<?php
	require_once("lib/nusoap.php");
	header("Content-Type: application/json; charset=utf-8");
	$client = new nusoap_client("http://entrance.nrru.ac.th/nrruwebservice/nrruWebService_staffData.php?wsdl", true);
	
	$params = array(
	    'staffid' => $_GET["staffId"]
	);
	$data = $client->call("getStaffData", $params);
	//print_r($data);
	$staff = json_decode($data, true);
	//print_r($data);
	$objArr=array();
	foreach ($staff as $result) {

		$graduated=array();
		foreach ($result["other"] as $res) {
	        $objItem=array(
		        "degreelevel" => $res["degreelevel"],
		        "graduatedatetime" => $res["graduatedatetime"],
		        "degreename" => $res["degreename"],
		        "majorname" => $res["majorname"],
		        "universityname" => $res["universityname"],
		        "countryname" => $res["countryname"],
		        "eduiscedprogramid" => $res["eduiscedprogramid"],
		        "expertisefield" => $res["expertisefield"],
		        "teachiscedprogramid" => $res["teachiscedprogramid"]
	    	);
	    	array_push($graduated, $objItem);
    	}

		$profile=array(
				"status" => $result["status"],
				"staffcode" => $result["staffcode"],
				"staffname" => $result["staffname"],
				"staffsurname" => $result["staffsurname"],
				"prefixname" => $result["prefixname"],
				"staffnameeng" => $result["staffnameeng"],
				"staffsurnameeng" => $result["staffsurnameeng"],
				"staffsexname" => $result["staffsexname"],
				"stafftypename" => $result["stafftypename"],
				"staffstatus" => $result["staffstatusname"],
				"positionlevel" => $result["positionlevel"],
				"admintdate" => $result["admitdate"],
				"positionname" => $result["positionname"],
				"departmentid" => $result["departmentid"],
				"departmentname" => $result["departmentname"],
				"workdepartmentname" => $result["workdepartmentname"],
				"citizenid" => $result["citizenid"],
				"graduated"=>$graduated
			);
		array_push($objArr,$profile);
	}

	echo json_encode($objArr);
?>