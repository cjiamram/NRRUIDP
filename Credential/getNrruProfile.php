<?php
	require_once("lib/nusoap.php");
	header("Content-Type: application/json; charset=utf-8");
	$client = new nusoap_client("http://entrance.nrru.ac.th/nrruwebservice/nrruWebService_staffData.php?wsdl", true);
	
	$params = array(
	    'staffid' => $_GET["staffId"]
	);
	$data = $client->call("getStaffData", $params);
	$staff = json_decode($data, true);
	$objArr=array();
	foreach ($staff as $result) {

		$client_1 = new nusoap_client("http://entrance.nrru.ac.th/nrruwebservice/nrruWebService_tqf_staff.php?wsdl",true); 


		$graduated=array();
		$data_1 = $client_1->call("getStaffData",$params); 
		$staff_1 = json_decode($data_1,true);
		foreach ($staff_1 as $result_1){
				foreach($result_1["degree"] as $res){

					 $objItem=array(
			        "degreelevel" => $res["degreelevelname"],
			        "graduatedatetime" => $res["graduatedatetime"],
			        "degreename" => $res["degreelevelname"],
			        "majorname" => $res["majorname"],
			        "universityname" => $res["universityname"],
			        "countryname" => "THAILAND"
			        
			      
		    	);
		    	array_push($graduated, $objItem);
				
			}

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

    /*$client_1 = new nusoap_client("http://entrance.nrru.ac.th/nrruwebservice/nrruWebService_tqf_staff.php?wsdl",true); 
	$params = array(
		'staffid' => $_GET["staffId"]
	);*/




	echo json_encode($objArr);
?>