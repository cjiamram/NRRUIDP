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
$objLbl = new ClassLabel($db);
$objT=new tupposition($db);
$cnf=new Config();
$userCode=isset($_GET["userCode"])?$_GET["userCode"]:"";
$path="tupposition/getData.php?userCode=".$userCode;
$url=$cnf->restURL.$path;
$api=new ClassAPI();
$data=$api->getAPI($url);
echo "<thead>";
		echo "<tr>";
			echo "<th>No.</th>";
			echo "<th>".$objLbl->getLabel("t_upposition","expertType","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_upposition","yearPlan","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_upposition","isAprove","TH")."</th>";

			echo "<th width=\"150px\">จัดการ</th>";
		echo "</tr>";
echo "</thead>";
if(!isset($data["message"])){
echo "<tbody>";
$i=1;
foreach ($data as $row) {
		echo "<tr>";
			echo '<td>'.$row['id'].'</td>';
			if($row["isAprove"]===0){
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
			if($row["isAprove"]===1){
				$str="
						<div class='col-sm-12'><button type='button' class='btn btn-info'
						onclick='loadStatus(".$row['id'].")'>
						<span class='fa fa-flag'></span>
						</button></div>";
			}else{
				$str="<div class=\"col-sm-12\">".$row["expertType"]."</div><div class=\"col-sm-2\">
				</div>";
			}

			$strT=$objT->getAproveLog(intval($row['id']));

			echo '<td>'.$row["expertType"].'</td>';
			echo '<td>'.$row["yearPlan"].'</td>';
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
