<?php
	session_start();
	header("content-type:text/html;charset=UTF-8");
	include_once "config/database.php";
	include_once "objects/data.php";
	include_once "objects/manage.php";
	include_once "lib/classAPI.php";

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
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <form class="form">        

<table width='700px' border="1">
<tr><td align="center">
	<h3><b>แผนพัฒนาบุคลากรรายบุคคล มหาวิทยาลัยราชภัฏนครราชสีมา</b></h3>
</td></tr>
<tr><td align="center">
	<h3><b>NRRU Individual Development Plan : IDP</b></h3>
</td></tr>
<tr>
	<td>
		<label>ส่วนที่ 1 ข้อมูลทั่วไป</label>
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
		<label>ส่วนที่ 2 แนวทางการพัฒนาบุคลากร</label>
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
	<td><label>2.1 ด้านการวางแผนการศึกษาต่อ</label></td>
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
			if($planStatus===1)
			{	echo "<td width='10%' align='center'><i class=\"fa fa-check\" aria-hidden=\"true\"></i></td>\n";
				echo "<td width='10%'>&nbsp;</td>\n";
			}else{
				echo "<td width='10%'>&nbsp;</td>\n";
				echo "<td width='10%' align='center'><i class=\"fa fa-check\" aria-hidden=\"true\"></i></td>\n";
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
	<td><label>2.2 ด้านการขอตำแหน่งที่สูงขึ้น</label></td>
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
			if($planStatus===1)
			{	echo "<td width='10%' align='center'><i class=\"fa fa-check\" aria-hidden=\"true\"></i></td>\n";
				echo "<td width='10%'>&nbsp;</td>\n";
			}else{
				echo "<td width='10%'>&nbsp;</td>\n";
				echo "<td width='10%' align='center'><i class=\"fa fa-check\" aria-hidden=\"true\"></i></td>\n";
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
	<td><label>2.3 ด้านศึกษาดูงาน</label></td>
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
			if($planStatus===1)
			{	echo "<td width='10%' align='center'><i class=\"fa fa-check\" aria-hidden=\"true\"></i></td>\n";
				echo "<td width='10%'>&nbsp;</td>\n";
			}else{
				echo "<td width='10%'>&nbsp;</td>\n";
				echo "<td width='10%' align='center'><i class=\"fa fa-check\" aria-hidden=\"true\"></i></td>\n";
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
	<td><label>2.4 ด้านการอบรม สัมมนา</label></td>
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
			if($planStatus===1)
			{	echo "<td width='10%' align='center'><i class=\"fa fa-check\" aria-hidden=\"true\"></i></td>\n";
				echo "<td width='10%'>&nbsp;</td>\n";
			}else{
				echo "<td width='10%'>&nbsp;</td>\n";
				echo "<td width='10%' align='center'><i class=\"fa fa-check\" aria-hidden=\"true\"></i></td>\n";
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
	<td><label>2.5 ด้านงานวิจัย</label></td>
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
			
			if($planStatus===1)
			{	echo "<td width='10%' align='center'><i class=\"fa fa-check\" aria-hidden=\"true\"></i></td>\n";
				echo "<td width='10%'>&nbsp;</td>\n";
			}else{
				echo "<td width='10%'>&nbsp;</td>\n";
				echo "<td width='10%' align='center'><i class=\"fa fa-check\" aria-hidden=\"true\"></i></td>\n";
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
				<td align="center" style='height:50px'>ลงชื่อผู้รับการพัฒนา
				</td>
			
				<td align="center">ลงชื่อผู้บังคับบัญชา
				</td>
			</tr>
			<tr>
				<td align="center" style='height:50px'>(...................................................................................)
				</td>
				<td align="center">(...................................................................................)
				</td>
			</tr>
				<tr>
				<td align="center" style='height:50px'>ตำแหน่ง....................................................................
				</td>
				<td align="center">ตำแหน่ง....................................................................
				</td>
			</tr>
			</tr>
				<tr>
				<td align="center" style='height:50px'>วันที่............../............................./...........................
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>  
<script>

  
$(document).ready(function () {  
    
    var form = $('.form'),  
    cache_width = form.width(),  
    a4 = [595.28, 841.89]; // for a4 size paper width and height  
      //a4 = [900.28, 841.89]; // for a4 size paper width and height  

    createPDF();

     function getCanvas() {  
        form.width((a4[0] * 1.33333) - 80).css('max-width', 'none');  
        return html2canvas(form, {  
            imageTimeout: 2000,  
            removeContainer: true  
        });  
    }

       function createPDF() {  
        getCanvas().then(function (canvas) {  
            var  
             img = canvas.toDataURL("image/png"),  
             doc = new jsPDF({  
                 unit: 'px',  
                 format: 'a4'  
             });  
            doc.addImage(img, 'JPEG', 20, 20);  
            doc.save('Bhavdip-html-to-pdf.pdf');  
            form.width(cache_width);  
        });  
    } 


   /* $('#create_pdf').on('click', function () {  
        $('body').scrollTop(0);  
        createPDF();  
    });  */
    
  
      
 
});
</script>
