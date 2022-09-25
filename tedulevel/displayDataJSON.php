<?php
//include_once "../config/config.php";
//include_once "../lib/classAPI.php";
include_once "../config/database.php";
include_once "../objects/classLabel.php";
include_once "../objects/tedulevel.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
$database = new Database();
$db = $database->getConnection();
$objLbl = new ClassLabel($db);
//$cnf=new Config();
$keyword=isset($_GET["keyWord"])?$_GET["keyWord"]:"";
//$path="tedulevel/getData.php?keyWord=".$keyword;
//$url=$cnf->restURL.$path;
//$api=new ClassAPI();
$obj = new tedulevel($db);
$data=array();
$stmt = $obj->getData();
$num = $stmt->rowCount();

if($num>0){
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
				$objItem=array(
					"id"=>$id,
					"levelCode"=>$levelCode,
					"educationLevel"=>$educationLevel,
				);
				array_push($data, $objItem);
			}
}






echo "<thead>";
		echo "<tr>";
			echo "<th>No.</th>";
			echo "<th>".$objLbl->getLabel("t_edulevel","levelCode","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_edulevel","educationLevel","TH")."</th>";
			echo "<th>จัดการ</th>";
		echo "</tr>";
echo "</thead>";
if($data!=""){
echo "<tbody>";
$i=1;
foreach ($data as $row) {
		echo "<tr>";
			echo '<td>'.$i++.'</td>';
			echo '<td>'.$row["levelCode"].'</td>';
			echo '<td>'.$row["educationLevel"].'</td>';
			echo "<td>
			<button type='button' class='btn btn-info'
				data-toggle='modal' data-target='#modal-input'
				onclick='readOne(".$row['id'].")'>
				<span class='fa fa-edit'></span>
			</button>
			<button type='button'
				class='btn btn-danger'
				onclick='confirmDelete(".$row['id'].")'>
				<span class='fa fa-trash'></span>
			</button></td>";
			echo "</tr>";
}
echo "</tbody>";
}
?>
