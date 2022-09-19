<?php
include_once "../config/config.php";
include_once "../lib/classAPI.php";
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
$cnf=new Config();
$userCode=isset($_GET["userCode"])?$_GET["userCode"]:"";
$path="tresearch/getData.php?userCode=".$userCode;
$url=$cnf->restURL.$path;
$api=new ClassAPI();
$data=$api->getAPI($url);
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
if(!isset($data["message"])){
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
