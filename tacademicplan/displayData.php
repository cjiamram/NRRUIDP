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

$userCode=isset($_GET["userCode"])?$_GET["userCode"]:"";

$database = new Database();
$db = $database->getConnection();
$objLbl = new ClassLabel($db);
$cnf=new Config();
$path="tacademicplan/getData.php?userCode=".$userCode;
//print_r($userCode);
$url=$cnf->restURL.$path;

//print_r($url);
$api=new ClassAPI();
$data=$api->getAPI($url);
echo "<thead>";
		echo "<tr>";
			echo "<th>No.</th>";
			echo "<th>".$objLbl->getLabel("t_academicplan","educationPlan","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_academicplan","degree","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_academicplan","yearPlan","TH")."/".$objLbl->getLabel("t_academicplan","budget","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_academicplan","university","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_academicplan","isAprove","TH")."</th>";
			echo "<th width=\"200px\">จัดการ</th>";

		echo "</tr>";
echo "</thead>";
if(!isset($data["message"])){
echo "<tbody>";
$i=1;

foreach ($data as $row) {
		echo "<tr>";
			echo '<td>'.$i++.'</td>';
			//print_r($row["isAprove"]);
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
			</button></div>";}
			else
			if(intval($row["isAprove"])==1){
				$str="
				<div class='col-sm-12'><button type='button' class='btn btn-success'
				onclick='readOneView(".$row['id'].")'>
				<span class='fa fa-eye'></span>
				<button type='button' class='btn btn-warning'
				onclick='loadStatus(".$row['id'].")'>
				<span class='fa fa-flag'></span>
				</button></div>";
			}else{
				$str="<div class='col-sm-12'><button type='button' class='btn btn-success'
				onclick='readOneView(".$row['id'].")'>
				<span class='fa fa-eye'></span></div>";
			}
			echo '<td><div class="col-sm-12">'.$row["educationPlan"].'</div></td>';
			echo '<td>'.$row["degree"].'</td>';
			echo '<td>'.$row["yearPlan"]."/".number_format($row["budget"],2).'</td>';
			//echo '<td>'.$row["sourceType"]."/".$row["fundSource"].'</td>';
			echo '<td>'.$row["university"].'</td>';
			//echo '<td>'.$row["eduType"].'</td>';
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
