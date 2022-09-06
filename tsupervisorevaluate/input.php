<?php
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		header("Access-Control-Allow-Methods: POST");
		header("Access-Control-Max-Age: 3600");
		header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
		include_once "../config/database.php";
		include_once "../objects/tsupervisorevaluate.php";
		include_once "../objects/classLabel.php";
		$database = new Database();
		$db = $database->getConnection();
		$objLbl = new ClassLabel($db);
?>
<form role='form'>
<div class="box-body">
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_supervisorevaluate","userCode","th").":" ?>/<?php echo $objLbl->getLabel("t_supervisorevaluate","departmentCode","th").":" ?></label>
			
			<div class="col-sm-6">
				<select id="obj_departmentCode" class="form-control"></select>
			</div>
			<div class="col-sm-6">
				<input type="text" 
							class="form-control" id='obj_userCode' 
							placeholder='userCode'>
			</div>
		</div>

		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_supervisorevaluate","evaluateLevel","th").":" ?>/<?php echo $objLbl->getLabel("t_supervisorevaluate","depPosition","th").":" ?></label>
			<div class="col-sm-6">
				<select class="form-control" id='obj_evaluateLevel' ></select>
			</div>
			<div class="col-sm-6">
				<input type="text" 
							class="form-control" id='obj_depPosition' 
							placeholder='depPosition'>
			</div>

		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_supervisorevaluate","createDate","th").":" ?></label>
			<div class="col-sm-6">
				<div class="input-group date">
				<div class="input-group-addon">
				<i class="fa fa-calendar"></i>
				</div>
				<input type="date" class="form-control" id="obj_createDate">
				</div>
			</div>
		<div>&nbsp;
		</div>

		
</form>
