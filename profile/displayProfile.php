<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: text/html; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");

	session_start();
	include_once "../config/config.php";
	include_once "../config/database.php";
	include_once "../lib/classAPI.php";
	include_once "../objects/tstaffgroup.php";
	$database=new Database();
	$db=$database->getConnection();

	$obj=new tstaffgroup($db);
	$cnf=new Config();
	$api=new ClassAPI();
	$staffId=isset($_SESSION["staffid"])?$_SESSION["staffid"]:"25141";
	//print_r($staffId);
	$url="http://nrruapp.nrru.ac.th/Credential/getNrruProfile.php?staffId=".$staffId;
	$data=$api->getAPI($url);
	if($data!=""){
		$staffcode=$data[0]["staffcode"];
		$departmentName=$data[0]["departmentname"];
		$positionlevel=$data[0]["positionlevel"];
		$positionname=$data[0]["positionname"];
		$stafftypename=$data[0]["stafftypename"];
		$staffGroup=intval($data[0]["staffGroup"]);
		$graduated=$data[0]["graduated"];
	
		if(!isset($_SESSION["staffGroup"])){
			

			$_SESSION["staffGroup"]=intval($data[0]["staffGroup"]);
			if(!$obj->isExist($_SESSION["UserName"])){
				$obj->userCode=$_SESSION["UserName"];
				$obj->staffGroup=intval($data[0]["staffGroup"]);
				$obj->create();
			}


			if($_SESSION["DepartmentCode2"]==="011400"||$_SESSION["DepartmentCode2"]==="011300"||$_SESSION["DepartmentCode2"]==="011900"){
						$_SESSION["isTeacher"]=1;
						$_SESSION["staffGroup"]=4;
						
					}else{
						$_SESSION["isTeacher"]=0;
					}
		}


	}else
	{
		$staffcode="Admin";
		$departmentName="Computer Center";
		$positionlevel="Admin";
		$positionname="Admin";
		$staffGroup=2;
		if(!isset($_SESSION["staffGroup"])){
			$_SESSION["staffGroup"]=2;
			if(!$obj->isExist($_SESSION["UserName"])){
				$obj->$userCode=$_SESSION["UserName"];
				$obj->staffGroup=1;
				$obj->create();
			}
		}
		$graduated=array();
	}
?>
<section class="content container-fluid">

 
<div class="box">
<div class="box-header with-border">
      <h3 class="box-title"><b>ข้อมูลส่วนบุคคล</b></h3>
  </div>
<div class="box box-primary">
<table width="100%" class="table table-bordered table-hover">
<tr>
	<td align="right" width="200px"><label>รหัสพนักงาน :</label></td>
	<td><?=$staffcode?></td>
</tr>
<tr>
	<td align="right"><label>ชื่อ-สกุล :</label></td>
	<td><?=$_SESSION["FullName"]?></td>
</tr>
<tr>
	<td align="right"><label>หน่วยงาน :</label></td>
	<td><?=$departmentName?></td>
</tr>
<tr>
	<td align="right"><label>ตำแหน่ง :</label></td>
	<td><?=$stafftypename?></td>
</tr>
<tr>
	<td align="right"><label>ชื่อตำแหน่ง :</label></td>
	<td><?=$positionname?></td>
</tr>

</table>	
</div>
</div>

<div class="box box-warning">
<table width="100%" class="table table-bordered table-hover">
<tr>
	<th>No.
	</th>
	<th>ระดับการศึกษา
	</th>
	<th>วุฒิการศึกษา
	</th>
	<th>จบการศึกษา
	</th>
	<th>สถาบันการศึกษา
	</th>
	<th>สาขาวิชา
	</th>
</tr>
<tbody>
<?php
	$i=1;
	//print_r(array_unique($graduated));
	//$data=array_unique($graduated[0])
	foreach ($graduated as $p) {
		echo "<tr>\n";
		echo "<td>".$i++."</td>\n";
		echo "<td>".$p["degreelevel"]."</td>\n";
		echo "<td>".$p["degreename"]."</td>\n";
		echo "<td>".$p["graduatedatetime"]."</td>\n";
		echo "<td>".$p["universityname"]."</td>\n";
		echo "<td>".$p["majorname"]."</td>\n";
		echo "</tr>\n";
	}
	
?>
</tbody>
</table>
</div>
</section>