<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: text/html; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
	include_once "../config/database.php";
	include_once "../objects/tsupervisoraprove.php";
	include_once "../objects/classLabel.php";
	$database = new Database();
	$db = $database->getConnection();
	$objLbl = new ClassLabel($db);



?>

<input type="hidden" 
	id='obj_requestId'   
>

<input type="hidden" 
	id='obj_workType'>

<input type="hidden" 
	id='obj_supervisorCode'>

<input type="hidden" 
	 id='obj_idRequest'>

<input type="hidden" 
 id='obj_levelWork'>

<form role='form'>
<div class="box-body">
		<div class'form-group'>
			<label class="col-sm-12">กำหนดสถานะ</label>

			<div class='col-sm-12'>
			<div class="form-check">
				<input class="form-check-input" type="radio" name="obj_status" id="obj_status_1" value="1" checked >
					อนุมัติ
				</div>
				<div class="form-check">
				<input class="form-check-input" type="radio" name="obj_status" id="obj_status_2" value="2">
					ไม่อนุมัติ
				</div>
			</div>
		</div>
	
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_supervisoraprove","userCode","th").":" ?></label>
			<div class="col-sm-4">
				<input type="text" id="obj_userCode" class="form-control">
			</div>
			<div class="col-sm-8">
				<input type="text" id="obj_fullName" class="form-control">
			</div>
		</div>
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_supervisoraprove","notification","th").":" ?></label>
			<div class="col-sm-12">
			
				<textarea class="form-control" id='obj_notification' style='width:100%' rows="6" ></textarea>
			</div>
		</div>
		
</div>
</form>
