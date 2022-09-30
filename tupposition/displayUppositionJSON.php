<?php
//include_once "../config/config.php";
include_once "../config/database.php";
include_once "../objects/classLabel.php";
include_once "../objects/manage.php";
include_once "../objects/tupposition.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: html/text; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
$database = new Database();
$db = $database->getConnection();
$objT=new tupposition($db);
$objLbl = new ClassLabel($db);
$userCode=isset($_GET["userCode"])?$_GET["userCode"]:"";

$stmt = $objT->getData($userCode);
$data=array();
if($stmt->rowCount()>0){
		$objArr=array();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
				$objItem=array(
					"id"=>$id,
					"expertType"=>$expertType,
					"yearPlan"=>$yearPlan,
					"description"=>$description,
					"userCode"=>$userCode,
					"createDate"=>$createDate,
					"status"=>$status,
					"isAprove"=>$isAprove
				);
				array_push($data, $objItem);
			}
}
echo "<thead>";
		echo "<tr>";
			echo "<th>No.</th>";
			echo "<th>".$objLbl->getLabel("t_upposition","expertType","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_upposition","yearPlan","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_upposition","isAprove","TH")."</th>";
			echo "<th width=\"200px\">จัดการ</th>";
		echo "</tr>";
echo "</thead>";
if(count($data)>0){
echo "<tbody>\n";
$i=1;
foreach ($data as $row) {
		echo "<tr>";
			echo '<td>'.$i++.'</td>'."\n";

						$isAprove =$objT->getLevelAprove(intval($row['id']));
						echo "<tr>";
						echo '<td>'.$i++.'</td>';
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

			echo '<td>'.$row["expertType"].'</td>'."\n";
			echo '<td>'.$row["yearPlan"].'</td>'."\n";
			$strT=$objT->getAproveLog(intval($row['id']));

			echo '<td>'.$strT.'</td>'."\n";
			echo '<td>'.$str.'</td>'."\n";

			
			echo "</tr>\n";
}
echo "</tbody>\n";
}
?>

<script>
		setTablePage("#tblDisplay",20);
</script>
