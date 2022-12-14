<?php
include_once "keyWord.php";
class  tupposition{
	private $conn;
	private $table_name="t_upposition";
	public function __construct($db){
            $this->conn = $db;
        	}
	public $expertType;
	public $yearPlan;
	public $description;
	public $userCode;
	public $createDate;
	public $departmentId;
	public $isAprove;
	public $levelStatus;

	public function setAprove($id,$status){
		$query="UPDATE t_upposition 
		SET 
		isAprove=:status,
		levelStatus=levelStatus+1 
		WHERE id=:id
		";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":status",$status);
		$stmt->bindParam(":id",$id);
		$flag=$stmt->execute();
		return $flag;
	}

	public function getAproveStatus($id){

		$query="SELECT V.isAprove,
		L.code AS levelStatusCode,
		V.status,
		V.aproveBy,
		L.`levelStatus`
		FROM 

		(SELECT DISTINCT
			A.isAprove,
			B.status,
			E.fullName AS aproveBy,
			D.`levelWork`
		FROM t_upposition  A 
			INNER JOIN t_status B 
			ON A.isAprove=B.code 
			INNER JOIN t_levelstatus C ON A.levelStatus-1=C.code
			INNER JOIN t_supervisoraprove D ON A.id=D.idRequest
			INNER JOIN t_fullname E ON D.supervisorCode=E.`userCode` 
			WHERE A.id=:id
		) AS V  
		INNER JOIN   t_levelstatus L  
		ON V.levelWork=L.code";
		$stmt->execute();
		if($stmt->rowCount()>0){
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
			extract($row);
			return $status."->ประเมินโดย :".$levelStatus;
		}
			return "";
	}

	

	public function getAproveLog($id){

		$query="SELECT DISTINCT V.isAprove,
		L.code AS levelStatusCode,
		V.status,
		V.aproveBy,
		L.`levelStatus`,
		V.notification
		FROM 

		(SELECT DISTINCT
			A.isAprove,
			B.status,
			E.fullName AS aproveBy,
			D.`levelWork`,
			D.notification
		FROM t_upposition  A 
			INNER JOIN t_status B 
			ON A.isAprove=B.code 
			INNER JOIN t_levelstatus C ON A.levelStatus-1=C.code
			INNER JOIN t_supervisoraprove D ON A.id=D.idRequest
			INNER JOIN t_fullname E ON D.supervisorCode=E.`userCode` 
			WHERE A.id=:id AND D.worktype=3
		) AS V  
		INNER JOIN   t_levelstatus L  
		ON V.levelWork=L.code";
		$stmt=$this->conn->prepare($query);
		$stmt->bindParam(":id",$id);
		$stmt->execute();
		$i=1;
		if($stmt->rowCount()>0){
			$strT="<table width='100%' style='width:100%;' border='1'>\n";
			$strT.="<tr>\n";
				$strT.= "<th width='50px'>No.</th>\n";
				$strT.= "<th>สถานะ</th>\n";
				$strT.= "<th>ลำดับขั้น</th>\n";
				$strT.= "<th>ผู้อนุมัติ</th>\n";
			$strT.="</tr>\n";
			while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
				$strT.= "<tr>\n";
				$strT.= "<td width='50px' align='center'>".$i++."</td>\n";
				$strT.= "<td><a href='#'  title='".$notification."'>".$row["status"]."</a></td>\n";
				$strT.= "<td>".$row["levelStatus"]."</td>\n";
				$strT.= "<td>".$row["aproveBy"]."</td>\n";
				$strT.= "</tr>\n";
			}
			$strT.="</table>\n";
			return $strT;

		}

		return "";
	}

	public function getLevelAprove($idRequest){
		$query="SELECT 
			MAX(levelWork) AS MxId 
		FROM t_supervisoraprove 
		WHERE 
			workType=3 AND 
			idRequest=:idRequest AND 
			statusAprove=1";
		$stmt=$this->conn->prepare($query);
		$stmt->bindParam(":idRequest",$idRequest);
		$stmt->execute();
		$row=$stmt->fetch(PDO::FETCH_ASSOC);
		extract($row);
		$mxId=intval($MxId);
		return $mxId; 

	}

	public function setSelfAction($id,$status,$message){
		$query="UPDATE t_upposition 
		SET 
		isAprove=:status,
		message=:message 
		WHERE id=:id
		";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":status",$status);
		$stmt->bindParam(":message",$message);
		$stmt->bindParam(":id",$id);
		$flag=$stmt->execute();
		return $flag;
	}

	public function create(){
		$query='INSERT INTO t_upposition  
        	SET 
			expertType=:expertType,
			yearPlan=:yearPlan,
			description=:description,
			userCode=:userCode,
			createDate=:createDate,
			departmentId=:departmentId,
			isAprove=0,
			levelStatus=1
	';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":expertType",$this->expertType);
		$stmt->bindParam(":yearPlan",$this->yearPlan);
		$stmt->bindParam(":description",$this->description);
		$stmt->bindParam(":userCode",$this->userCode);
		$stmt->bindParam(":createDate",$this->createDate);
		$stmt->bindParam(":departmentId",$this->departmentId);

		$flag=$stmt->execute();
		return $flag;
	}
	public function update(){
		$query="UPDATE t_upposition 
        	SET 
			expertType=:expertType,
			yearPlan=:yearPlan,
			description=:description,
			userCode=:userCode,
			createDate=:createDate,
			departmentId=:departmentId,
			isAprove=0
		 WHERE id=:id";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":expertType",$this->expertType);
		$stmt->bindParam(":yearPlan",$this->yearPlan);
		$stmt->bindParam(":description",$this->description);
		$stmt->bindParam(":userCode",$this->userCode);
		$stmt->bindParam(":createDate",$this->createDate);
		$stmt->bindParam(":departmentId",$this->departmentId);
		$stmt->bindParam(":id",$this->id);
		$flag=$stmt->execute();
		return $flag;
	}
	public function readOne(){
		$query="SELECT  A.id,
			A.expertType,
			A.yearPlan,
			A.description,
			A.userCode,
			A.createDate,
			B.specialize
		FROM t_upposition A 
		LEFT OUTER JOIN t_specialize B ON 
		A.expertType =B.code  
		WHERE A.id=:id";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id',$this->id);
		$stmt->execute();
		return $stmt;
	}
	public function getData($userCode){
		$query="SELECT  
		    A.id,
		    A.expertType AS expertTypeCode,
			B.specialize AS expertType,
			A.yearPlan,
			A.description,
			A.userCode,
			A.createDate,
			A.isAprove,
			C.status,
			A.levelStatus
		FROM t_upposition A 
		LEFT OUTER JOIN t_specialize B 
		ON A.expertType=B.code 
		LEFT OUTER JOIN t_status C 
		ON A.isAprove=C.code 
		WHERE A.userCode LIKE :userCode";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':userCode',$userCode);
		$stmt->execute();
		return $stmt;
	}
	function delete(){
		$query='DELETE FROM t_upposition WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id',$this->id);
		$flag=$stmt->execute();
		return $flag;
	}
	public function genCode(){
		$curYear = date("Y")-2000+543;
		$curYear = substr($curYear,1,2);
		$curYear = sprintf("%02d", $curYear);
		$curMonth=date("n");
		$curMonth = sprintf("%02d",$curMonth);
		$prefix= $curYear .$curMonth;
		$query ="SELECT MAX(CODE) AS MXCode FROM t_upposition WHERE CODE LIKE ?";
		$stmt = $this->conn->prepare($query);
		$prefix="{$prefix}%";
		$stmt->bindParam(1, $prefix);
		$stmt->execute();
		return $stmt;
	}
}

?>