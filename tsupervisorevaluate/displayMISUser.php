<?php
	header("content-type:application/json;charset=UTF-8");
	include_once "../lib/classAPI.php";
	include_once "../config/config.php";

	$cnf=new Config();
	$api=new ClassAPI();

	$departmentCode=isset($_GET["departmentCode"])?$_GET["departmentCode"]:"";
	$url=$cnf->restURL."/tsupervisorevaluate/getMISUser.php?departmentCode=".$departmentCode;
	$data=$api->getAPI($url);


	if($data!=""){
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
				$strCheck="<input type='checkbox' id='obj_chk-".$i."'>\n";
				echo "<td>".$strCheck."</td>\n";
				echo "<td>".$i++."</td>\n";
				echo "<td>".$row["staffcode"]."</td>\n";
				echo "<td>".$row["stafffullname"]."</td>\n";
				echo "<td>".$row["stafffullnameeng"]."</td>\n";
				echo "<td>".$row["departmentcode"]."</td>\n";
				echo "<td>".$row["departmentcode1"]."</td>\n";
			echo "</tr>\n";
		}

		echo "</tbody>\n";
	}
?>

<script>
	setTablePage("#tblDisplay","20");

</script>