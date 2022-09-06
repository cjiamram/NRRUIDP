<?php
include_once "keyWord.php";
class  tedulevel{
	private $conn;
	private $table_name="t_edulevel";
	public function __construct($db){
            $this->conn = $db;
        	}
	public $levelCode;
	public $educationLevel;
	public function create(){
		$query='INSERT INTO t_edulevel  
        	SET 
			levelCode=:levelCode,
			educationLevel=:educationLevel
	';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":levelCode",$this->levelCode);
		$stmt->bindParam(":educationLevel",$this->educationLevel);
		$flag=$stmt->execute();
		return $flag;
	}
	public function update(){
		$query='UPDATE t_edulevel 
        	SET 
			levelCode=:levelCode,
			educationLevel=:educationLevel
		 WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":levelCode",$this->levelCode);
		$stmt->bindParam(":educationLevel",$this->educationLevel);
		$stmt->bindParam(":id",$this->id);
		$flag=$stmt->execute();
		return $flag;
	}
	public function readOne(){
		$query='SELECT  id,
			levelCode,
			educationLevel
		FROM t_edulevel WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id',$this->id);
		$stmt->execute();
		return $stmt;
	}
	public function getData(){
		$query='SELECT  id,
			levelCode,
			educationLevel
		FROM t_edulevel ';
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}


	function delete(){
		$query='DELETE FROM t_edulevel WHERE id=:id';
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
		$query ="SELECT MAX(CODE) AS MXCode FROM t_edulevel WHERE CODE LIKE ?";
		$stmt = $this->conn->prepare($query);
		$prefix="{$prefix}%";
		$stmt->bindParam(1, $prefix);
		$stmt->execute();
		return $stmt;
	}
}

?>