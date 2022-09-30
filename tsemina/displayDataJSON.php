<?php
include_once "../config/database.php";
include_once "../objects/classLabel.php";
include_once "../objects/manage.php";
include_once "../objects/tsemina.php";
header("Access-Control-Allow-Origin: *");
header("Content-Type: html/text; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
$database = new Database();
$db = $database->getConnection();
$objLbl = new ClassLabel($db);
$objT=new tsemina($db);
$userCode=isset($_GET["userCode"])?$_GET["userCode"]:"";
//$path="tsemina/getData.php?userCode=".$userCode;
//$url=$cnf->restURL.$path;
//$api=new ClassAPI();
//$data=$api->getAPI($url);

$data=array();
$stmt = $objT->getData($userCode);
$num = $stmt->rowCount();

if($num>0){

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
				$objItem=array(
					"id"=>$id,
					"userCode"=>$userCode,
					"improveSkill"=>$improveSkill,
					"improveOpjective"=>$improveOpjective,
					"budget"=>$budget,
					"monthPlan"=>$monthPlan,
					"yearPlan"=>$yearPlan,
					"createDate"=>$createDate,
					"isAprove"=>$isAprove,
					"status"=>$status
				);
				array_push($data, $objItem);
			}
}



echo "<thead>";
		echo "<tr>";
			echo "<th>No.</th>";
			echo "<th>".$objLbl->getLabel("t_semina","improveSkill","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_semina","improveOpjective","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_semina","isAprove","TH")."</th>";

			echo "<th width=\"150px\">จัดการ</th>";
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
						if(intval($row["isAprove"])===2){
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
			echo '<td>'.$row["improveSkill"].'</td>';
			echo '<td>'.$row["improveOpjective"].'</td>';

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
