
<?php
			include_once "../config/config.php";
			include_once "../config/database.php";
			include_once "../objects/classLabel.php";
			include_once "../objects/tacademicplan.php";

			header("Access-Control-Allow-Origin: *");
			header("Content-Type: html/text; charset=UTF-8");
			header("Access-Control-Allow-Methods: POST");
			header("Access-Control-Max-Age: 3600");
			header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");

			$userCode=isset($_GET["userCode"])?$_GET["userCode"]:"";

			$database = new Database();
			$db = $database->getConnection();
			$objLbl = new ClassLabel($db);
			$objT=new tacademicplan($db);

		

			$stmt = $objT->getData($userCode);
			$num = $stmt->rowCount();
			$data=array();
			if($num>0){
				
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
						extract($row);
						$objItem=array(
							"id"=>$id,
							"userCode"=>$userCode,
							"educationPlan"=>$educationPlan,
							"degree"=>$degree,
							"eduCertificate"=>$eduCertificate,
							"budget"=>$budget,
							"yearPlan"=>$yearPlan,
							"fundSource"=>$fundSource,
							"sourceType"=>$sourceType,
							"createDate"=>$createDate,
							"isAprove"=>$isAprove,
							"university"=>$university,
							"description"=>$description,
							"status"=>$status,
							"duration"=>$duration,
							"eduType"=>$eduType
						);
						array_push($data, $objItem);

				}

			}







			echo "<thead>";
					echo "<tr>";
						echo "<th>No.</th>";
						echo "<th>".$objLbl->getLabel("t_academicplan","educationPlan","TH")."</th>";
						echo "<th>".$objLbl->getLabel("t_academicplan","degree","TH")."</th>";
						echo "<th>".$objLbl->getLabel("t_academicplan","yearPlan","TH")."/".$objLbl->getLabel("t_academicplan","budget","TH")."</th>";
						echo "<th>".$objLbl->getLabel("t_academicplan","university","TH")."</th>";
						echo "<th>ลำดับขั้นการอนุมัติ</th>\n";
						echo "<th width=\"150px\">จัดการ</th>";

					echo "</tr>";
			echo "</thead>";
			if(count($data)>0){
			echo "<tbody>";
			$i=1;

			foreach ($data as $row) {
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
						}else
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

				
						echo '<td><div class="col-sm-12">'.$row["educationPlan"].'</div></td>'."\n";
						echo '<td>'.$row["degree"].'</td>';
						echo '<td>'.$row["yearPlan"]."/".number_format($row["budget"],2).'</td>'."\n";
						echo '<td>'.$row["university"].'</td>'."\n";
						echo '<td>'.$objT->getAproveLog(intval($row['id'])).'</td>';
						echo '<td>'.$str.'</td>';
						echo "</tr>";
			}
			echo "</tbody>";
			}
?>

<script>
	setTablePage("#tblDisplay");

</script>
