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
				<label class="col-sm-12">กำหนดสถานะแผนงาน</label>
				<div class="col-sm-12">
				<div class="form-check">
				<input class="form-check-input" type="radio" name="obj_status" id="obj_status_1" value="3" checked >
				ดำเนินการเสร็จลุล่วงแล้ว
				</div>
				<div class="form-check">
				<input class="form-check-input" type="radio" name="obj_status" id="obj_status_2" value="4">
				ไม่สามารถดำเนินการได้
				</div>
				</div>	
			</div>
			<div class='form-group'>
				<label class="col-sm-12">หมายเหตุ</label>
				<div class="col-sm-12">
				<textarea rows="5" 
				id="obj_message" 
				class="form-control"
				style="width:100%"
				></textarea>
				</div>	
			</div>
		</div>
</div>
</form>