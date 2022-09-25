<?php
include_once "../config/database.php";
include_once "../objects/classLabel.php";
include_once "../objects/manage.php";
include_once "../objects/tresearch.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: html/text; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
$database = new Database();
$db = $database->getConnection();
$objLbl = new ClassLabel($db);
$objT=new tresearch($db);
$userCode=isset($_GET["userCode"])?$_GET["userCode"]:"";

$data=array();

$stmt = $objT->getData($userCode);
$num = $stmt->rowCount();

if($num>0){
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
				$objItem=array(
					"id"=>$id,
					"userCode"=>$userCode,
					"research"=>$research,
					"detail"=>$detail,
					"createDate"=>$createDate,
					"yearPlan"=>$yearPlan,
					"isAprove"=>$isAprove,
					"budget"=>$budget,
					"budgetType"=>$budgetType,
					"researchSource"=>$researchSource,
					"status"=>$status
				);
				array_push($data, $objItem);
			}
}



echo "<thead>";
		echo "<tr>";
			echo "<th>No.</th>";
			echo "<th>".$objLbl->getLabel("t_research","research","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_research","detail","TH")."</th>";
			echo "<th width='150px'>".$objLbl->getLabel("t_research","yearPlan","TH")."</th>";
			echo "<th width='150px'>".$objLbl->getLabel("t_research","researchSource","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_research","isAprove","TH")."</th>";
			echo "<th width=\"150px\">จัดการ</th>";

		echo "</tr>";
echo "</thead>";
if(count($data)>0){
echo "<tbody>";
$i=1;
foreach ($data as $row) {
		echo "<tr>\n";
			$isAprove =$objT->getLevelAprove(intval($row['id']));
			$str="";	

			if($isAprove===0 && intval($row["isAprove"])===0){
							$str="<div class='col-sm-12'>
									<button type='button' class='btn btn-info'
									onclick='readOne(".$row['id'].")'>
									<span class='fa fa-edit'></span>
									</button>
									<button type='button'
									class='btn btn-danger'
									onclick='confirmDelete(".$row['id'].")'>
									<span class='fa fa-trash'></span>
									</button></div>";
						}
						if($isAprove===1 && intval($row["isAprove"])===1){
							$str="<div class='col-sm-12'><button type='button' class='btn btn-success'
									onclick='readOneView(".$row['id'].")'>
									<span class='fa fa-eye'></span></div>";	
						}

						else
					
						
						if($isAprove>=2&& intval($row["isAprove"])>=1){
							$str="<div class='col-sm-12'>
							<button type='button' class='btn btn-success'
							onclick='readOneView(".$row['id'].")'>
							<span class='fa fa-eye'></span>
							<button type='button' class='btn btn-warning'
							onclick='loadStatus(".$row['id'].")'>
							<span class='fa fa-flag'></span>
							</button></div>";
						}

						else
						if(intval($row["isAprove"])===2)

						{
							$str="<div class='col-sm-12'>
									
									<button type='button'
									class='btn btn-danger'
									onclick='confirmDelete(".$row['id'].")'>
									<span class='fa fa-trash'></span>
									</button></div>";
						}

			echo '<td>'.$i++.'</td>'."\n";
			echo '<td>'.$row["research"].'</td>'."\n";
			echo '<td>'.$row["detail"].'</td>'."\n";
			echo '<td>'.$row["yearPlan"].'</td>'."\n";
			echo '<td>'.$row["researchSource"].'</td>'."\n";
			$strT=$objT->getAproveLog(intval($row['id']));
			echo '<td>'.$strT.'</td>'."\n";
			echo '<td>'.$str.'</td>'."\n";
			echo "</tr>\n";
}
echo "</tbody>\n";
}
?>
<script>
		setTablePage("#tblDisplay",20);
</script>
