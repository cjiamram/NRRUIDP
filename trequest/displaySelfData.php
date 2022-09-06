<?php
session_start();
include_once "../config/config.php";
include_once "../lib/classAPI.php";
include_once "../config/database.php";
include_once "../objects/classLabel.php";
include_once "../objects/manage.php";
include_once "../objects/tprogressrequest.php";
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
$database = new Database();
$db = $database->getConnection();
$objLbl = new ClassLabel($db);
$cnf=new Config();
$userCode=isset($_GET["userCode"])?$_GET["userCode"]:"";
$path="trequest/getSelfData.php?userCode=".$userCode;
$url=$cnf->restURL.$path;
$api=new ClassAPI();
$data=$api->getAPI($url);

echo "<thead>";
		echo "<tr>\n";
			echo "<th>No.</th>\n";
			echo "<th>".$objLbl->getLabel("t_request","description","TH")."</th>\n";
			echo "<th>".$objLbl->getLabel("t_request","createDate","TH")."</th>\n";
			echo "<th>".$objLbl->getLabel("t_request","requestType","TH")."</th>\n";
			echo "<th>".$objLbl->getLabel("t_request","progressStatus","TH")."</th>\n";
		echo "</tr>\n";
echo "</thead>\n";
if(!isset($data["message"])){
echo "<tbody>\n";
$i=1;
foreach ($data as $row) {
		$strId="<input type='hidden' id='RID-".$i."' value='".$row["id"]."' >";
		echo "<tr>\n";
			echo '<td>'.$i.'</td>'.$strId."\n";
			echo '<td>'.$row["description"].'</td>'."\n";
			echo '<td>'.Format::getTextDate($row["createDate"]).'</td>'."\n";
			echo '<td>'.$row["requestType"].'</td>'."\n";
			echo '<td>'.$row["progressStatus"].'</td>'."\n";
			echo "</tr>\n";
			$i++;
}
echo "</tbody>\n";
}

?>
<script >
	tablePage("#tblProgress");	

</script>


