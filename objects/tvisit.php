<?php
include_once "keyWord.php";
class  tvisit{
	private $conn;
	private $table_name="t_visit";
	public function __construct($db){
            $this->conn = $db;
        	}
    public $userCode;
	public $visitObjective;
	public $projectDetail;
	public $expectation;
	public $budget;
	public $joinGroup;
	public $yearPlan;
	public $createDate;
	public $duration;
	public $monthPlan;
	public $fileAttach;
	public $isAprove;
	public $visitSite;
	public $departmentId;
	public $message;
	public $levelStatus;


	public function setAprove($id,$status){
		$query="UPDATE t_visit 
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

	 public function getAproveLog($id){
		$query="SELECT DISTINCT
				A.isAprove,
				A.levelStatus AS levelStatusCode,
				B.status,
				C.levelStatus, 
				E.fullName AS aproveBy
		FROM t_visit  A 
		INNER JOIN t_status B 
		ON A.isAprove=B.code 
		INNER JOIN t_levelstatus C ON A.levelStatus-1=C.code
		INNER JOIN t_supervisoraprove D ON A.id=D.idRequest
		INNER JOIN t_fullname E ON D.supervisorCode=E.`userCode` 
		WHERE A.id=:id";
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
				$strT.= "<td width='50px'>".$i++."</td>\n";
				$strT.= "<td>".$row["status"]."</td>\n";
				$strT.= "<td>".$row["levelStatus"]."</td>\n";
				$strT.= "<td>".$row["aproveBy"]."</td>\n";
				$strT.= "</tr>\n";
			}
			$strT.="</table>\n";
			return $strT;

		}

		return "";
	}

	public function getAproveStatus($id){
		$query="SELECT 
			A.isAprove,
			A.levelStatus,
			B.status,
			C.levelStatus 
		FROM t_visit A 
		INNER JOIN t_status B 
		ON A.isAprove=B.code 
		INNER JOIN t_levelstatus C ON A.levelStatus-1=C.code
		WHERE A.id=:id";
		$stmt=$this->conn->prepare($query);
		$stmt->bindParam(":id",$id);
		$stmt->execute();
		if($stmt->rowCount()>0){
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
			extract($row);
			return $status."->ประเมินโดย :".$levelStatus;
		}
			return "";
	}

	public function getLevelAprove($idRequest){
		$query="SELECT 
			MAX(levelWork) AS MxId 
		FROM t_supervisoraprove 
		WHERE 
			workType=4 AND 
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
		$query="UPDATE t_visit 
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
		$query="INSERT INTO t_visit  
        	SET 
					userCode=:userCode,
					visitObjective=:visitObjective,
					projectDetail=:projectDetail,
					expectation=:expectation,
					budget=:budget,
					joinGroup=:joinGroup,
					yearPlan=:yearPlan,
					createDate=:createDate,
					duration=:duration,
					monthPlan=:monthPlan,
					fileAttach=:fileAttach,
					isAprove=:isAprove,
					visitSite=:visitSite,
					departmentId=:departmentId";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":userCode",$this->userCode);
		$stmt->bindParam(":visitObjective",$this->visitObjective);
		$stmt->bindParam(":projectDetail",$this->projectDetail);
		$stmt->bindParam(":expectation",$this->expectation);
		$stmt->bindParam(":budget",$this->budget);
		$stmt->bindParam(":joinGroup",$this->joinGroup);
		$stmt->bindParam(":yearPlan",$this->yearPlan);
		$stmt->bindParam(":createDate",$this->createDate);
		$stmt->bindParam(":duration",$this->duration);
		$stmt->bindParam(":monthPlan",$this->monthPlan);
		$stmt->bindParam(":fileAttach",$this->fileAttach);
		$stmt->bindParam(":isAprove",$this->isAprove);
		$stmt->bindParam(":visitSite",$this->visitSite);
		$stmt->bindParam(":departmentId",$this->departmentId);
		$flag=$stmt->execute();
		return $flag;
	}
	public function update(){
		$query='UPDATE t_visit 
        	SET 
				userCode=:userCode,
				visitObjective=:visitObjective,
				projectDetail=:projectDetail,
				expectation=:expectation,
				budget=:budget,
				joinGroup=:joinGroup,
				yearPlan=:yearPlan,
				createDate=:createDate,
				duration=:duration,
				monthPlan=:monthPlan,
				fileAttach=:fileAttach,
				isAprove=:isAprove,
				visitSite=:visitSite,
				departmentId=:departmentId
		 WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":userCode",$this->userCode);
		$stmt->bindParam(":visitObjective",$this->visitObjective);
		$stmt->bindParam(":projectDetail",$this->projectDetail);
		$stmt->bindParam(":expectation",$this->expectation);
		$stmt->bindParam(":budget",$this->budget);
		$stmt->bindParam(":joinGroup",$this->joinGroup);
		$stmt->bindParam(":yearPlan",$this->yearPlan);
		$stmt->bindParam(":createDate",$this->createDate);
		$stmt->bindParam(":duration",$this->duration);
		$stmt->bindParam(":monthPlan",$this->monthPlan);
		$stmt->bindParam(":fileAttach",$this->fileAttach);
		$stmt->bindParam(":isAprove",$this->isAprove);
		$stmt->bindParam(":visitSite",$this->visitSite);
		$stmt->bindParam(":departmentId",$this->departmentId);

		$stmt->bindParam(":id",$this->id);
		$flag=$stmt->execute();
		return $flag;
	}
	public function readOne(){
		$query='SELECT  id,
			userCode,
			visitObjective,
			projectDetail,
			expectation,
			budget,
			joinGroup,
			yearPlan,
			createDate,
			duration,
			monthPlan,
			fileAttach,
			isAprove,
			visitSite
		FROM t_visit WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id',$this->id);
		$stmt->execute();
		return $stmt;
	}
	public function getData($userCode){
		$query='SELECT  
			A.id,
			A.userCode,
			A.visitObjective,
			A.projectDetail,
			A.expectation,
			A.budget,
			A.joinGroup,
			A.yearPlan,
			A.createDate,
			A.duration,
			A.monthPlan,
			A.fileAttach,
			A.isAprove,
			A.visitSite,
			B.status,
			A.levelStatus

		FROM t_visit A LEFT OUTER JOIN t_status B  
		ON A.isAprove=B.code
		WHERE A.userCode LIKE :userCode';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':userCode',$userCode);
		$stmt->execute();
		return $stmt;
	}
	function delete(){
		$query='DELETE FROM t_visit WHERE id=:id';
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
		$query ="SELECT MAX(CODE) AS MXCode FROM t_visit WHERE CODE LIKE ?";
		$stmt = $this->conn->prepare($query);
		$prefix="{$prefix}%";
		$stmt->bindParam(1, $prefix);
		$stmt->execute();
		return $stmt;
	}
}

?>