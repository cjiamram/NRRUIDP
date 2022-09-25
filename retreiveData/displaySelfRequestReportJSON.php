<?php
header("content-type:html/text;charset=UTF-8");

	include_once "../objects/manage.php";
	include_once "../objects/classLabel.php";
	include_once "../config/database.php";
	include_once "../objects/data.php";


	$database = new Database();
	$db = $database->getConnection();
	$objLbl = new ClassLabel($db);
	$obj=new Data($db);

	//$cnf=new Config();
	//$api=new ClassAPI();
	$userCode=isset($_GET["userCode"])?$_GET["userCode"]:"";
	$yearPlan=isset($_GET["yearPlan"])?$_GET["yearPlan"]:"";
	//$path="retreiveData/getSelfRequestReport.php?userCode=".$userCode."&yearPlan=".$yearPlan;

	$stmt=$obj->getSelfRequestReport($userCode,$yearPlan);
	$data=array();
	if($stmt->rowCount()>0){
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			$status="";
			switch(intval($isAprove)){
				case 0:
					$status="รออนุมัติ";
					break;
				case 1:
					$status="อนุมัติ";
					break;
				case 2:
					$status="ไม่อนุมัติ";
					break;
				default:
					$status="รออนุมัติ";

			}

			$objItem=array(
				"id"=>$id,
				"pType"=>$pType,
				"pTypeCode"=>$pTypeCode,
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
			echo "<th>".$objLbl->getLabel("t_mgmreport","pType","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_mgmreport","topic","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_mgmreport","budget","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_mgmreport","createDate","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_mgmreport","yearPlan","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_mgmreport","status","TH")."</th>";

		echo "</tr>";
	echo "</thead>";
	if(count($data)>0){
		echo "<tbody>\n";
		$i=1;
		foreach ($data as $row) {
			echo "<tr>\n";
			echo "<td>".$i++."</td>\n";
			echo "<td>".$row["pType"]."</td>\n";
			echo "<td>".$row["topic"]."</td>\n";
			echo "<td>".$row["budget"]."</td>\n";
			echo "<td>".Format::getTextDate($row["createDate"])."</td>\n";
			echo "<td>".$row["yearPlan"]."</td>\n";
			echo "<td>".$row["status"]."</td>\n";

			
			echo "</tr>\n";
		}
		echo "</tbody>\n";
	}

?>
<script type="text/javascript">
	setTablePage("#tblDisplay");
</script>

