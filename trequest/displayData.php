<?php
session_start();
include_once "../config/config.php";
include_once "../lib/classAPI.php";
include_once "../config/database.php";
include_once "../objects/classLabel.php";
include_once "../objects/manage.php";
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
$database = new Database();
$db = $database->getConnection();
$objLbl = new ClassLabel($db);
$cnf=new Config();
$userCode=isset($_SESSION["UserName"])?$_SESSION["UserName"]:"";
$path="trequest/getData.php?userCode=".$userCode;
$url=$cnf->restURL.$path;
$api=new ClassAPI();
$data=$api->getAPI($url);

echo "<thead>";
		echo "<tr>";
			echo "<th>No.</th>";
			//echo "<th>".$objLbl->getLabel("t_request","userCode","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_request","fullName","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_request","description","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_request","createDate","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_request","progressStatus","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_request","requestType","TH")."</th>";
			echo "<th>จัดการ</th>";
		echo "</tr>";
echo "</thead>";
if(!isset($data["message"])){
echo "<tbody>";
$i=1;
foreach ($data as $row) {
		echo "<tr>";
			echo '<td>'.$i++.'</td>';
			//echo '<td>'.$row["userCode"].'</td>';
			echo '<td>'.$row["fullName"].'</td>';
			echo '<td>'.$row["description"].'</td>';
			echo '<td>'.Format::getTextDate($row["createDate"]).'</td>';
			echo '<td>'.$row["progressStatus"].'</td>';
			echo '<td>'.$row["requestType"].'</td>';
			echo "<td>
			<button type='button' class='btn btn-info'
				onclick='readOne(".$row['id'].")'>
				<span class='fa fa-edit'></span>
			</button>
			<button type='button'
				class='btn btn-danger'
				onclick='confirmDelete(".$row['id'].")'>
				<span class='fa fa-trash'></span>
			</button>

			</td>";
			echo "</tr>";
}
echo "</tbody>";
}


?>
