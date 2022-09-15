<?php
	header("content-type:text/html;charset=UTF-8");
	include_once "../config/config.php";
	include_once "../lib/classAPI.php";
	$cnf=new Config();
	$api=new ClassAPI();
	$id=isset($_GET["id"]:0;)?$_GET["id"]:0;
	$url=$cnf->restURL."tacademicplan/getAproveLog.php?id=".$id;
	$data=$api->getAPI($url);
	if(!isset($data["message"])){
		echo "<table width='100%' style='width:100%;border:1px solid;'>\n";
		$i=1;
		foreach ($data => $row) {
			# code...
			echo "<tr>\n";
			echo "<td width='50px'>".$i++."</td>\n";
			echo "<td>".$row["status"]."</td>\n";
			echo "<td>".$row["levelStatus"]."</td>\n";
			echo "<td>".$row["fullName"]."</td>\n";
			echo "</tr>\n";

		}
		echo "</table>\n";

	}
?>


