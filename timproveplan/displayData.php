<?php
include_once "../config/config.php";
include_once "../lib/classAPI.php";
include_once "../config/database.php";
include_once "../objects/classLabel.php";
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
$database = new Database();
$db = $database->getConnection();
$objLbl = new ClassLabel($db);
$cnf=new Config();
$keyword=isset($_GET["keyWord"])?$_GET["keyWord"]:"";
$path="timproveplan/getData.php?keyWord=".$keyword;
$url=$cnf->restURL.$path;
$api=new ClassAPI();
$data=$api->getAPI($url);
echo "<thead>";
		echo "<tr>";
			echo "<th>No.</th>";
			echo "<th>".$objLbl->getLabel("t_improveplan","staffCode","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_improveplan","topic","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_improveplan","improvementType","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_improveplan","yearPlan","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_improveplan","description","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_improveplan","academicYear","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_improveplan","budget","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_improveplan","sourceDepartment","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_improveplan","sourceType","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_improveplan","duration","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_improveplan","monthPlan","TH")."</th>";
			echo "<th>จัดการ</th>";
		echo "</tr>";
echo "</thead>";
if($data!=""){
echo "<tbody>";
$i=1;
foreach ($data as $row) {
		echo "<tr>";
			echo '<td>'.$i++.'</td>';
			echo '<td>'.$row["staffCode"].'</td>';
			echo '<td>'.$row["topic"].'</td>';
			echo '<td>'.$row["improvementType"].'</td>';
			echo '<td>'.$row["yearPlan"].'</td>';
			echo '<td>'.$row["description"].'</td>';
			echo '<td>'.$row["academicYear"].'</td>';
			echo '<td>'.$row["budget"].'</td>';
			echo '<td>'.$row["sourceDepartment"].'</td>';
			echo '<td>'.$row["sourceType"].'</td>';
			echo '<td>'.$row["duration"].'</td>';
			echo '<td>'.$row["monthPlan"].'</td>';
			echo "<td>
			<button type='button' class='btn btn-info'
				data-toggle='modal' data-target='#modal-input'
				onclick='readOne(".$row['id'].")'>
				<span class='fa fa-edit'></span>
			</button>
			<button type='button'
				class='btn btn-danger'
				onclick='confirmDelete(".$row['id'].")'>
				<span class='fa fa-trash'></span>
			</button></td>";
			echo "</tr>";
}
echo "</tbody>";
}
?>
