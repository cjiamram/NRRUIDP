<?php
	header("content-type:html/text;charset=UTF-8");

	include_once "../config/config.php";
	include_once "../lib/classAPI.php";
	include_once "../objects/manage.php";
	include_once "../objects/classLabel.php";
	include_once "../config/database.php";


	$database = new Database();
	$db = $database->getConnection();
	$objLbl = new ClassLabel($db);

	$cnf=new Config();
	$api=new ClassAPI();
	$departmentId=isset($_GET["departmentId"])?$_GET["departmentId"]:"";
	$keyWord=isset($_GET["keyWord"])?$_GET["keyWord"]:"";
	$path="retreiveData/getRequestReport.php?departmentId=".$departmentId."&keyWord=".$keyWord;
	//print_r($path);
		//$path="retreiveData/getData.php?departmentId=".$departmentId."&keyWord=".$keyWord;

	$url=$cnf->restURL.$path;
	//print_r($url);

	$data=$api->getAPI($url);

	echo "<thead>";
		echo "<tr>";
			echo "<th>No.</th>";
			echo "<th>".$objLbl->getLabel("t_mgmreport","fullName","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_mgmreport","pType","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_mgmreport","topic","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_mgmreport","budget","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_mgmreport","createDate","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_mgmreport","yearPlan","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_mgmreport","status","TH")."</th>";

			echo "<th>จัดการ</th>";
		echo "</tr>";
	echo "</thead>";
	if(!isset($data["message"])){
		echo "<tbody>\n";
		$i=1;
		foreach ($data as $row) {
			echo "<tr>\n";
			echo "<td>".$i++."</td>\n";
			echo "<td>".$row["fullName"]."</td>\n";
			echo "<td>".$row["pType"]."</td>\n";
			echo "<td>".$row["topic"]."</td>\n";
			echo "<td>".$row["budget"]."</td>\n";
			echo "<td>".Format::getTextDate($row["createDate"])."</td>\n";
			echo "<td>".$row["yearPlan"]."</td>\n";
			echo "<td>".$row["status"]."</td>\n";
			//print_r($row["planStatus"]);

			if(intval($row["planStatus"])==0){
			echo "<td>
				<button type='button' class='btn btn-info'
					onclick='getAprove(".$row['id'].",".$row['pTypeCode'].")'>
					<span class='fa fa-handshake-o'></span>
				</button></td>";
			}else{
				echo "<td>&nbsp;</td>\n";
			}
			echo "</tr>\n";
		}
		echo "</tbody>\n";
	}

?>
<script type="text/javascript">
	//setTablePage("#tblDisplay");
</script>