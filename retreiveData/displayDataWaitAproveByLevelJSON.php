<?php
	header("content-type:text/html;charset=UTF-8");

	include_once "../objects/manage.php";
	include_once "../objects/classLabel.php";
	include_once "../config/database.php";
	include_once "../objects/data.php";
	
	//session_start();
	$database = new Database();
	$db = $database->getConnection();
	$objLbl = new ClassLabel($db);
	$obj=new Data($db);

	$userCode=isset($_GET["userCode"])?$_GET["userCode"]:"";
	$keyWord=isset($_GET["keyWord"])?$_GET["keyWord"]:"";
	$data=array();
	$stmt=$obj->getWaitAproveByLevel($userCode,$keyWord);
	if($stmt->rowCount()>0){
			while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			$status="";
			switch($planStatus){
				case 0:
					$status="รออนุมัติ";
					break;
				case 1:
					$status="อนุมัติ";
					break;
				case 2:
					$status="ไม่อนุมัติ";
					break;
				case 3:
					$status="สำเร็จ";
				case 5:
					$status="ไม่สำเร็จ";
					break;
				default:
					$status="รออนุมัติ";
			}

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
				"status"=>$status,
				"planStatus"=>$planStatus,
				"levelStatus"=>$levelStatus
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
			echo "<th>".$objLbl->getLabel("t_mgmreport","createDate","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_mgmreport","yearPlan","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_mgmreport","status","TH")."</th>";

			echo "<th>จัดการ</th>";
		echo "</tr>";
	echo "</thead>";
	if(count($data)>0){
		echo "<tbody>\n";
		$i=1;
		foreach ($data as $row) {
			echo "<tr>\n";
			echo "<td>".$i++."</td>\n";
			echo "<td>".$row["fullName"]."</td>\n";
			echo "<td>".$row["pType"]."</td>\n";
			echo "<td>".$row["topic"]."</td>\n";
			echo "<td>".$row["budget"]."</td>\n";
			echo "<td>".Format::getTextDate($row["createDate"])."</td>\n";
			echo "<td>".$row["yearPlan"]."</td>\n";
			echo "<td>".$row["status"]."</td>\n";

			if(intval($row["planStatus"])==0|| intval($row["levelStatus"])<=2){
			echo "<td>
				<button type='button' class='btn btn-info'
					onclick=\"setAprove(".$row["id"].",".$row["pTypeCode"].",'".$row["userCode"]."','".$row["fullName"]."','".$userCode."',".$row["levelStatus"].")\">
					<span class='fa fa-handshake-o'></span>
				</button></td>";
			}else{
				echo "<td>ดำเนินการเรีบยบร้อยแล้ว</td>\n";
			}
			echo "</tr>\n";
		}
		echo "</tbody>\n";
	}

?>
<script type="text/javascript">
	setTablePage("#tblDisplay",20);
</script>