<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once "../config/database.php";
include_once "../objects/taproverequest.php";
include_once "../objects/classLabel.php";
$database = new Database();
$db = $database->getConnection();
$objLbl = new ClassLabel($db);
$id=isset($_GET["id"])?$_GET["id"]:0;
$pType=isset($_GET["pType"])?$_GET["pType"]:0;
$userCode=isset($_GET["userCode"])?$_GET["userCode"]:"";
?>
<form role='form'>
	<input type="hidden" value='<?=$id?>' 
							 id='obj_requestId' 
							>
	<input type="hidden" value='<?=$pType?>'
							 id='obj_pType' 
							>
	<input type="hidden" value='<?=$userCode?>'
							 id='obj_userCode' 
							>
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
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_aproverequest","message","th").":" ?></label>
			<div class="col-sm-12">
			
				<textarea class="form-control" id='obj_message' 
				rows="6" style="width:100%"
				></textarea>
			</div>
		</div>
		
</div>
</form>
