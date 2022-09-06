<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once "../config/database.php";
include_once "../objects/tsupervisor.php";
include_once "../objects/classLabel.php";
include_once "../config/config.php";
$database = new Database();
$db = $database->getConnection();
$objLbl = new ClassLabel($db);
$cnf=new Config();
$rootPath=$cnf->path;
?>
<form role='form'>
<div class="box-body">
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_supervisor","userCode","th").":" ?></label>
			<div class="col-sm-12">
				<input type="text" 
							class="form-control" id='obj_userCode' 
							placeholder='userCode'>
			</div>
		</div>
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_supervisor","departmentId","th").":" ?></label>
			<div class="col-sm-12">
				<!--<input type="text" 
							class="form-control" id='obj_departmentId' 
							placeholder='departmentId'>-->
				<select class="form-control" id="obj_departmentId"></select>
			</div>
		</div>
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_supervisor","fullName","th").":" ?></label>
			<div class="col-sm-12">
				<input type="text" 
							class="form-control" id='obj_fullName' 
							placeholder='fullName'>
			</div>
		</div>
</div>
</form>
<script>
	function listDepartment(){
		var url="<?=$rootPath?>/tdepartment/getData.php";
		setDDLPrefix(url,"#obj_departmentId","***หน่วยงาน***");
	}

	$(document).ready(function(){
		listDepartment();
	});
</script>
