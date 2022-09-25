<?php
	header("content-type:html/text;charset=UTF-8");

	//include_once "../config/config.php";
	//include_once "../lib/classAPI.php";
	include_once "../objects/manage.php";
	include_once "../objects/classLabel.php";
	include_once "../config/database.php";
	include_once "../objects/data.php";


	$database = new Database();
	$db = $database->getConnection();
	$objLbl = new ClassLabel($db);
	$obj=new Data($db);

	$departmentId=isset($_GET["departmentId"])?$_GET["departmentId"]:"";
	$keyWord=isset($_GET["keyWord"])?$_GET["keyWord"]:"";
	$yearNo=isset($_GET["yearNo"])?$_GET["yearNo"]:date("y")+543;
	$staffType=isset($_GET["staffType"])?$_GET["staffType"]:"";

	$data=array();
	$stmt=$obj->getAfterAprove($departmentId,$keyWord,$yearNo,$staffType);
	if($stmt->rowCount()>0){
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			$objItem=array(
				"id"=>$id,
				"pType"=>$pType,
				"pTypeCode"=>$pTypeCode,
				"userCode"=>$userCode,
				"fullName"=>$fullName,
				"topic"=>$Topic,
				"description"=>$description,
				"budget"=>$budget,
				"departmentId"=>$departmentId,
				"createDate"=>$createDate,
				"yearPlan"=>$yearPlan,
				"status"=>$status
				);
			array_push($data, $objItem);
		}
	}

	echo "<thead>";
		echo "<tr>";
			echo "<th>No.</th>";
			echo "<th>".$objLbl->getLabel("t_mgmreport","fullName","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_mgmreport","pType","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_mgmreport","topic","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_mgmreport","budget","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_mgmreport","status","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_mgmreport","createDate","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_mgmreport","yearPlan","TH")."</th>";
		echo "</tr>";
	echo "</thead>";
	if(count($data)>0){
		echo "<tbody>\n";
		$i=1;
		foreach ($data as $row) {
			echo "<tr>\n";
			echo "<td>".$i++."</td>\n";
			echo "<td><a href='#' onclick=\"getAproveMessage(".$row["id"].",".$row["pTypeCode"].")\">".$row["fullName"]."</a></td>\n";
			echo "<td>".$row["pType"]."</td>\n";
			echo "<td>".$row["topic"]."</td>\n";
			echo "<td>".$row["budget"]."</td>\n";
			echo "<td>".$row["status"]."</td>\n";
			echo "<td>".Format::getTextDate($row["createDate"])."</td>\n";
			echo "<td>".$row["yearPlan"]."</td>\n";
			
			echo "</tr>\n";
		}
		echo "</tbody>\n";
	}

?>