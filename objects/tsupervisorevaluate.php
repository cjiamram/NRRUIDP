<?php
include_once "keyWord.php";
class  tsupervisorevaluate{
	private $conn;
	private $table_name="t_supervisorevaluate";
	public function __construct($db){
            $this->conn = $db;
        	}
	public $userCode;
	public $departmentCode;
	public $evaluateLevel;
	public $depPosition;
	public $createDate;
	public $supervisorName;
	public $levelEvaluate;
	public function create(){
		$query='INSERT INTO t_supervisorevaluate  
        	SET 
			userCode=:userCode,
			departmentCode=:departmentCode,
			evaluateLevel=:evaluateLevel,
			depPosition=:depPosition,
			createDate=:createDate,
			supervisorName=:supervisorName
	';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":userCode",$this->userCode);
		$stmt->bindParam(":departmentCode",$this->departmentCode);
		$stmt->bindParam(":evaluateLevel",$this->evaluateLevel);
		$stmt->bindParam(":depPosition",$this->depPosition);
		$stmt->bindParam(":createDate",$this->createDate);
		$stmt->bindParam(":supervisorName",$this->supervisorName);
		//$stmt->bindParam(":levelEvaluate",$this->levelEvaluate);
		$flag=$stmt->execute();
		//print_r($stmt->errorInfo());
		return $flag;
	}
	
	public function getId($userCode){
		$query="SELECT id FROM t_supervisorevaluate 
		WHERE userCode=:userCode";
		$stmt=$this->conn->prepare($query);
		$stmt->bindParam(":userCode",$userCode);
		$stmt->execute();
		if($stmt->rowCount()>0){
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
			extract($row);
			return $id;
		}
		return 0;
	}


	public function getHasSupervisor($departmentCode,$level){
		$query="SELECT 
			id
		FROM t_supervisorevaluate 
		WHERE departmentCode=:departmentCode 
		AND evaluateLevel=:evaluateLevel
		 ";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":departmentCode",$departmentCode);
		$stmt->bindParam(":evaluateLevel",$level);

		$stmt->execute();
		$flag=$stmt->rowCount()?true:false;
		return $flag;
	}

	public function getSupervisor($departmentCode,$level){
		$query="SELECT
			id, 
			userCode,
			depPosition,
			supervisorName 
		FROM t_supervisorevaluate 
		WHERE departmentCode=:departmentCode 
		AND evaluateLevel=:evaluateLevel
		 ";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":departmentCode",$departmentCode);
		$stmt->bindParam(":evaluateLevel",$level);

		$stmt->execute();
		return $stmt;

	}

	public function update(){
		$query='UPDATE t_supervisorevaluate 
        	SET 
			userCode=:userCode,
			departmentCode=:departmentCode,
			evaluateLevel=:evaluateLevel,
			depPosition=:depPosition,
			createDate=:createDate,
			supervisorName=:supervisorName
		 WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":userCode",$this->userCode);
		$stmt->bindParam(":departmentCode",$this->departmentCode);
		$stmt->bindParam(":evaluateLevel",$this->evaluateLevel);
		$stmt->bindParam(":depPosition",$this->depPosition);
		$stmt->bindParam(":createDate",$this->createDate);
		$stmt->bindParam(":supervisorName",$this->supervisorName);
		//$stmt->bindParam(":levelEvaluate",$this->levelEvaluate);
		$stmt->bindParam(":id",$this->id);
		$flag=$stmt->execute();
		return $flag;
	}
	public function readOne(){
		$query='SELECT  id,
			userCode,
			departmentCode,
			evaluateLevel,
			depPosition,
			createDate,
			supervisorName,
			levelEvaluate
		FROM t_supervisorevaluate WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id',$this->id);
		$stmt->execute();
		return $stmt;
	}
	public function getData($keyWord){
		$query='SELECT  id,
			userCode,
			departmentCode,
			evaluateLevel,
			depPosition,
			createDate,
			supervisorName,
			evaluateLevel
		FROM t_supervisorevaluate 
		WHERE supervisorName LIKE :keyWord';
		$stmt = $this->conn->prepare($query);
		$keyWord="%{$keyWord}%";
		$stmt->bindParam(':keyWord',$keyWord);
		$stmt->execute();
		return $stmt;
	}
	
	function deleteByLevel($departmentCode,$levelEvaluate){
		$query="DELETE FROM t_supervisorevaluate 
		WHERE departmentCode=:departmentCode 
		AND levelEvaluate=:levelEvaluate";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':departmentCode',$departmentCode);
		$stmt->bindParam(':levelEvaluate',$levelEvaluate);
		$flag=$stmt->execute();
		return $flag;
	}

	function delete(){
		$query='DELETE FROM t_supervisorevaluate WHERE id=:id';
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
		$query ="SELECT MAX(CODE) AS MXCode FROM t_supervisorevaluate WHERE CODE LIKE ?";
		$stmt = $this->conn->prepare($query);
		$prefix="{$prefix}%";
		$stmt->bindParam(1, $prefix);
		$stmt->execute();
		return $stmt;
	}
}

?>