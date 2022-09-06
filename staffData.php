<?php
	require_once("lib/nusoap.php");
	header ("Content-Type: text/html; charset=utf-8");

	$client = new nusoap_client("http://entrance.nrru.ac.th/nrruwebservice/nrruWebService_tqf_staff.php?wsdl",true); 
	$params = array(
		'staffid' => "1030"
	);
	$data = $client->call("getStaffData",$params); 
	//echo 'data : ' . $data . '<br>';
	
	$staff = json_decode($data,true);
	foreach ($staff as $result) {
		echo '<br>TQF <br>';
		echo 'prefixname : ' . $result["prefixname"] . '<br>';//คำนำหน้า
		echo 'staffname : ' . $result["staffname"] . '<br>';//ชื่อไทย
		echo 'staffsurname : ' .  $result["staffsurname"] . '<br>';//นามสกุลไทย
		echo 'staffnameeng : ' . $result["staffnameeng"] . '<br>';//ชื่ออังกฤษ	
		echo 'staffsurnameeng : ' . $result["staffsurnameeng"] . '<br>';//นามสกุลอังกฤษ
		echo 'citizenid : ' . $result["citizenid"] . '<br>';//รหัสประจำตัวประชาขน

		foreach($result["officer"] as $res){
			echo 'officercode :' .$res["officercode"] . '<br>';//รหัสอาจารย์
			echo 'officerusername :' .$res["officerlogin"] . '<br>';//รหัสผู้ใช้
			echo 'departmentid :' .$res["departmentid"] . '<br>';//รหัสสาขา
			echo 'departmentname :' .$res["departmentname"] . '<br>';//ชื่อสาขา
			echo 'officertype :' .$res["officertype"] . '<br>';//รหัสประเภทอาจารย์
			echo 'officertypename :' .$res["officertypename"] . '<br>';//ชือประเภทอาจารย์
		}
		
		echo '<br>degree :' . $result["degree"] . '<br>';//การศึกษาทั้งหมด
		foreach($result["degree"] as $res){
			echo 'degreelevelid :' . $res["degreelevel"] . '<br>';//ระดับการศึกษา
			echo 'degreelevel :' . $res["degreelevelname"] . '<br>';//ระดับการศึกษา
			echo 'degreenameabb :' . $res["degreenameabb"] . '<br>';//คุณวุติ
			echo 'majorname :' . $res["majorname"] . '<br>';//สาขาวิชา
			echo 'universityname :' . $res["universityname"] . '<br>';//ชื่อมหาวิทยาลัย
			echo 'graduatedatetime :' . $res["graduatedatetime"] . '<br>';//ปีที่จบ
			echo '<br>';
		}

		echo 'positionname : ' . $result["positionname"] . '<br>';//ตำแหน่งวิชาการ
		foreach ($result["position"] as $res) {
			echo 'positionname : ' . $res["positionname"] . '<br>';//ตำแหน่งบริหาร
		}

		echo '<br>staffstatus :' . $result["staffstatus"] . '<br>';//การศึกษาดูงาน
		foreach($result["staffstatus"] as $res){
			echo 'datefrom :' . $res["datefrom"] . '<br>';//วันที่เริ่ม
			echo 'dateto :' . $res["dateto"] . '<br>';//วันที่สิ้นสุด
			echo 'positionname :' . $res["positionname"] . '<br>';//ตำแหน่ง
			echo 'departmentname :' . $res["departmentname"] . '<br>';//หน่วยงาน
			echo '<br>';
		}

		echo '<br>record :' . $result["record"] . '<br>';//การศึกษาดูงาน
		foreach($result["record"] as $res){
			echo 'datefrom :' . $res["datefrom"] . '<br>';//วันที่ไป
			echo 'dateto :' . $res["dateto"] . '<br>';//วันที่กลับ
			echo 'recordtypeid :' . $res["recordtypeid"] . '<br>';//รหัสประเภท
			echo 'description :' . $res["description"] . '<br>';//ประเภท
			echo 'institutename :' . $res["institutename"] . '<br>';//สถานที่
			echo 'recordname :' . $res["recordname"] . '<br>';//ชื่อ
			echo '<br>';
		}

	}
?>