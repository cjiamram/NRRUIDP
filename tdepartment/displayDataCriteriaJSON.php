<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../config/config.php";
include_once "../config/database.php";
include_once "../objects/classLabel.php";
include_once "../objects/tdepartment.php";
$database = new Database();
$db = $database->getConnection();
$objLbl = new ClassLabel($db);
$obj = new tdepartment($db);
//$cnf=new Config();
$keyWord=isset($_GET["keyWord"])?$_GET["keyWord"]:"";
//$path="tdepartment/getDataCriteria.php?keyWord=".$keyword;
//$url=$cnf->restURL.$path;
//$api=new ClassAPI();
//$data=$api->getAPI($url);

$stmt = $obj->getDataCriteria($keyWord);
$num = $stmt->rowCount();
$data=array();
if($num>0){
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
				$objItem=array(
					"id"=>$id,
					"departmentCode"=>$departmentCode,
					"departmentName"=>$departmentName,
				);
				array_push($data, $objItem);
			}
}


echo "<thead>";
		echo "<tr>";
			echo "<th>No.</th>";
			echo "<th>".$objLbl->getLabel("t_department","departmentcode","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_department","departmentName","TH")."</th>";
			echo "<th>จัดการ</th>";
		echo "</tr>";
echo "</thead>";
if(count($data)>0){
echo "<tbody>";
$i=1;
foreach ($data as $row) {
		echo "<tr>";
			echo '<td>'.$i++.'</td>';
			echo '<td>'.$row["departmentCode"].'</td>';
			echo '<td>'.$row["departmentName"].'</td>';
			echo "<td>
			<button type='button' class='btn btn-info'
				onclick='loadData(".$row['id'].")'>
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
<script>
	tablePage("#tblDisplay");
</script>
