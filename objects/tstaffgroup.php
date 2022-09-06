<?php
include_once "keyWord.php";
class  tstaffgroup{
	private $conn;
	private $table_name="t_staffgroup";
	public function __construct($db){
            $this->conn = $db;
        	}
	public $userCode;
	public $staffGroup;
	public function create(){
		$query="INSERT INTO t_staffgroup  
        	SET 
			userCode=:userCode,
			staffGroup=:staffGroup";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":userCode",$this->userCode);
		$stmt->bindParam(":staffGroup",$this->staffGroup);
		$flag=$stmt->execute();
		return $flag;
	}

	public function isExist($userCode){
		$query="SELECT id  
		FROM t_staffgroup 
		WHERE userCode=:userCode";
		$stmt=$this->conn->prepare($query);
		$stmt->bindParam(":userCode",$userCode);
		$stmt->execute();
		if($stmt->rowCount()>0){
			return true;
		}else
		{
			return false;
		}

	}


	public function update(){
		$query='UPDATE t_staffgroup 
        	SET 
			userCode=:userCode,
			staffGroup=:staffGroup
		 WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":userCode",$this->userCode);
		$stmt->bindParam(":staffGroup",$this->staffGroup);
		$stmt->bindParam(":id",$this->id);
		$flag=$stmt->execute();
		return $flag;
	}
	public function readOne(){
		$query='SELECT  id,
			userCode,
			staffGroup
		FROM t_staffgroup WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id',$this->id);
		$stmt->execute();
		return $stmt;
	}
	public function getData($keyWord){
		$key=KeyWord::getKeyWord($this->conn,$this->table_name);
		$key=($key!="")?$key:"keyWord";
		$query='SELECT  id,
			userCode,
			staffGroup
		FROM t_staffgroup WHERE '.$key.' LIKE :keyWord';
		$stmt = $this->conn->prepare($query);
		$keyWord="%{$keyWord}%";
		$stmt->bindParam(':keyWord',$keyWord);
		$stmt->execute();
		return $stmt;
	}
	function delete(){
		$query='DELETE FROM t_staffgroup WHERE id=:id';
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
		$query ="SELECT MAX(CODE) AS MXCode FROM t_staffgroup WHERE CODE LIKE ?";
		$stmt = $this->conn->prepare($query);
		$prefix="{$prefix}%";
		$stmt->bindParam(1, $prefix);
		$stmt->execute();
		return $stmt;
	}
}

?>