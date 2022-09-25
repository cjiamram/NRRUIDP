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

if(!isset($data["message"])){
echo "<tbody>";
$i=1;

foreach ($data as $row) {
		$strT="<div class=\"col-sm-10\">\n";
		
		$strT.= "<div class=\"col-sm-2\"><label>".$objLbl->getLabel("t_academicplan","educationPlan","TH")."</label></div>\n";
		$strT.= "<div class=\"col-sm-10\">".$row["educationPlan"]."</div>\n";
		
		$strT.= "<div class=\"col-sm-2\"><label>".$objLbl->getLabel("t_academicplan","degree","TH")."/".$objLbl->getLabel("t_academicplan","eduCertificate","TH")."</label></div>\n";
		$strT.= "<div class=\"col-sm-10\">".$row["degree"]."/".$row["eduCertificate"]."</div>\n";

		$strT.= "</div>\n";


		$strT.= "<div class=\"col-sm-2\">
				<button type='button' class='btn btn-info'
				onclick='readOne(".$row['id'].")'>
				<span class='fa fa-edit'></span>
				</button>
				<button type='button'
				class='btn btn-danger'
				onclick='confirmDelete(".$row['id'].")'>
				<span class='fa fa-trash'></span>
				</button>
				</div>";

		echo "<td>".$strT."</td>\n";
	
		echo "</tr>";
}
echo "</tbody>";
}
?>

<script>
	//setTablePage("#tblDisplay");

</script>
