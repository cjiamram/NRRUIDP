<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

<?php
	header('Content-Type: application/force-download');
	header('Content-disposition: attachment; filename=ReportPlan.xls');
	// Fix for crappy IE bug in download.
	header("Pragma: ");
	header("Cache-Control: ");
	date_default_timezone_set('Asia/Bangkok');

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
	$pType=isset($_GET["pType"])?$_GET["pType"]:"";
	$sYear=isset($_GET["sYear"])?$_GET["sYear"]:date("Y")+543;
    $fYear=isset($_GET["fYear"])?$_GET["fYear"]:date("Y")+548;
    $staffType=isset($_GET["staffType"])?$_GET["staffType"]:2;
	//$path="retreiveData/getDashBoardList.php?departmentId=".$departmentId."&pType=".$pType."&sYear=".$sYear."&fYear=".$fYear."&staffType=".$staffType;
	//$url=$cnf->restURL.$path;

	//$data=$api->getAPI($url);

    $data=array();
    $stmt=$obj->getDashboardList_1($departmentId,$pType,$sYear,$fYear,$staffType);

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
				"budget"=>$budget,
				"departmentName"=>$departmentName,
				"createDate"=>$createDate,
				"yearPlan"=>$yearPlan,
				"planStatus"=>$planStatus,
				"staffType"=>$staffGroup
				);
			array_push($data, $objItem);
		}

    }


	echo "<table class=\"table table-bordered table-hover\">\n";
	echo "<thead>";
		echo "<tr>";
			echo "<th>No.</th>";
			echo "<th>".$objLbl->getLabel("t_mgmreport","fullName","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_mgmreport","departmentName","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_mgmreport","pType","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_mgmreport","topic","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_mgmreport","budget","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_mgmreport","createDate","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_mgmreport","yearPlan","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_mgmreport","status","TH")."</th>";
			echo "<th>??????????????????</th>";

		echo "</tr>";
	echo "</thead>";
	if(count($data)>0){
		echo "<tbody>\n";
		$i=1;
		foreach ($data as $row) {
			echo "<tr>\n";
			echo "<td>".$i++."</td>\n";
			echo "<td>".$row["fullName"]."</td>\n";
			echo "<td>".$row["departmentName"]."</td>\n";
			echo "<td>".$row["pType"]."</td>\n";
			echo "<td>".$row["topic"]."</td>\n";
			echo "<td>".$row["budget"]."</td>\n";
			echo "<td>".Format::getTextDate($row["createDate"])."</td>\n";
			echo "<td>".$row["yearPlan"]."</td>\n";
			echo "<td>".$row["planStatus"]."</td>\n";
			echo "<td>".$row["staffType"]."</td>\n";
			echo "</tr>\n";
		}
		echo "</tbody>\n";
	}

	 echo "</table>\n";

?>

