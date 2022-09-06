<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once "../config/database.php";
include_once "../config/config.php";
include_once "../objects/tupposition.php";
include_once "../objects/classLabel.php";
$database = new Database();
$db = $database->getConnection();
$objLbl = new ClassLabel($db);
$cnf=new Config();
$rootPath=$cnf->path;
?>
<form role='form'>
<div class="box-body">
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_upposition","expertType","th").":" ?></label>
			<div class="col-sm-12">
				<select class="form-control" id='obj_expertType' ></select>
			</div>
		</div>
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_upposition","yearPlan","th").":" ?></label>
			<div class="col-sm-12">
				<select class="form-control" id='obj_yearPlan' ></select>
			</div>
		</div>
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_upposition","description","th").":" ?></label>
			<div class="col-sm-12">
				<textarea class="form-control" style="width:100%;" rows="3" id='obj_description'></textarea>
			</div>
		</div>
</div>
</form>

<script>
	function setExpertType(){
		var url="<?=$rootPath?>/texperttype/getData.php";
		//console.log(url);
		setDDLPrefix(url,"#obj_expertType","***ความเชี่ยวชาญพิเศษ***");
	}



	$(document).ready(function(){
		setExpertType();
		setYearPlan();
	});
</script>
