<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once "../config/database.php";
include_once "../objects/tresearch.php";
include_once "../objects/classLabel.php";
$database = new Database();
$db = $database->getConnection();
$objLbl = new ClassLabel($db);
?>
<form role='form'>
<div class="box-body">
		
		
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_research","research","th").":" ?></label>
			<div class="col-sm-12">
				<input type="text" 
							class="form-control" id='obj_research' 
							placeholder='หัวข้อวิจัย'>
			</div>
		</div>
		
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_research","yearPlan","th").":" ?>/<?php echo $objLbl->getLabel("t_research","budget","th").":" ?></label>
			<div class="col-sm-4">
				<select id="obj_yearPlan" class="form-control">
				</select>
			</div>
			<div class="col-sm-4">
				<input type="text" 
				class="form-control" id='obj_budget'>
			</div>
			<div class="col-sm-4"></div>
		</div>
		<div class="form-group">
		<label class="col-sm-12"><?php echo $objLbl->getLabel("t_research","budgetType","th")."(บาท):" ?></label>
		<div class="col-sm-1">
		</div>
		<div class="col-sm-11">
				<div class="form-check">
				<input class="form-check-input" type="radio" name="obj_budgetType" id="obj_budgetType_1" value="01" checked >
					แหล่งทุนภายในมหาวิทยาลัย
				</div>
				<div class="form-check">
				<input class="form-check-input" type="radio" name="obj_budgetType" id="obj_budgetType_2" value="02">
					แหล่งทุนภายนอก
				</div>
			</div>

		</div>
		<div class="form-group">
		<label class="col-sm-12"><?php echo $objLbl->getLabel("t_research","researchSource","th").":" ?></label>
		<div class="col-sm-12">
			<input type="text" 
				class="form-control" id='obj_researchSource'>
		</div>
		</div>

		<div class="form-group">
		<label class="col-sm-12"><?php echo $objLbl->getLabel("t_research","detail","th").":" ?></label>
		<div class="col-sm-12">
			<textarea class="form-control" rows="3" style="width:100%" id="obj_detail" ></textarea>
		</div>
		</div>
		
</div>
</form>

<script>
 function setYearPlan(){
    const d = new Date();
    let year = d.getFullYear()+543;
    setDDLRange("#obj_yearPlan",year,year+20);
 }

 $(document).ready(function(){
 	setYearPlan();
 });

</script>
