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
		echo 'prefixname : ' . $result["prefixname"] . '<br>';//�ӹ�˹��
		echo 'staffname : ' . $result["staffname"] . '<br>';//������
		echo 'staffsurname : ' .  $result["staffsurname"] . '<br>';//���ʡ����
		echo 'staffnameeng : ' . $result["staffnameeng"] . '<br>';//�����ѧ���	
		echo 'staffsurnameeng : ' . $result["staffsurnameeng"] . '<br>';//���ʡ���ѧ���
		echo 'citizenid : ' . $result["citizenid"] . '<br>';//���ʻ�Шӵ�ǻ�ЪҢ�

		foreach($result["officer"] as $res){
			echo 'officercode :' .$res["officercode"] . '<br>';//�����Ҩ����
			echo 'officerusername :' .$res["officerlogin"] . '<br>';//���ʼ����
			echo 'departmentid :' .$res["departmentid"] . '<br>';//�����Ң�
			echo 'departmentname :' .$res["departmentname"] . '<br>';//�����Ң�
			echo 'officertype :' .$res["officertype"] . '<br>';//���ʻ������Ҩ����
			echo 'officertypename :' .$res["officertypename"] . '<br>';//��ͻ������Ҩ����
		}
		
		echo '<br>degree :' . $result["degree"] . '<br>';//����֡�ҷ�����
		foreach($result["degree"] as $res){
			echo 'degreelevelid :' . $res["degreelevel"] . '<br>';//�дѺ����֡��
			echo 'degreelevel :' . $res["degreelevelname"] . '<br>';//�дѺ����֡��
			echo 'degreenameabb :' . $res["degreenameabb"] . '<br>';//�س�ص�
			echo 'majorname :' . $res["majorname"] . '<br>';//�Ң��Ԫ�
			echo 'universityname :' . $res["universityname"] . '<br>';//��������Է�����
			echo 'graduatedatetime :' . $res["graduatedatetime"] . '<br>';//�շ�診
			echo '<br>';
		}

		echo 'positionname : ' . $result["positionname"] . '<br>';//���˹��Ԫҡ��
		foreach ($result["position"] as $res) {
			echo 'positionname : ' . $res["positionname"] . '<br>';//���˹觺�����
		}

		echo '<br>staffstatus :' . $result["staffstatus"] . '<br>';//����֡�Ҵ٧ҹ
		foreach($result["staffstatus"] as $res){
			echo 'datefrom :' . $res["datefrom"] . '<br>';//�ѹ��������
			echo 'dateto :' . $res["dateto"] . '<br>';//�ѹ�������ش
			echo 'positionname :' . $res["positionname"] . '<br>';//���˹�
			echo 'departmentname :' . $res["departmentname"] . '<br>';//˹��§ҹ
			echo '<br>';
		}

		echo '<br>record :' . $result["record"] . '<br>';//����֡�Ҵ٧ҹ
		foreach($result["record"] as $res){
			echo 'datefrom :' . $res["datefrom"] . '<br>';//�ѹ����
			echo 'dateto :' . $res["dateto"] . '<br>';//�ѹ����Ѻ
			echo 'recordtypeid :' . $res["recordtypeid"] . '<br>';//���ʻ�����
			echo 'description :' . $res["description"] . '<br>';//������
			echo 'institutename :' . $res["institutename"] . '<br>';//ʶҹ���
			echo 'recordname :' . $res["recordname"] . '<br>';//����
			echo '<br>';
		}

	}
?>