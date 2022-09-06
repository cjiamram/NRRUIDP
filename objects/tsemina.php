<?php
include_once "keyWord.php";
class  tsemina{
	private $conn;
	private $table_name="t_semina";
	public function __construct($db){
            $this->conn = $db;
        	}
	public $userCode;
	public $improveSkill;
	public $improveOpjective;
	public $budget;
	public $monthPlan;
	public $yearPlan;
	public $createDate;
	public $isAprove;
	public $departmentId;

	public function setAprove($id,$status){
		$query="UPDATE t_semina 
		SET 
		isAprove=:status 
		WHERE id=:id
		";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":status",$status);
		$stmt->bindParam(":id",$id);
		$flag=$stmt->execute();
		return $flag;
	}

	public function setSelfAction($id,$status,$message){
		$query="UPDATE t_semina 
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
		$query='INSERT INTO t_semina  
        	SET 
			userCode=:userCode,
			improveSkill=:improveSkill,
			improveOpjective=:improveOpjective,
			budget=:budget,
			monthPlan=:monthPlan,
			yearPlan=:yearPlan,
			createDate=:createDate,
			isAprove=:isAprove,
			departmentId=:departmentId
	';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":userCode",$this->userCode);
		$stmt->bindParam(":improveSkill",$this->improveSkill);
		$stmt->bindParam(":improveOpjective",$this->improveOpjective);
		$stmt->bindParam(":budget",$this->budget);
		$stmt->bindParam(":monthPlan",$this->monthPlan);
		$stmt->bindParam(":yearPlan",$this->yearPlan);
		$stmt->bindParam(":createDate",$this->createDate);
		$stmt->bindParam(":isAprove",$this->isAprove);
		$stmt->bindParam(":departmentId",$this->departmentId);

		$flag=$stmt->execute();
		return $flag;
	}
	public function update(){
		$query='UPDATE t_semina 
        	SET 
			userCode=:userCode,
			improveSkill=:improveSkill,
			improveOpjective=:improveOpjective,
			budget=:budget,
			monthPlan=:monthPlan,
			yearPlan=:yearPlan,
			createDate=:createDate,
			isAprove=:isAprove,
			departmentId=:departmentId
		 WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":userCode",$this->userCode);
		$stmt->bindParam(":improveSkill",$this->improveSkill);
		$stmt->bindParam(":improveOpjective",$this->improveOpjective);
		$stmt->bindParam(":budget",$this->budget);
		$stmt->bindParam(":monthPlan",$this->monthPlan);
		$stmt->bindParam(":yearPlan",$this->yearPlan);
		$stmt->bindParam(":createDate",$this->createDate);
		$stmt->bindParam(":isAprove",$this->isAprove);
		$stmt->bindParam(":departmentId",$this->departmentId);

		$stmt->bindParam(":id",$this->id);
		$flag=$stmt->execute();
		return $flag;
	}
	public function readOne(){
		$query='SELECT  id,
			userCode,
			improveSkill,
			improveOpjective,
			budget,
			monthPlan,
			yearPlan,
			createDate,
			isAprove
		FROM t_semina WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id',$this->id);
		$stmt->execute();
		return $stmt;
	}
	public function getData($userCode){
		$query='SELECT  A.id,
			A.userCode,
			A.improveSkill,
			A.improveOpjective,
			A.budget,
			A.monthPlan,
			A.yearPlan,
			A.createDate,
			A.isAprove,
			B.status
		FROM t_semina A LEFT OUTER JOIN t_status B 
		ON A.isAprove=B.code  
		WHERE A.userCode LIKE :userCode';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':userCode',$userCode);
		$stmt->execute();
		return $stmt;
	}
	function delete(){
		$query='DELETE FROM t_semina WHERE id=:id';
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
		$query ="SELECT MAX(CODE) AS MXCode FROM t_semina WHERE CODE LIKE ?";
		$stmt = $this->conn->prepare($query);
		$prefix="{$prefix}%";
		$stmt->bindParam(1, $prefix);
		$stmt->execute();
		return $stmt;
	}
}

?>