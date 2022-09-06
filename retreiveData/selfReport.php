<?php
	session_start();
	header("content-type:text/html;charset=UTF-8");
	include_once "../config/database.php";
	include_once "../objects/data.php";
	include_once "../objects/manage.php";
	include_once "../lib/classAPI.php";

	$api=new ClassAPI();

	$staffId=isset($_GET["staffId"])?$_GET["staffId"]:"25141";
	$database=new Database();
	$db=$database->getConnection();
	$obj=new Data($db);
	//$userCode,$yearPlan
	$userCode=isset($_GET["userCode"])?$_GET["userCode"]:"chatchai.j";
	$yearPlan=isset($_GET["yearPlan"])?$_GET["yearPlan"]:"2565";
	//$fullName=isset($_SESSION["UserName"])?$_SESSION["UserName"]:"";
	$fullName="";

	/*******************************/
	$url="http://nrruapp.nrru.ac.th/Credential/getNrruProfile.php?staffId=".$staffId;
	//print_r($url);
	$data=$api->getAPI($url);
	//print_r($data);
	if($data!=""){
	
        $fullName=$data[0]["prefixname"]." ".$data[0]["staffname"]." ".$data[0]["staffsurname"];

		$departmentName=$data[0]["departmentname"];
		$positionlevel=$data[0]["positionlevel"];
		$positionname=$data[0]["positionname"];
		$stafftypename=$data[0]["stafftypename"];
		$workdepartmentname=$data[0]["workdepartmentname"];
		
	}else
	{
		$fullName="Admin";
		$departmentName="Computer Center";
		$positionlevel="Admin";
		$positionname="Admin";
		
	}

	/*******************************/

	//$positionname=isset($_SESSION["positionname"])?$_SESSION["positionname"]:"";
	//$departmentName=isset($_SESSION["departmentName"])?$_SESSION["departmentName"]:"";
	//$workdepartmentname=isset($_SESSION["workdepartmentname"])?$_SESSION["workdepartmentname"]:"";
	$sum=0;

	$i=1;

?>
<html>
<style>
table, td, th {
  border: 1px solid #f4f4f4;;

}

table {
  width: 100%;
  /*border-collapse: collapse;*/
}

html, body, form, fieldset, table, tr, td, img {
    margin: 0;
    padding: 0;
    font: 100%/150% calibri,helvetica,sans-serif;
}

input, button, select, textarea, optgroup, option {
    font-family: inherit;
    font-size: inherit;
    font-style: inherit;
    font-weight: inherit;
}

/* rest of your styles; like: */
body {
    font-size: 0.97em;
}

.label-default {
  background-color: #d2d6de;
  color: #444;
}

.label {
  position: absolute;
  top: 9px;
  right: 7px;
  text-align: center;
  font-size: 9px;
  padding: 2px 3px;
  line-height: .9;
}

body { margin: 30px; } 
h1 { font-size: 1.5em; }



/*** custom checkboxes ***/

input[type=checkbox] { display:none; } /* to hide the checkbox itself */
input[type=checkbox] + label:before {
  font-family: FontAwesome;
  display: inline-block;
}

input[type=checkbox] + label:before { content: "\f096"; } /* unchecked icon */
input[type=checkbox] + label:before { letter-spacing: 10px; } /* space between checkbox and label */

input[type=checkbox]:checked + label:before { content: "\f046"; } /* checked icon */
input[type=checkbox]:checked + label:before { letter-spacing: 5px; } /* allow space for check mark */
</style>
    <form class="form">        

<table width='500px' border="1">
<tr><td align="center">
	<h2><b>แผนพัฒนาบุคลากรรายบุคคล มหาวิทยาลัยราชภัฏนครราชสีมา</b></h2>
</td></tr>
<tr><td align="center">
	<h2><b>NRRU Individual Development Plan : IDP</b></h2>
</td></tr>
<tr>
	<td>
		<h4><b>ส่วนที่ 1 ข้อมูลทั่วไป</b></h4>
	</td>
</tr>

<tr>
<td>
	<table width="100%" border="1">
		<tr>
			<td width="200px">คณะ/สำนัก/สถาบัน
			</td>
			<td><?php echo $workdepartmentname; ?>
			</td >
			<td>หน่วยงาน/ฝ่าย/กอง/งาน
			</td>
			<td><?=$departmentName?>
			</td>
		</tr>
		<tr>
			<td width="200px">ชื่อ - นามสกุล ผู้รับการพัฒนา
			</td>
			<td><?=$fullName?>
			</td >
			<td width="200px">ตำแหน่งงาน
			</td>
			<td><?=$positionname?>
			</td>
		</tr>
		<tr>
			<td width="200px">ชื่อ - นามสกุล ผู้บังคับบัญชา
			</td>
			<td>
			</td >
			<td width="200px">ตำแหน่งงาน
			</td>
			<td>
			</td>
		</tr>
		<tr>
			<td width="200px">รอบการพัฒนาวันที่
			</td>
			<td><?=date("d-m-Y")?>
			</td>
			<td  width="200px">ปีงบประมาณ
			</td>
			<td><?=$yearPlan?>
			</td>
		</tr>


	</table>


</td>
</tr>

<tr>
	<td>
		<h4><b>ส่วนที่ 2 แนวทางการพัฒนาบุคลากร</b></h4>
	</td>
</tr>
<tr>
<td>

<table width="100%" border="1">
<tr>
	<td rowspan="2" width="50px" valign="top" align="center">ลำดับที่</td>
	<td rowspan="2" width="30%" valign="top" align="center">เป้าหมายการพัฒนา/ที่ต้องการพัฒนา</td>
	<td rowspan="2"  valign="top" align="center">รายละเอียดวิธีการพัฒนา</td>
	<td rowspan="2" width="10%" valign="top" align="center">ช่วงเวลาการพัฒนา</td>
	<td colspan="3" align="center" valign="top" width="20%">การติดตามผลการพัฒนา</td>
</tr>
<tr>
	<td align="center" valign="top" width="10%">สำเร็จ</td>
	<td align="center" valign="top" width="10%">ไม่สำเร็จ</td>
	<td align="center" valign="top" width="10%">งบประมาณที่ใช้จริง</td>
</tr>	
</table>

</td>
</tr>
<tr>
	<td><label><h4><b>2.1 ด้านการวางแผนการศึกษาต่อ</b></h4></label></td>
</tr>
<tr>
<td>
<table width="100%" border="1">
<?php
	$stmt=$obj->getSelfAcademicPlan($userCode,$yearPlan);
	if($stmt->rowCount()>0){
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			$sum+=$budget;
			echo "<tr>\n";
			echo "<td width='50px' align='center'>".$i++."</td>\n";
			echo "<td width='30%'>".$Topic."</td>\n";
			echo "<td>".$description."</td>\n";
			echo "<td width='10%' align='center'>".Format::getTextDate($createDate)."</td>\n";
			if((intval($isAprove)==1)){	
				echo "<td width='10%' align='center'><img src='../img/ch36.png'></td>\n";
				echo "<td width='10%'>&nbsp;</td>\n";
			}else{
				echo "<td width='10%'>&nbsp;</td>\n";
				echo "<td width='10%' align='center'><img src='../img/ch36.png'></td>\n";
			}

			echo "<td width='10%' align='right'>".number_format($budget,2)."</td>\n";
			echo "</tr>\n";
		}
	}
?>
</table>

</td>
</tr>
<tr>
	<td><label><h4><b>2.2 ด้านการขอตำแหน่งที่สูงขึ้น</b></h4></label></td>
</tr>
<tr>
	<td>
		<table width="100%" border="1">
<?php
	$stmt=$obj->getSelfUppositionPlan($userCode,$yearPlan);
	if($stmt->rowCount()>0){
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){

			extract($row);
			$sum+=$budget;
			echo "<tr>\n";
			echo "<td width='50px' align='center'>".$i++."</td>\n";
			echo "<td width='30%'>".$Topic."</td>\n";
			echo "<td>".$description."</td>\n";
			echo "<td width='10%' align='center'>".Format::getTextDate($createDate)."</td>\n";
			if((intval($isAprove)==1))
			{	echo "<td width='10%' align='center'><img src='../img/ch36.png'></td>\n";
				echo "<td width='10%'>&nbsp;</td>\n";
			}else{
				echo "<td width='10%'>&nbsp;</td>\n";
				echo "<td width='10%' align='center'><img src='../img/ch36.png'></td>\n";
			}

			echo "<td width='10%' align='right'>".number_format($budget,2)."</td>\n";
			echo "</tr>\n";
		}
	}
?>
</table>
	</td>
</tr>
<tr>
	<td><label><h4><b>2.3 ด้านศึกษาดูงาน</b></h></label></td>
</tr>
<tr>
	<td>
		<table width="100%" border="1">
<?php
	$stmt=$obj->getSelfVisitPlan($userCode,$yearPlan);
	if($stmt->rowCount()>0){
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			$sum+=$budget;
			echo "<tr>\n";
			echo "<td width='50px' align='center'>".$i++."</td>\n";
			echo "<td width='30%'>".$Topic."</td>\n";
			echo "<td>".$description."</td>\n";
			echo "<td width='10%' align='center'>".Format::getTextDate($createDate)."</td>\n";
			if((intval($isAprove)==1))
			{	echo "<td width='10%' align='center'><img src='../img/ch36.png'></td>\n";
				echo "<td width='10%'>&nbsp;</td>\n";
			}else{
				echo "<td width='10%'>&nbsp;</td>\n";
				echo "<td width='10%' align='center'><img src='../img/ch36.png'></td>\n";
			}

			echo "<td width='10%' align='right'>".number_format($budget,2)."</td>\n";
			echo "</tr>\n";
		}
	}
?>
</table>
	</td>
</tr>
<tr>
	<td><label><h4><b>2.4 ด้านการอบรม สัมมนา</b></h4></label></td>
</tr>
<tr>
	<td>
		<table width="100%" border="1">
<?php
	$stmt=$obj->getSelfSeminaPlan($userCode,$yearPlan);
	if($stmt->rowCount()>0){
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			$sum+=$budget;
			echo "<tr>\n";
			echo "<td width='50px' align='center'>".$i++."</td>\n";
			echo "<td width='30%'>".$Topic."</td>\n";
			echo "<td>".$description."</td>\n";
			echo "<td width='10%' align='center'>".Format::getTextDate($createDate)."</td>\n";
			if((intval($isAprove)==1))
			{	echo "<td width='10%' align='center'><img src='../img/ch36.png'></td>\n";
				echo "<td width='10%'>&nbsp;</td>\n";
			}else{
				echo "<td width='10%'>&nbsp;</td>\n";
				echo "<td width='10%' align='center'><img src='../img/ch36.png'></td>\n";
			}
			echo "<td width='10%' align='right'>".number_format($budget,2)."</td>\n";
			echo "</tr>\n";
		}
	}
?>
</table>
	</td>
</tr>
<tr>
	<td><label><h4><b>2.5 ด้านงานวิจัย</b></h4></label></td>
</tr>
<tr>
	<td>
		<table width="100%" border="1">
<?php
	$stmt=$obj->getSelfResearchPlan($userCode,$yearPlan);
	//print_r("research");
	if($stmt->rowCount()>0){
		//print_r("research");
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			$sum+=$budget;
			echo "<tr>\n";
			echo "<td width='50px' align='center'>".$i++."</td>\n";
			echo "<td width='30%'>".$Topic."</td>\n";
			echo "<td>".$description."</td>\n";
			echo "<td width='10%' align='center'>".Format::getTextDate($createDate)."</td>\n";
			
			if((intval($isAprove)==1))
			{	echo "<td width='10%' align='center'><img src='../img/ch36.png'></td>\n";
				echo "<td width='10%'>&nbsp;</td>\n";
			}else{
				echo "<td width='10%'>&nbsp;</td>\n";
				echo "<td width='10%' align='center'><img src='../img/ch36.png'></td>\n";
			}

			echo "<td width='10%' align='right'>".number_format($budget,2)."</td>\n";
			echo "</tr>\n";
		}

	}
?>
</table>
	</td>
</tr>
<tr>
	<td align='right'><?=number_format($sum,2)?></td>
</tr>
<tr>
	<td>
		<table width="100%">
			<tr>
				<td align="center" style='height:30px'>ลงชื่อผู้รับการพัฒนา
				</td>
			
				<td align="center">ลงชื่อผู้บังคับบัญชา
				</td>
			</tr>
			<tr>
				<td align="center" style='height:30px'>(...................................................................................)
				</td>
				<td align="center">(...................................................................................)
				</td>
			</tr>
				<tr>
				<td align="center" style='height:30px'>ตำแหน่ง....................................................................
				</td>
				<td align="center">ตำแหน่ง....................................................................
				</td>
			</tr>
			</tr>
				<tr>
				<td align="center" style='height:30px'>วันที่............../............................./...........................
				</td>
				<td align="center">วันที่............../............................./...........................
				</td>
			</tr>
		</table>
	</td>
</tr>


</table>
</form>
</html>

