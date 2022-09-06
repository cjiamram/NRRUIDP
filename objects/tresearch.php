<?php
include_once "keyWord.php";
class  tresearch{
	private $conn;
	private $table_name="t_research";
	public function __construct($db){
            $this->conn = $db;
        	}
	public $userCode;
	public $research;
	public $detail;
	public $createDate;
	public $yearPlan;
	public $isAprove;
	public $budget;
	public $budgetType;
	public $researchSource;
	public $departmentId;


	public function setAprove($id,$status){
		$query="UPDATE t_research 
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
		$query="UPDATE t_research 
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
		$query='INSERT INTO t_research  
        	SET 
			userCode=:userCode,
			research=:research,
			detail=:detail,
			createDate=:createDate,
			yearPlan=:yearPlan,
			isAprove=:isAprove,
			budget=:budget,
			budgetType=:budgetType,
			researchSource=:researchSource,
			departmentId=:departmentId
	';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":userCode",$this->userCode);
		$stmt->bindParam(":research",$this->research);
		$stmt->bindParam(":detail",$this->detail);
		$stmt->bindParam(":createDate",$this->createDate);
		$stmt->bindParam(":yearPlan",$this->yearPlan);
		$stmt->bindParam(":isAprove",$this->isAprove);
		$stmt->bindParam(":budget",$this->budget);
		$stmt->bindParam(":budgetType",$this->budgetType);
		$stmt->bindParam(":researchSource",$this->researchSource);
		$stmt->bindParam(":departmentId",$this->departmentId);

		$flag=$stmt->execute();
		return $flag;
	}
	public function update(){
		$query='UPDATE t_research 
        	SET 
			userCode=:userCode,
			research=:research,
			detail=:detail,
			createDate=:createDate,
			yearPlan=:yearPlan,
			isAprove=:isAprove,
			budget=:budget,
			budgetType=:budgetType,
			researchSource=:researchSource,
			departmentId=:departmentId
		 WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":userCode",$this->userCode);
		$stmt->bindParam(":research",$this->research);
		$stmt->bindParam(":detail",$this->detail);
		$stmt->bindParam(":createDate",$this->createDate);
		$stmt->bindParam(":yearPlan",$this->yearPlan);
		$stmt->bindParam(":isAprove",$this->isAprove);
		$stmt->bindParam(":budget",$this->budget);
		$stmt->bindParam(":budgetType",$this->budgetType);
		$stmt->bindParam(":researchSource",$this->researchSource);
		$stmt->bindParam(":departmentId",$this->departmentId);

		$stmt->bindParam(":id",$this->id);
		$flag=$stmt->execute();
		return $flag;
	}
	public function readOne(){
		$query='SELECT  id,
			userCode,
			research,
			detail,
			createDate,
			yearPlan,
			isAprove,
			budget,
			budgetType,
			researchSource
		FROM t_research WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id',$this->id);
		$stmt->execute();
		return $stmt;
	}
	public function getData($userCode){
		$query='SELECT  A.id,
			A.userCode,
			A.research,
			A.detail,
			A.createDate,
			A.yearPlan,
			A.isAprove,
			A.budget,
			B.sourceType AS budgetType,
			A.researchSource,
			C.status
		FROM t_research A LEFT OUTER JOIN 
		t_sourcetype B ON A.budgetType =B.code
		LEFT OUTER JOIN t_status C
		ON A.isAprove=C.code
		WHERE A.userCode LIKE :userCode';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':userCode',$userCode);
		$stmt->execute();
		return $stmt;
	}
	function delete(){
		$query='DELETE FROM t_research WHERE id=:id';
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
		$query ="SELECT MAX(CODE) AS MXCode FROM t_research WHERE CODE LIKE ?";
		$stmt = $this->conn->prepare($query);
		$prefix="{$prefix}%";
		$stmt->bindParam(1, $prefix);
		$stmt->execute();
		return $stmt;
	}
}

?>