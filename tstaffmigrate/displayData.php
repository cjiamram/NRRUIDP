<?php
	header("content-type:application/json;charset=UTF-8");
	include_once "../lib/classAPI.php";
	include_once "../config/config.php";
	include_once "../config/database.php";
	include_once "../objects/tunderevaluate.php";

	$database=new Database();
	$db=$database->getConnection();
	$obj1=new tunderevaluate($db);
	$cnf=new Config();
	$api=new ClassAPI();
	$departmentCode=isset($_GET["departmentCode"]) ? $_GET["departmentCode"] : "";
    $supervisorCode=isset($_GET["supervisorCode"]) ? $_GET["supervisorCode"] : "";

    $keyWord=isset($_GET["keyWord"]) ? $_GET["keyWord"] : "";

	$url=$cnf->restURL."tstaffmigrate/getData.php?departmentCode=".$departmentCode."&keyWord=".$keyWord	;
	//print_r($url);
	$data=$api->getAPI($url);

	//print_r($data);

	if(!isset($data["message"])){
		echo "<thead>\n";
		echo "<tr>\n";
			echo "<th colspan='2'>No.</th>\n";
			echo "<th>รหัสพนักงาน</th>\n";
			echo "<th>ชื่อ-สกุล(TH)</th>\n";
			echo "<th>ชื่อ-สกุล(EN)</th>\n";
			echo "<th>หน่วยงาน</th>\n";
			echo "<th>หน่วยงานย่อย</th>\n";
		echo "</tr>\n";
		echo "</thead>\n";
		echo "<tbody>\n";
		$i=1;
		foreach ($data as $row) {
			$objs=explode(" ",$row["stafffullnameeng"]);
			$userCode=$objs[0].".".substr($objs[1],0,1);
			echo "<tr>\n";
				echo "<input type='hidden' id='obj_id-".$i."' value='".$userCode."'>\n";
				
				if($obj1->isUserExistBySuper($userCode,$supervisorCode)===true)
						$strCheck="<input type='checkbox' checked onchange=\"saveUnder('".$userCode."',".$i.")\" id='obj_chk-".$i."'>\n";
				else
					    $strCheck="<input type='checkbox' onchange=\"saveUnder('".$userCode."',".$i.")\" id='obj_chk-".$i."'>\n";


				echo "<td>".$strCheck."</td>\n";
				echo "<td>".$i++."</td>\n";
				echo "<td>".$row["staffCode"]."</td>\n";
				echo "<td>".$row["stafffullname"]."</td>\n";
				echo "<td>".$row["stafffullnameeng"]."</td>\n";
				echo "<td>".$row["departmentcode"]."</td>\n";
				echo "<td>".$row["departmentcode1"]."</td>\n";
			echo "</tr>\n";
		}

		echo "</tbody>\n";
	}

?>

