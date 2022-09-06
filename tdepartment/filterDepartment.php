<?php
header("content-type:text/html;charset=UTF-8");
include_once "../config/database.php";
include_once "../objects/tdepartment.php";

$database=new Database();
$db=$database->getConnection();

$obj=new tdepartment($db);
$stmt = $obj->getData();
$num = $stmt->rowCount();
$depArr="";
if($num>0){
$i=0;
echo "<table class=\"table table-bordered table-hover\">\n";
	while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
		extract($row);
		if(($i+1)%2!==0){
			echo "<tr>\n";
		}
		
		if($i<$num)
			$depArr.=$departmentId.",";
		else
			$depArr.=$departmentId;
		
		echo "<td><input type='checkbox' checked onclick='chooseDept()' id='chkD".$i."'><input type='hidden' id='dep".$i."' value='".$departmentId."'></td>\n";
		echo "<td>".$departmentName."</td>\n";
		if(($i+1)%2==0||$i==$num-1){
			echo "</tr>\n";
		}
		

		$i++;
	}	

echo "</table>\n";

}


?>

