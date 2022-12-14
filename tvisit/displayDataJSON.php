<?php
include_once "../config/database.php";
include_once "../objects/classLabel.php";
include_once "../objects/tvisit.php";
header("Access-Control-Allow-Origin: *");
header("Content-Type: html/text; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
$database = new Database();
$db = $database->getConnection();
$objT= new tvisit($db);
$objLbl = new ClassLabel($db);
$userCode=isset($_GET["userCode"])?$_GET["userCode"]:"";



$stmt = $objT->getData($userCode);
$num = $stmt->rowCount();
$data=array();
if($num>0){
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
				$objItem=array(
					"id"=>$id,
					"visitObjective"=>$visitObjective,
					"projectDetail"=>$projectDetail,
					"expectation"=>$expectation,
					"budget"=>$budget,
					"joinGroup"=>$joinGroup,
					"yearPlan"=>$yearPlan,
					"createDate"=>$createDate,
					"duration"=>$duration,
					"monthPlan"=>$monthPlan,
					"fileAttach"=>$fileAttach,
					"isAprove"=>$isAprove,
					"status"=>$status
				);
				array_push($data, $objItem);
		}
}


echo "<thead>";
		echo "<tr>";
			echo "<th>No.</th>";
			echo "<th>".$objLbl->getLabel("t_visit","visitObjective","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_visit","projectDetail","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_visit","expectation","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_visit","isAprove","TH")."</th>";
			echo "<th width=\"200px\">จัดการ</th>";
		echo "</tr>";
echo "</thead>";
if(count($data)>0){
echo "<tbody>";
$i=1;
foreach ($data as $row) {
		echo "<tr>";
			
						$isAprove =$objT->getLevelAprove(intval($row['id']));
						
						$str="";
					
						if($isAprove===0 && intval($row["isAprove"])===0){
							$str="<div class='col-sm-12'>
									<button type='button' class='btn btn-info'
									onclick='readOne(".$row['id'].")'>
									<span class='fa fa-edit'></span>
									</button>
									<button type='button'
									class='btn btn-danger'
									onclick='confirmDelete(".$row['id'].")'>
									<span class='fa fa-trash'></span>
									</button></div>";
						}
						else
						if($isAprove===1 && intval($row["isAprove"])===1){
							$str="<div class='col-sm-12'><button type='button' class='btn btn-success'
									onclick='readOneView(".$row['id'].")'>
									<span class='fa fa-eye'></span></div>";	
						}

						else
					
						
						if($isAprove>=2&& intval($row["isAprove"])>=1){
							$str="<div class='col-sm-12'>
							<button type='button' class='btn btn-success'
							onclick='readOneView(".$row['id'].")'>
							<span class='fa fa-eye'></span>
							<button type='button' class='btn btn-warning'
							onclick='loadStatus(".$row['id'].")'>
							<span class='fa fa-flag'></span>
							</button></div>";
						}

						else
						if(intval($row["isAprove"])===2)

						{
							/*$str="<div class='col-sm-12'>
									
									<button type='button'
									class='btn btn-danger'
									onclick='confirmDelete(".$row['id'].")'>
									<span class='fa fa-trash'></span>
									</button></div>";*/
								$str="<div class='col-sm-12'><button type='button' class='btn btn-success'
									onclick='readOneView(".$row['id'].")'>
									<span class='fa fa-eye'></span></div>";
						}
						else{
							$str="<div class='col-sm-12'><button type='button' class='btn btn-success'
									onclick='readOneView(".$row['id'].")'>
									<span class='fa fa-eye'></span></div>";
						}

			echo '<td>'.$i++.'</td>';
			//echo '<td>'.$isAprove."-".$row["isAprove"].'</td>';
			echo '<td>'.$row["visitObjective"].'</td>';
			echo '<td>'.$row["projectDetail"].'</td>';
			echo '<td>'.$row["expectation"].'</td>';
			$strT=$objT->getAproveLog(intval($row['id']));
			echo '<td>'.$strT.'</td>';
			echo '<td>'.$str.'</td>';

			echo "</tr>";
}
echo "</tbody>";
}
?>

<script>
	setTablePage("#tblDisplay",20);
</script>
