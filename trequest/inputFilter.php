<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once "../config/database.php";
include_once "../objects/trequest.php";
include_once "../objects/classLabel.php";
include_once "../config/config.php";
$cnf=new Config();
$rootPath=$cnf->path;
$database = new Database();
$db = $database->getConnection();
$objLbl = new ClassLabel($db);
$cDate=date("m-d-Y");

?>
<form role='form'>
<div class="box-body">
		<div class="col-sm-6">
		<input type="text" placeholder='Search' class="form-control"  id="obj_searchStaff">
		<br>
		<table width="100%"  id="tblFullName" class="table table-bordered">
			
		</table>
		</div>
		<div class="col-sm-6">
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_request","userCode","th").":" ?></label>
			<div class="col-sm-12">
				<input type="text" 
							class="form-control"  id='obj_userCode' 
							placeholder='userCode'>
			</div>
		</div>
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_request","fullName","th").":" ?></label>
			<div class="col-sm-12">
				<input type="text" 
							class="form-control"  id='obj_fullName' 
							placeholder='fullName'>
			</div>
		</div>
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_request","description","th").":" ?></label>
			<div class="col-sm-12">
				

				<textarea rows="4" class="form-control" id='obj_description' ></textarea>

			</div>
		</div>
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_request","createDate","th").":" ?></label>
			<div class="col-sm-12">
				<div class="input-group date">
				<div class="input-group-addon">
				<i class="fa fa-calendar"></i>
				</div>
				<input type="date" class="form-control"  value='<?=date("Y-m-d")?>'  id="obj_createDate">
				</div>
			</div>
		</div>
	
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_request","requestType","th").":" ?></label>
			<div class="col-sm-12">
				
				<select class="form-control"  id='obj_requestType' ></select>
			</div>
		</div>
	</div>


</div>
</form>

<script>
	function setRequestType(){
		var url="<?=$rootPath?>/trequesttype/getData.php";
		setDDL(url,"#obj_requestType");
	}

	


	$(document).ready(function(){
		setRequestType();
		searchName();
		$("#obj_searchStaff").change(function(){
			searchName();
		});
	});

</script>
