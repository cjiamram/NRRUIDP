<?php
include_once "keyWord.php";
class  theaderaproval{
	private $conn;
	private $table_name="t_headeraproval";
	public function __construct($db){
            $this->conn = $db;
        	}
	public $evaluateLevel;
	public $departmentCode;
	public $evaluateHeader;
	public $createDate;
	public $isActive;
	public $userCode;
	public $description;
	public function create(){
		$query='INSERT INTO t_headeraproval  
        	SET 
			evaluateLevel=:evaluateLevel,
			departmentCode=:departmentCode,
			evaluateHeader=:evaluateHeader,
			createDate=:createDate,
			isActive=:isActive,
			userCode=:userCode,
			description=:description
	';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":evaluateLevel",$this->evaluateLevel);
		$stmt->bindParam(":departmentCode",$this->departmentCode);
		$stmt->bindParam(":evaluateHeader",$this->evaluateHeader);
		$stmt->bindParam(":createDate",$this->createDate);
		$stmt->bindParam(":isActive",$this->isActive);
		$stmt->bindParam(":userCode",$this->userCode);
		$stmt->bindParam(":description",$this->description);
		$flag=$stmt->execute();
		return $flag;
	}
	public function update(){
		$query='UPDATE t_headeraproval 
        	SET 
			evaluateLevel=:evaluateLevel,
			departmentCode=:departmentCode,
			evaluateHeader=:evaluateHeader,
			createDate=:createDate,
			isActive=:isActive,
			userCode=:userCode,
			description=:description
		 WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":evaluateLevel",$this->evaluateLevel);
		$stmt->bindParam(":departmentCode",$this->departmentCode);
		$stmt->bindParam(":evaluateHeader",$this->evaluateHeader);
		$stmt->bindParam(":createDate",$this->createDate);
		$stmt->bindParam(":isActive",$this->isActive);
		$stmt->bindParam(":userCode",$this->userCode);
		$stmt->bindParam(":description",$this->description);
		$stmt->bindParam(":id",$this->id);
		$flag=$stmt->execute();
		return $flag;
	}
	public function readOne(){
		$query='SELECT  id,
			evaluateLevel,
			departmentCode,
			evaluateHeader,
			createDate,
			isActive,
			userCode,
			description
		FROM t_headeraproval WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id',$this->id);
		$stmt->execute();
		return $stmt;
	}
	public function getData($departmentCode){
		$query='SELECT  id,
			evaluateLevel,
			departmentCode,
			evaluateHeader,
			createDate,
			isActive,
			userCode,
			description
		FROM t_headeraproval WHERE departmentCode LIKE :departmentCode';
		$stmt = $this->conn->prepare($query);
		$departmentCode="%{$departmentCode}%";
		$stmt->bindParam(':departmentCode',$departmentCode);
		$stmt->execute();
		return $stmt;
	}
	function delete(){
		$query='DELETE FROM t_headeraproval WHERE id=:id';
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
		$query ="SELECT MAX(CODE) AS MXCode FROM t_headeraproval WHERE CODE LIKE ?";
		$stmt = $this->conn->prepare($query);
		$prefix="{$prefix}%";
		$stmt->bindParam(1, $prefix);
		$stmt->execute();
		return $stmt;
	}
}

?>