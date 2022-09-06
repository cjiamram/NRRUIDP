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

	public function setAprove($id,$status){
		$query="UPDATE t_upposition 
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
			isAprove=0
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
		$query='UPDATE t_upposition 
        	SET 
			expertType=:expertType,
			yearPlan=:yearPlan,
			description=:description,
			userCode=:userCode,
			createDate=:createDate,
			departmentId=:departmentId,
			isAprove=0
		 WHERE id=:id';
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
		$query='SELECT  A.id,
			A.expertType,
			A.yearPlan,
			A.description,
			A.userCode,
			A.createDate,
			B.specialize
		FROM t_upposition A 
		LEFT OUTER JOIN t_specialize B ON 
		A.expertType =B.code  


		WHERE A.id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id',$this->id);
		$stmt->execute();
		return $stmt;
	}
	public function getData($userCode){
		$query='SELECT  
		    A.id,
		    A.expertType AS expertTypeCode,
			B.specialize AS expertType,
			A.yearPlan,
			A.description,
			A.userCode,
			A.createDate,
			A.isAprove,
			C.status
		FROM t_upposition A 
		LEFT OUTER JOIN t_specialize B 
		ON A.expertType=B.code 
		LEFT OUTER JOIN t_status C 
		ON A.isAprove=C.code 
		WHERE A.userCode LIKE :userCode';
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