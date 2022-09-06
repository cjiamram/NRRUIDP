<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
	include_once "../config/database.php";
	include_once "../objects/tsemina.php";
	include_once "../objects/classLabel.php";
	$database = new Database();
	$db = $database->getConnection();
	$objLbl = new ClassLabel($db);
?>
<form role='form'>
<div class="box-body">
		
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_semina","improveSkill","th").":" ?></label>
			<div class="col-sm-12">
				<input type="text" 
							class="form-control" id='obj_improveSkillView'
							disabled 
							placeholder='ทักษะ/ความรู้'>
			</div>
		</div>
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_semina","improveOpjective","th").":" ?></label>
			<div class="col-sm-12">
				<input type="text" 
							class="form-control" id='obj_improveOpjectiveView'
							disabled 
							placeholder='วัตถุประสงค์'>
			</div>
		</div>
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_semina","budget","th").":" ?></label>
			<div class="col-sm-4">
				<input type="text" 
							class="form-control" id='obj_budgetView' 
							placeholder='งบประมาณ' disabled>
			</div>
		</div>
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_semina","monthPlan","th").":" ?>/<?php echo $objLbl->getLabel("t_semina","yearPlan","th").":" ?></label>
			<div class="col-sm-4">
				<select class="form-control" id='obj_monthPlanView' disabled></select>
			</div>
			<div class="col-sm-4">
				<!--<select class="form-control" id='obj_yearPlanView' disabled></select>-->
				<input type="text" 
							class="form-control" id='obj_yearPlanView'
							disabled 
							>

			</div>
			<div class="col-sm-4">
			</div>
		</div>
		<div class='form-group'>
						<label class="col-sm-12">ความเห็นของผูบังคับบัญชา</label>

			<div class="col-sm-12">
				<textarea  class="form-control" row="6" 
				style=" min-width:500px; max-width:100%;min-height:75px;height:100%;width:100%;"
				  disabled="true" id="obj_commentView"></textarea>
			</div>
		</div>
		
		
		
</div>
</form>
<script>
	$(document).ready(function(){
		 setYearPlan();
    	 setMonth();
	});
</script>
