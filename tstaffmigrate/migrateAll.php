<?php
	ini_set('memory_limit', '-1');
	require_once("../lib/nusoap.php");
	header("content-type:application/json;charset=UTF-8");
	include_once "../config/database.php";
	include_once "../objects/tstaffmigrate.php";
	include_once "../objects/tdepartment.php";

	$database=new Database();
	$db=$database->getConnection();
	$objDep=new tdepartment($db);
	$objStaff=new tstaffmigrate($db);

	$stmt=$objDep->getData();
	$cnt=$stmt->rowCount();
	//print_r($cnt);
	$n=1;
	$flag=true;
	if($stmt->rowCount()>0){
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			//$depCode=$departmentCode;
			$client = new nusoap_client("http://entrance.nrru.ac.th/nrruwebservice/nrruWebService_getStaffByDepartmentcode.php?wsdl",true); 
			$params = array(
				'departmentcode' => $departmentId
			);
			$data = $client->call("getDepartmentCode",$params);
			$objArr=json_decode($data,true);
			//print_r($departmentId."\n");
			if($data!==""){
				
				
				foreach ($objArr as $row) {
					
					$objs=explode(" ",$row["stafffullnameeng"]);
					$userCode=$row["usercode"];
					$objStaff->staffCode=$row["staffcode"];
					$objStaff->userCode=$userCode;
					$objStaff->stafffullname=$row["stafffullname"];
					$objStaff->stafffullnameeng=$row["stafffullnameeng"];
					$objStaff->departmentcode=$row["departmentcode1"];
					$objStaff->departmentcode1=$row["departmentcode"];
					$flag=$objStaff->create();


				

					$n++;

					//print_r($flag);

				}
			} 
		

		}
	}

echo json_encode(array("flag"=>$flag,"cnt"=>$n));	

?>

