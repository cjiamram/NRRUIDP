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
<form role='form'>
<div class="box-body">
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_visit","visitSite","th").":" ?></label>
			<div class="col-sm-1"></div>
			<div class="col-sm-11">

				<div class="form-check">
				<input class="form-check-input" type="radio" name="obj_visitSite" id="obj_visitSite_1" value="01" checked >
					ภายในประเทศ
				</div>
				<div class="form-check">
				<input class="form-check-input" type="radio" name="obj_visitSite" id="obj_visitSite_2" value="02">
					ภายนอกประเทศ
				</div>
			</div>
		</div>
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_visit","visitObjective","th").":" ?></label>
			<div class="col-sm-12">
				<input type="text" 
							class="form-control" id='obj_visitObjective' 
							placeholder='เป้าหมาย'>
			</div>
		</div>
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_visit","projectDetail","th").":" ?></label>
			<div class="col-sm-12">
				<input type="text" 
							class="form-control" id='obj_projectDetail' 
							placeholder='รายละเอียด'>
			</div>
		</div>
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_visit","expectation","th").":" ?></label>
			<div class="col-sm-12">
				<input type="text" 
							class="form-control" id='obj_expectation' 
							placeholder='ความคาดหวัง'>
			</div>
		</div>
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_visit","budget","th").":" ?></label>
			<div class="col-sm-4">
				<input type="text" 
							class="form-control" id='obj_budget' 
							placeholder='งบประมาณ'>
			</div>
			<div class="col-sm-4" style="display:none">
				<input type="text" 
							class="form-control" id='obj_joinGroup' 
							placeholder='จำนวนผู้ร่วมดูงาน'>
			</div>
		</div>
		
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_visit","monthPlan","th").":" ?>/<?php echo $objLbl->getLabel("t_visit","yearPlan","th").":" ?></label>
			<div class="col-sm-4">
				<select class="form-control" id='obj_monthPlan'></select>
			</div>
			<div class="col-sm-4">
				<select class="form-control" id='obj_yearPlan'></select>
			</div>
			<div class="col-sm-4">
			</div>
		</div>
		
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_visit","duration","th").":" ?>(วัน)</label>
			<div class="col-sm-4">
				<input type="text" 
							class="form-control" id='obj_duration' 
							placeholder='ระยะเวลาดูงาน'>
			</div>
		</div>
		<!--<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_visit","createDate","th").":" ?></label>
			<div class="col-sm-12">
				<div class="input-group date">
				<div class="input-group-addon">
				<i class="fa fa-calendar"></i>
				</div>
				<input type="date" class="form-control" id="obj_createDate">
				</div>
			</div>
		</div>-->
		
		
		<!--<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_visit","fileAttach","th").":" ?></label>
			<div class="col-sm-12">
				<input type="text" 
							class="form-control" id='obj_fileAttach' 
							placeholder='fileAttach'>
			</div>
		</div>-->
		<!--<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_visit","isAprove","th").":" ?></label>
			<div class="col-sm-12">
				<input type="text" 
							class="form-control" id='obj_isAprove' 
							placeholder='isAprove'>
			</div>
		</div>-->
</div>
</form>

<script>
 
 $(document).ready(function(){
 	setYearPlan();
 	setMonth();
 });
</script>
