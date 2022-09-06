<?php
	header("content-type:text/html;charset=UTF-8");
	include_once "../config/database.php";
	include_once "../objects/tstaffmigrate.php";

	$database=new Database();
	$db=$database->getConnection();
	$obj=new tstaffmigrate($db);
	$keyWord=isset($_GET["keyWord"])?$_GET["keyWord"]:"";
	$stmt=$obj->getDataByUser($keyWord);
	if($stmt->rowCount()>0){
		
		$i=0;
		echo "<thead>\n";
		echo "<th>No.</th>\n";
		echo "<th>userCode</th>\n";
		echo "<th>ชื่อสกุล</th>\n";
		echo "<th>เลือก</th>\n";
		echo "</thead>\n";
		echo "<tbody>\n";
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			echo "<tr>\n";
			echo "<td>".($i++)."</td>\n";
			echo "<td>".$userCode."</td>\n";
			echo "<td>".$stafffullname."</td>\n";
			$str="<div class=\"col-sm-12\">
				<button type='button'
					class='btn btn-primary'
					onclick=\"chooseSupervisor('".$userCode."','".$stafffullname."')\">
					<span class='fa fa-hand-pointer-o'></span>
				</button></div>";


			echo "<td>".$str."</td>\n";
			echo "</tr>\n";
		}
		echo "</tbody>\n";

	}



?>

<script>
	setTablePage("#tblSearch",10);
</script>