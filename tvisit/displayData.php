<?php
include_once "../config/config.php";
include_once "../lib/classAPI.php";
include_once "../config/database.php";
include_once "../objects/classLabel.php";
header("Access-Control-Allow-Origin: *");
header("Content-Type: html/text; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
$database = new Database();
$db = $database->getConnection();
$objLbl = new ClassLabel($db);
$cnf=new Config();
$userCode=isset($_GET["userCode"])?$_GET["userCode"]:"";
$path="tvisit/getData.php?userCode=".$userCode;
$url=$cnf->restURL.$path;
$api=new ClassAPI();
$data=$api->getAPI($url);
echo "<thead>";
		echo "<tr>";
			echo "<th>No.</th>";
			echo "<th>".$objLbl->getLabel("t_visit","visitObjective","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_visit","projectDetail","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_visit","expectation","TH")."</th>";
			//echo "<th>".$objLbl->getLabel("t_visit","budget","TH")."</th>";
			//echo "<th>".$objLbl->getLabel("t_visit","joinGroup","TH")."</th>";
			//echo "<th>".$objLbl->getLabel("t_visit","plan","TH")."</th>";
			//echo "<th>".$objLbl->getLabel("t_visit","duration","TH")."(วัน)</th>";
			echo "<th>".$objLbl->getLabel("t_visit","isAprove","TH")."</th>";
			
			echo "<th width=\"200px\">จัดการ</th>";
		echo "</tr>";
echo "</thead>";
if(!isset($data["message"])){
echo "<tbody>";
$i=1;
foreach ($data as $row) {
		echo "<tr>";
			if(intval($row["isAprove"])==0){

			$str="<div class='col-sm-12'>
			
			<button type='button' class='btn btn-info'
				onclick='readOne(".$row['id'].")'>
				<span class='fa fa-edit'></span>
			</button>
			<button type='button'
				class='btn btn-danger'
				onclick='confirmDelete(".$row['id'].")'>
				<span class='fa fa-trash'></span>
			</button>
			</div>";}
			else
			if(intval($row["isAprove"])==1){
					$str="
						<div class='col-sm-12'>
						<button type='button' class='btn btn-success'
							onclick='readView(".$row['id'].")'>
							<span class='fa fa-eye'></span>
						</button>
						<button type='button' class='btn btn-warning'
						onclick='loadStatus(".$row['id'].")'>
						<span class='fa fa-flag'></span>
						</button></div>";
			}else{
				$str="<div class='col-sm-12'><button type='button' class='btn btn-success'
				onclick='readView(".$row['id'].")'>
				<span class='fa fa-eye'></span>
			</button></div>";
			}
			echo '<td>'.$i++.'</td>';
			echo '<td>'.$row["visitObjective"].'</td>';
			echo '<td>'.$row["projectDetail"].'</td>';
			echo '<td>'.$row["expectation"].'</td>';
			//echo '<td>'.$row["budget"].'</td>';
			//echo '<td>'.$row["joinGroup"].'</td>';
			//echo '<td>'.$row["monthPlan"]."/".$row["yearPlan"].'</td>';
			//echo '<td>'.$row["duration"].'</td>';
			echo '<td>'.$row["status"].'</td>';
			echo '<td>'.$str.'</td>';

			echo "</tr>";
}
echo "</tbody>";
}
?>

<script>
	setTablePage("#tblDisplay");
</script>
