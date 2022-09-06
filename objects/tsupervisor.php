<?php
include_once "keyWord.php";
class  tsupervisor{
	private $conn;
	private $table_name="t_supervisor";
	public function __construct($db){
            $this->conn = $db;
        	}
	public $userCode;
	public $departmentId;
	public $fullName;
	public function create(){
		$query='INSERT INTO t_supervisor  
        	SET 
			userCode=:userCode,
			departmentId=:departmentId,
			fullName=:fullName
	';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":userCode",$this->userCode);
		$stmt->bindParam(":departmentId",$this->departmentId);
		$stmt->bindParam(":fullName",$this->fullName);
		$flag=$stmt->execute();
		return $flag;
	}
	public function update(){
		$query='UPDATE t_supervisor 
        	SET 
			userCode=:userCode,
			departmentId=:departmentId,
			fullName=:fullName
		 WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":userCode",$this->userCode);
		$stmt->bindParam(":departmentId",$this->departmentId);
		$stmt->bindParam(":fullName",$this->fullName);
		$stmt->bindParam(":id",$this->id);
		$flag=$stmt->execute();
		return $flag;
	}
	public function readOne(){
		$query='SELECT  id,
			userCode,
			departmentId,
			fullName
		FROM t_supervisor WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id',$this->id);
		$stmt->execute();
		return $stmt;
	}
	public function getData($keyWord){
		$query='SELECT  A.id,
			A.userCode,
			A.departmentId,
			A.fullName,
			B.departmentName
		FROM t_supervisor A 
		LEFT OUTER JOIN t_department B 
		ON A.departmentId=B.departmentId
		WHERE A.fullName LIKE :keyWord';
		$stmt = $this->conn->prepare($query);
		$keyWord="%{$keyWord}%";
		$stmt->bindParam(':keyWord',$keyWord);
		$stmt->execute();
		return $stmt;
	}
	function delete(){
		$query='DELETE FROM t_supervisor WHERE id=:id';
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
		$query ="SELECT MAX(CODE) AS MXCode FROM t_supervisor WHERE CODE LIKE ?";
		$stmt = $this->conn->prepare($query);
		$prefix="{$prefix}%";
		$stmt->bindParam(1, $prefix);
		$stmt->execute();
		return $stmt;
	}
}

?>