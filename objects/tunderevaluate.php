<?php
include_once "keyWord.php";
class  tunderevaluate{
	private $conn;
	private $table_name="t_underevaluate";
	public function __construct($db){
            $this->conn = $db;
        	}
	public $supervisorCode;
	public $userCode;
	public $createDate;
	public $departmentCode;
	public function create(){
		$query='INSERT INTO t_underevaluate  
        	SET 
			supervisorCode=:supervisorCode,
			userCode=:userCode,
			createDate=:createDate,
			departmentCode=:departmentCode
	';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":supervisorCode",$this->supervisorCode);
		$stmt->bindParam(":userCode",$this->userCode);
		$stmt->bindParam(":createDate",$this->createDate);
		$stmt->bindParam(":departmentCode",$this->departmentCode);
		$flag=$stmt->execute();
		return $flag;
	}
	public function update(){
		$query='UPDATE t_underevaluate 
        	SET 
			supervisorCode=:supervisorCode,
			userCode=:userCode,
			createDate=:createDate,
			departmentCode=:departmentCode
		 WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":supervisorCode",$this->supervisorCode);
		$stmt->bindParam(":userCode",$this->userCode);
		$stmt->bindParam(":createDate",$this->createDate);
		$stmt->bindParam(":departmentCode",$this->departmentCode);
		$stmt->bindParam(":id",$this->id);
		$flag=$stmt->execute();
		return $flag;
	}
	public function readOne(){
		$query='SELECT  id,
			supervisorCode,
			userCode,
			createDate,
			departmentCode
		FROM t_underevaluate WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id',$this->id);
		$stmt->execute();
		return $stmt;
	}

	public function getHasUnder($departmentCode){
		$query="SELECT COUNT(id) AS CNT FROM t_underevaluate 
		WHERE departmentCode=:departmentCode";
		$stmt=$this->conn->prepare($query);
		$stmt->bindParam(":departmentCode",$departmentCode);
		$stmt->execute();
		$row=$stmt->fetch(PDO::FETCH_ASSOC);
		extract($row);
		$flag=$CNT>0?true:false;
		return $flag;

	}


	public function deleteUser($userCode,$departmentCode){
		$query="DELETE FROM t_underevaluate 
		WHERE userCode=:userCode AND departmentCode=:departmentCode";
		$stmt=$this->conn->prepare($query);
		$stmt->bindParam(":userCode",$userCode);
		$stmt->bindParam(":departmentCode",$departmentCode);
		$flag=$stmt->execute();
		return $flag;
	}


	public function isUserExistBySuper($userCode,$supervisorCode){
		$query="SELECT COUNT(id) AS CNT FROM t_underevaluate 
		WHERE userCode=:userCode AND supervisorCode=:supervisorCode";
		$stmt=$this->conn->prepare($query);
		$stmt->bindParam(":userCode",$userCode);
		$stmt->bindParam(":supervisorCode",$supervisorCode);
		$stmt->execute();
		$row=$stmt->fetch(PDO::FETCH_ASSOC);
		extract($row);
		$flag=$CNT>0?true:false;
		return $flag;

	}


	public function isUserExist($userCode){
		$query="SELECT COUNT(id) AS CNT FROM t_underevaluate 
		WHERE userCode=:userCode";
		$stmt=$this->conn->prepare($query);
		$stmt->bindParam(":userCode",$userCode);
		$stmt->execute();
		$row=$stmt->fetch(PDO::FETCH_ASSOC);
		extract($row);
		$flag=$CNT>0?true:false;
		return $flag;

	}

	public function getData($departmentCode){
		$query='SELECT  id,
			supervisorCode,
			userCode,
			createDate,
			departmentCode
		FROM t_underevaluate WHERE departmentCode LIKE :departmentCode';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':departmentCode',$departmentCode);
		$stmt->execute();
		return $stmt;
	}
	function delete(){
		$query='DELETE FROM t_underevaluate WHERE id=:id';
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
		$query ="SELECT MAX(CODE) AS MXCode FROM t_underevaluate WHERE CODE LIKE ?";
		$stmt = $this->conn->prepare($query);
		$prefix="{$prefix}%";
		$stmt->bindParam(1, $prefix);
		$stmt->execute();
		return $stmt;
	}
}

?>