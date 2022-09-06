<?php
header("content-type:text/html;charset=UTF-8");
include_once "../config/database.php";
include_once "../objects/tdepartment.php";

$database=new Database();
$db=$database->getConnection();

$obj=new tdepartment($db);
$stmt = $obj->getData();
$num = $stmt->rowCount();
if($num>0){
$i=0;

echo "<table class=\"table table-bordered table-hover\">\n";
	echo "<tr><td colspan='2'><input type='checkbox' id='chkAll' checked> All</td></tr>\n";
	while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
		extract($row);
		echo "<tr>\n";
		echo "<td><input type='checkbox' id='chkD".$i."'><input type='hidden' id='dep".$i."' value='".$departmentId."'></td>\n";
		echo "<td>".$departmentName."</td>\n";
		echo "</tr>\n";
		$i++;
	}	

echo "</table>\n";


}


?>