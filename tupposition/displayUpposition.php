<?php
include_once "../config/config.php";
include_once "../lib/classAPI.php";
include_once "../config/database.php";
include_once "../objects/classLabel.php";
include_once "../objects/manage.php";
include_once "../objects/tupposition.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: html/text; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
$database = new Database();
$db = $database->getConnection();
$objT=new tupposition($db);

$objLbl = new ClassLabel($db);
$cnf=new Config();
$userCode=isset($_GET["userCode"])?$_GET["userCode"]:"";
$path="tupposition/getData.php?userCode=".$userCode;
$url=$cnf->restURL.$path;
//print_r($url);
$api=new ClassAPI();
$data=$api->getAPI($url);
echo "<thead>";
		echo "<tr>";
			echo "<th>No.</th>";
			echo "<th>".$objLbl->getLabel("t_upposition","expertType","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_upposition","yearPlan","TH")."</th>";
			//echo "<th>".$objLbl->getLabel("t_upposition","description","TH")."</th>";
			//echo "<th>".$objLbl->getLabel("t_upposition","createDate","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_upposition","isAprove","TH")."</th>";

			echo "<th width=\"200px\">จัดการ</th>";
		echo "</tr>";
echo "</thead>";
if(!isset($data["message"])){
echo "<tbody>";
$i=1;
foreach ($data as $row) {
		echo "<tr>";
			echo '<td>'.$i++.'</td>';
			print_r($row["isAprove"]);
			if(intval($row["isAprove"])==0){
			


			$str="<div class=\"col-sm-12\">
				
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
			else
			if(intval($row["isAprove"])==1){
				$str="
						<div class='col-sm-12'>
						<button type='button' class='btn btn-success'
						onclick='readOneView(".$row['id'].")'>
						<span class='fa fa-eye'></span>
						</button>
						<button type='button' class='btn btn-warning'
						onclick='loadStatus(".$row['id'].")'>
						<span class='fa fa-flag'></span>
						</button></div>";
			}else{
				$str="<div class=\"col-sm-12\">
				<button type='button' class='btn btn-success'
				onclick='readOneView(".$row['id'].")'>
				<span class='fa fa-eye'></span>
				</button></div>";
			}
			echo '<td>'.$row["expertType"].'</td>';
			echo '<td>'.$row["yearPlan"].'</td>';
			//$strT=$objT->getAproveStatus(intval($row['id']));
			$strT=$objT->getAproveLog(intval($row['id']));

			//echo '<td>'.$row["description"].'</td>';
			//echo '<td>'.Format::getTextDate($row["createDate"]).'</td>';
			echo '<td>'.$strT.'</td>';
			echo '<td>'.$str.'</td>';

			
			echo "</tr>";
}
echo "</tbody>";
}
?>

<script>
		setTablePage("#tblDisplay",20);
</script>
