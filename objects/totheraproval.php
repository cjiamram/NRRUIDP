<?php
include_once "keyWord.php";
class  totheraproval{
	private $conn;
	private $table_name="t_otheraproval";
	public function __construct($db){
            $this->conn = $db;
        	}
	public $headerAproveId;
	public $staffCode;
	public function create(){
		$query='INSERT INTO t_otheraproval  
        	SET 
			headerAproveId=:headerAproveId,
			staffCode=:staffCode
	';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":headerAproveId",$this->headerAproveId);
		$stmt->bindParam(":staffCode",$this->staffCode);
		$flag=$stmt->execute();
		return $flag;
	}
	public function update(){
		$query='UPDATE t_otheraproval 
        	SET 
			headerAproveId=:headerAproveId,
			staffCode=:staffCode
		 WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":headerAproveId",$this->headerAproveId);
		$stmt->bindParam(":staffCode",$this->staffCode);
		$stmt->bindParam(":id",$this->id);
		$flag=$stmt->execute();
		return $flag;
	}
	public function readOne(){
		$query='SELECT  id,
			headerAproveId,
			staffCode
		FROM t_otheraproval WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id',$this->id);
		$stmt->execute();
		return $stmt;
	}
	public function getData($keyWord){
		$key=KeyWord::getKeyWord($this->conn,$this->table_name);
		$key=($key!="")?$key:"keyWord";
		$query='SELECT  id,
			headerAproveId,
			staffCode
		FROM t_otheraproval WHERE '.$key.' LIKE :keyWord';
		$stmt = $this->conn->prepare($query);
		$keyWord="%{$keyWord}%";
		$stmt->bindParam(':keyWord',$keyWord);
		$stmt->execute();
		return $stmt;
	}
	function delete(){
		$query='DELETE FROM t_otheraproval WHERE id=:id';
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
		$query ="SELECT MAX(CODE) AS MXCode FROM t_otheraproval WHERE CODE LIKE ?";
		$stmt = $this->conn->prepare($query);
		$prefix="{$prefix}%";
		$stmt->bindParam(1, $prefix);
		$stmt->execute();
		return $stmt;
	}
}

?>