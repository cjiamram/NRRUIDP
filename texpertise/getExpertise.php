<?php
header("content-type:html/text;charset=UTF-8");
include_once "../config/database.php";
include_once "../objects/texpertise.php";
$database=new Database();
$db=$database->getConnection();
$obj=new texpertise($db);
$userCode=isset($_GET["userCode"])?$_GET["userCode"]:"";
$specialize=$obj->getExpertise($userCode);
echo "<textarea id='obj_expertise' class='form-control'>".$specialize."</textarea>";

?>

<script>
	$(document).ready(function(){
		setTextEditor("#obj_expertise");
	});
</script>