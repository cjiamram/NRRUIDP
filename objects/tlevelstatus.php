<?php
include_once "keyWord.php";
class  tlevelstatus{
	private $conn;
	private $table_name="t_levelstatus";
	public function __construct($db){
            $this->conn = $db;
        	}
	public $code;
	public $levelStatus;
	public function create(){
		$query='INSERT INTO t_levelstatus  
        	SET 
			code=:code,
			levelStatus=:levelStatus
	';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":code",$this->code);
		$stmt->bindParam(":levelStatus",$this->levelStatus);
		$flag=$stmt->execute();
		return $flag;
	}
	public function update(){
		$query='UPDATE t_levelstatus 
        	SET 
			code=:code,
			levelStatus=:levelStatus
		 WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":code",$this->code);
		$stmt->bindParam(":levelStatus",$this->levelStatus);
		$stmt->bindParam(":id",$this->id);
		$flag=$stmt->execute();
		return $flag;
	}
	public function readOne(){
		$query='SELECT  id,
			code,
			levelStatus
		FROM t_levelstatus WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id',$this->id);
		$stmt->execute();
		return $stmt;
	}
	public function getData(){
		$query="SELECT  id,
			code,
			levelStatus
		FROM t_levelstatus ";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	public function getLevelStatus($code){
		$query="SELECT  
			levelStatus
		FROM t_levelstatus 
		WHERE code=:code";

		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":code",$code);
		$stmt->execute();
		if($stmt->rowCount()>0){
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
			extract($row);
			return $levelStatus;
		}
		return "";
	}

	function delete(){
		$query='DELETE FROM t_levelstatus WHERE id=:id';
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
		$query ="SELECT MAX(CODE) AS MXCode FROM t_levelstatus WHERE CODE LIKE ?";
		$stmt = $this->conn->prepare($query);
		$prefix="{$prefix}%";
		$stmt->bindParam(1, $prefix);
		$stmt->execute();
		return $stmt;
	}
}

?>