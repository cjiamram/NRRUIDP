<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once "../config/database.php";
include_once "../objects/tacademicplan.php";
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
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_academicplan","educationPlan","th").":" ?></label>
			<div class="col-sm-12">
						<input type="text" 
							class="form-control" id='obj_educationPlanView' disabled 
							>
			</div>
		</div>
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_academicplan","degree","th").":" ?></label>
			<div class="col-sm-12">
				<!--<input type="text" 
							class="form-control" id='obj_degreeView' disabled 
							placeholder='คุณวุฒิ'>-->
				<select id='obj_degreeView' class="form-control" disabled ></select>
			</div>
		</div>
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_academicplan","eduCertificate","th").":" ?></label>
			<div class="col-sm-12">
				<input type="text" 
							class="form-control" id='obj_eduCertificateView' disabled 
							placeholder='คุณวุฒิ'>
			</div>
		</div>
		
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_academicplan","yearPlan","th").":" ?>/<?php echo $objLbl->getLabel("t_academicplan","budget","th").":" ?></label>
			<div class="col-sm-4">
				
				<input type="text" 
							class="form-control" disabled id='obj_yearPlanView' 
							>
			</div>
			<div class="col-sm-4">
				<input type="text" 
							class="form-control" disabled id='obj_budgetView' 
							placeholder='งบประมาณ'>
			</div>
			<div class="col-sm-4">&nbsp;
			</div>
		</div>
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_academicplan","sourceType","th").":" ?></label>
			<div class="col-sm-1"></div>
			<div class="col-sm-11">

				<div class="form-check">
				<input class="form-check-input" type="radio" name="obj_sourceTypeView" disabled id="obj_sourceType_1View" value="01" checked >
					แหล่งทุนภายในมหาวิทยาลัย
				</div>
				<div class="form-check">
				<input class="form-check-input" type="radio" name="obj_sourceTypeView" disabled id="obj_sourceType_2View" value="02">
					แหล่งทุนภายนอก
				</div>
			</div>
		</div>
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_academicplan","fundSource","th").":" ?></label>
			<div class="col-sm-12">
				<input type="text" 
							class="form-control" id='obj_fundSourceView' disabled 
							placeholder='แหล่งทุน'>
			</div>
		</div>
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_academicplan","university","th").":" ?></label>
			<div class="col-sm-12">
				<input type="text" 
							class="form-control" id='obj_universityView' disabled 
							placeholder='สถานศึกษา'>
			</div>
		</div>
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_academicplan","duration","th").":" ?></label>
			<div class="col-sm-4">
				<input type="text" 
							class="form-control" disabled id='obj_durationView' 
							placeholder='ระยะเวลาศึกษาต่อ'>
			</div>
			<div class="col-sm-8">ปี
			</div>
		</div>

		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_academicplan","placetype","th").":" ?></label>
			<div class="col-sm-1"></div>
			<div class="col-sm-11">

				<div class="form-check">
				<input class="form-check-input" type="radio" disabled name="obj_placeTypeView" id="obj_placeType_1View" value="01" checked >
					สถานศึกษาภายในประเทศ
				</div>
				<div class="form-check">
				<input class="form-check-input" type="radio" disabled name="obj_placeType" id="obj_placeType_2View" value="02">
					สถานศึกษาภายนอกประเทศ
				</div>
			</div>
		</div>
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_academicplan","eduType","th").":" ?></label>
			<div class="col-sm-1"></div>
			<div class="col-sm-11">

				<div class="form-check">
				<input class="form-check-input" type="radio" name="obj_eduTypeView" id="obj_eduType_1View" disabled value="01" checked >
					ภายในเวลาทำงาน
				</div>
				<div class="form-check">
				<input class="form-check-input" type="radio" name="obj_eduTypeView" id="obj_eduType_2View" disabled value="02">
					ภายนอกเวลาทำงาน
				</div>
			</div>
		</div>
		<div class='form-group'>


		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_academicplan","description","th").":" ?></label>
			<div class="col-sm-12">
				
				<textarea class="form-control" disabled id='obj_descriptionView'
				rows='3' style="width:100%"
				 >
				</textarea>
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
	function listEduLevel(){
		var url ="<?=$rootPath?>/tedulevel/getData.php";
		setDDLPrefix(url,"#obj_degreeView","***ระดับการศึกษา***");	
	}

	$(document).ready(function(){
		listEduLevel();
		//setYearPlan();
	});

</script>
