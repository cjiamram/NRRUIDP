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
$objProgress=new tprogressrequest($db);
$cnf=new Config();
$keyWord=isset($_GET["keyWord"])?$_GET["keyWord"]:"";
$path="trequest/getDataByAdmin.php?keyWord=".$keyWord;
$url=$cnf->restURL.$path;
$api=new ClassAPI();
$data=$api->getAPI($url);
$stmt=$objProgress->getData();



function getRProgress($stmt,$i,$refVal){
	$strRProgress="";
	//onchange='changeProgress(".$i.")'
	if($stmt->rowCount()>0){
		$strRProgress="<select class='form-control' onchange='changeProgress(".$i.")'  id='RT-".$i."'>\n";
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			if($code===$refVal)
				$strRProgress.="<option value='".$code."' selected>". $progressType  ."</option>\n";
			else
				$strRProgress.="<option value='".$code."'>". $progressType  ."</option>\n";

		}
		$strRProgress.="</select>\n";
	}
	return $strRProgress;
}

echo "<thead>";
		echo "<tr>\n";
			echo "<th>No.</th>\n";
			echo "<th>".$objLbl->getLabel("t_request","userCode","TH")."</th>\n";
			echo "<th>".$objLbl->getLabel("t_request","fullName","TH")."</th>\n";
			echo "<th>".$objLbl->getLabel("t_request","description","TH")."</th>\n";
			echo "<th>".$objLbl->getLabel("t_request","createDate","TH")."</th>\n";
			echo "<th>".$objLbl->getLabel("t_request","requestType","TH")."</th>\n";
			echo "<th>".$objLbl->getLabel("t_request","progressStatus","TH")."</th>\n";
			echo "<th>จัดการ</th>\n";
		echo "</tr>\n";
echo "</thead>\n";
if(!isset($data["message"])){
echo "<tbody>\n";
$i=1;
foreach ($data as $row) {
		$strId="<input type='hidden' id='RID-".$i."' value='".$row["id"]."' >";
		//onclick='modifyProgress(".$i.")'
		echo "<tr>\n";
			echo '<td>'.$i.'</td>'.$strId."\n";
			echo '<td>'.$row["userCode"].'</td>'."\n";
			echo '<td>'.$row["fullName"].'</td>'."\n";
			echo '<td>'.$row["description"].'</td>'."\n";
			echo '<td>'.Format::getTextDate($row["createDate"]).'</td>'."\n";
			echo '<td>'.$row["requestType"].'</td>'."\n";
			echo '<td>'.getRProgress($stmt,$i,$row["progressCode"]).'</td>'."\n";
			echo "<td>
			<button type='button' onclick='modifyProgress(".$i.")' class='btn btn-success'>
				<span class='fa fa-floppy-o'></span>
			</button>
			<button type='button' class='btn btn-info'
				onclick='readOne(".$row['id'].")'>
				<span class='fa fa-edit'></span>
			</button>
			<button type='button'
				class='btn btn-danger'
				onclick='confirmDelete(".$row['id'].")'>
				<span class='fa fa-trash'></span>
			</button>
			</td>\n";
			echo "</tr>\n";
			$i++;
}
echo "</tbody>\n";
}

?>


