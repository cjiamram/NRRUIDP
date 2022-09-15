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
							class="form-control" id='obj_educationPlan' 
							placeholder='แผนการศึกษาต่อ เช่น วิศวกรรมศาสตร์ <สาขา...>'>
			</div>
		</div>
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_academicplan","degree","th").":" ?></label>
			<div class="col-sm-12">
				<select class="form-control" id='obj_degree'></select>
			</div>
		</div>
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_academicplan","eduCertificate","th").":" ?></label>
			<div class="col-sm-12">
				<input type="text" 
							class="form-control" id='obj_eduCertificate' 
							placeholder='คุณวุฒิ เช่น ปริญญาเอก วิศวกรรมศาสตร์บัณฑิต'>
			</div>
		</div>
		
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_academicplan","yearPlan","th").":" ?>/<?php echo $objLbl->getLabel("t_academicplan","budget","th").":" ?></label>
			<div class="col-sm-4">
				
				<select class="form-control" id='obj_yearPlan'></select>
			</div>
			<div class="col-sm-4">
				<input type="text" 
							class="form-control" id='obj_budget' 
							placeholder='งบประมาณ'>
			</div>
			<div class="col-sm-4">&nbsp;<label>บาท</label>
			</div>
		</div>
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_academicplan","sourceType","th").":" ?></label>
			<div class="col-sm-1"></div>
			<div class="col-sm-11">

				<div class="form-check">
				<input class="form-check-input" type="radio" name="obj_sourceType" id="obj_sourceType_1" value="01" checked >
					แหล่งทุนภายในมหาวิทยาลัย
				</div>
				<div class="form-check">
				<input class="form-check-input" type="radio" name="obj_sourceType" id="obj_sourceType_2" value="02">
					ทุนภายนอก
				</div>
				<div class="form-check">
				<input class="form-check-input" type="radio" name="obj_sourceType" id="obj_sourceType_3" value="03">
					ทุนส่วนบุคคล
				</div>
			</div>
		</div>
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_academicplan","fundSource","th").":" ?></label>
			<div class="col-sm-12">
				<input type="text" 
							class="form-control" id='obj_fundSource' 
							placeholder='แหล่งทุน เช่น วช.'>
			</div>
		</div>
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_academicplan","university","th").":" ?></label>
			<div class="col-sm-12">
				<input type="text" 
							class="form-control" id='obj_university' 
							placeholder='สถานศึกษา เช่น มหาวิทยาลัยราชภัฏนครราชสีมา'>
			</div>
		</div>
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_academicplan","duration","th").":" ?></label>
			<div class="col-sm-4">
				<input type="text" 
							class="form-control" id='obj_duration' 
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
				<input class="form-check-input" type="radio" name="obj_placeType" id="obj_placeType_1" value="01" checked >
					สถานศึกษาภายในประเทศ
				</div>
				<div class="form-check">
				<input class="form-check-input" type="radio" name="obj_placeType" id="obj_placeType_2" value="02">
					สถานศึกษาภายนอกประเทศ
				</div>
				
			</div>
		</div>
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_academicplan","eduType","th").":" ?></label>
			<div class="col-sm-1"></div>
			<div class="col-sm-11">

				<div class="form-check">
				<input class="form-check-input" type="radio" name="obj_eduType" id="obj_eduType_1" value="01" checked >
					ภายในเวลาทำงาน
				</div>
				<div class="form-check">
				<input class="form-check-input" type="radio" name="obj_eduType" id="obj_eduType_2" value="02">
					ภายนอกเวลาทำงาน
				</div>
			</div>
		</div>
		<div class='form-group'>


		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_academicplan","description","th").":" ?></label>
			<div class="col-sm-12">
				
				<textarea class="form-control" id='obj_description'
				rows='3' style="width:100%"
				 >
				</textarea>
			</div>
		</div>
</div>
</form>

<script>
	function listEduLevel(){
		var url ="<?=$rootPath?>/tedulevel/getData.php";
		setDDLPrefix(url,"#obj_degree","***ระดับการศึกษา***");	
	}

	$(document).ready(function(){
		listEduLevel();
		setYearPlan();
	});

</script>
