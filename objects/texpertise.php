<?php
include_once "keyWord.php";
class  texpertise{
	private $conn;
	private $table_name="t_expertise";
	public function __construct($db){
            $this->conn = $db;
        	}
	public $userCode;
	public $specialize;

	public function isExist($userCode){
		$query="SELECT id FROM t_expertise WHERE userCode=:userCode";

		$stmt=$this->conn->prepare($query);
		$stmt->bindParam(":userCode",$userCode);
		$stmt->execute();
		$flag=$stmt->rowCount()>0?true:false;
		return $flag;

	}

	public function getId($userCode){
		$query="SELECT id FROM t_expertise WHERE userCode=:userCode";

		$stmt=$this->conn->prepare($query);
		$stmt->bindParam(":userCode",$userCode);
		$stmt->execute();
		if($stmt->rowCount()>0){
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
			extract($row);
			return $id;
		}else
		return 0;
	}
	public function create(){
		$query='INSERT INTO t_expertise  
        	SET 
			userCode=:userCode,
			specialize=:specialize
	';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":userCode",$this->userCode);
		$stmt->bindParam(":specialize",$this->specialize);
		$flag=$stmt->execute();
		return $flag;
	}
	public function update(){
		$query='UPDATE t_expertise 
        	SET 
			userCode=:userCode,
			specialize=:specialize
		 WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":userCode",$this->userCode);
		$stmt->bindParam(":specialize",$this->specialize);
		$stmt->bindParam(":id",$this->id);
		$flag=$stmt->execute();
		return $flag;
	}

	public function getExpertise($userCode){
		$query='SELECT
			specialize
		FROM t_expertise WHERE userCode=:userCode';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':userCode',$userCode);
		$stmt->execute();
		if($stmt->rowCount()>0){
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
			extract($row);
			return $specialize;
		}else{
			return "";
		}
		

		
	}

	public function readOne(){
		$query='SELECT  id,
			userCode,
			specialize
		FROM t_expertise WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id',$this->id);
		$stmt->execute();
		return $stmt;
	}
	public function getData($userCode){
		$query='SELECT  id,
			userCode,
			specialize
		FROM t_expertise WHERE userCode LIKE :userCode';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':userCode',$userCode);
		$stmt->execute();
		return $stmt;
	}
	function delete(){
		$query='DELETE FROM t_expertise WHERE id=:id';
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
		$query ="SELECT MAX(CODE) AS MXCode FROM t_expertise WHERE CODE LIKE ?";
		$stmt = $this->conn->prepare($query);
		$prefix="{$prefix}%";
		$stmt->bindParam(1, $prefix);
		$stmt->execute();
		return $stmt;
	}
}

?>