<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once "../config/database.php";
include_once "../objects/tvisit.php";
include_once "../objects/classLabel.php";
$database = new Database();
$db = $database->getConnection();
$objLbl = new ClassLabel($db);
?>
<form role='form' id="frmCtl">
<div class="box-body">
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_visit","visitSite","th").":" ?></label>
			<div class="col-sm-1"></div>
			<div class="col-sm-11">

				<div class="form-check">
				<input class="form-check-input" type="radio" disabled="true" name="obj_visitSite" id="obj_visitSite_1" value="01" checked >
					ภายในประเทศ
				</div>
				<div class="form-check">
				<input class="form-check-input" type="radio" disabled="true" name="obj_visitSite" id="obj_visitSite_2" value="02">
					ภายนอกประเทศ
				</div>
			</div>
		</div>
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_visit","visitObjective","th").":" ?></label>
			<div class="col-sm-12">
				<input type="text" 
							class="form-control" disabled="true" id='obj_visitObjectiveView' 
							placeholder='เป้าหมาย'>
			</div>
		</div>
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_visit","projectDetail","th").":" ?></label>
			<div class="col-sm-12">
				<input type="text" 
							class="form-control" disabled="true" id='obj_projectDetailView' 
							placeholder='รายละเอียด'>
			</div>
		</div>
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_visit","expectation","th").":" ?></label>
			<div class="col-sm-12">
				<input type="text" 
							class="form-control" disabled="true" id='obj_expectationView' 
							placeholder='ความคาดหวัง'>
			</div>
		</div>
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_visit","budget","th").":" ?></label>
			<div class="col-sm-4">
				<input type="text" 
							class="form-control" disabled="true" id='obj_budgetView' 
							placeholder='งบประมาณ'>
			</div>
			<div class="col-sm-4" style="display:none">
				<input type="text" 
							class="form-control" disabled="true" id='obj_joinGroupView' 
							placeholder='จำนวนผู้ร่วมดูงาน'>
			</div>
		</div>
		
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_visit","monthPlan","th").":" ?>/<?php echo $objLbl->getLabel("t_visit","yearPlan","th").":" ?></label>
			<div class="col-sm-4">
				<input type="textbox" disabled="true" class="form-control" id="obj_monthPlanView">
			</div>
			<div class="col-sm-4">
				<input type="textbox" disabled="true" class="form-control" id="obj_yearPlanView">
			</div>
			<div class="col-sm-4">
			</div>
		</div>
		
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_visit","duration","th").":" ?>(วัน)</label>
			<div class="col-sm-4">
				<input type="text" 
							class="form-control" disabled="true" id='obj_durationView' 
							placeholder='ระยะเวลาดูงาน'>
			</div>
		</div>

			<div class='form-group'>
						<label class="col-sm-12">ความเห็นของผูบังคับบัญชา</label>

			<div class="col-sm-4">
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
