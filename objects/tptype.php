<?php
include_once "keyWord.php";
class  tptype{
	private $conn;
	private $table_name="t_ptype";
	public function __construct($db){
            $this->conn = $db;
        	}
	public $code;
	public $pType;
	public function create(){
		$query='INSERT INTO t_ptype  
        	SET 
			code=:code,
			pType=:pType
	';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":code",$this->code);
		$stmt->bindParam(":pType",$this->pType);
		$flag=$stmt->execute();
		return $flag;
	}
	public function update(){
		$query='UPDATE t_ptype 
        	SET 
			code=:code,
			pType=:pType
		 WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":code",$this->code);
		$stmt->bindParam(":pType",$this->pType);
		$stmt->bindParam(":id",$this->id);
		$flag=$stmt->execute();
		return $flag;
	}
	public function readOne(){
		$query='SELECT  id,
			code,
			pType
		FROM t_ptype WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id',$this->id);
		$stmt->execute();
		return $stmt;
	}

	public function getPTypeName($code){
		$query='SELECT  
			pType
		FROM t_ptype WHERE code=:code';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':code',$code);
		$stmt->execute();
		return $stmt;
	} 

	public function getData(){
		
		$query='SELECT  id,
			code,
			pType
		FROM t_ptype ';
		$stmt = $this->conn->prepare($query);
		
		$stmt->execute();
		return $stmt;
	}

	public function getDataCriteria($keyWord){
		
		$query="SELECT  
			id,
			code,
			pType
		FROM t_ptype 
		WHERE pType LIKE :keyWord 
		";
		$stmt = $this->conn->prepare($query);
		$keyWord="%{$keyWord}%";
		$stmt->bindParam(":keyWord",$keyWord);
		$stmt->execute();
		return $stmt;
	}

	function delete(){
		$query='DELETE FROM t_ptype WHERE id=:id';
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
		$query ="SELECT MAX(CODE) AS MXCode FROM t_ptype WHERE CODE LIKE ?";
		$stmt = $this->conn->prepare($query);
		$prefix="{$prefix}%";
		$stmt->bindParam(1, $prefix);
		$stmt->execute();
		return $stmt;
	}
}

?>