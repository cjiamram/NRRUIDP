<?php
include_once "keyWord.php";
class  tprogram{
	private $conn;
	private $table_name="t_program";
	public function __construct($db){
            $this->conn = $db;
        	}
	public $programCode;
	public $program;
	public function create(){
		$query='INSERT INTO t_program  
        	SET 
			programCode=:programCode,
			program=:program
	';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":programCode",$this->programCode);
		$stmt->bindParam(":program",$this->program);
		$flag=$stmt->execute();
		return $flag;
	}
	public function update(){
		$query='UPDATE t_program 
        	SET 
			programCode=:programCode,
			program=:program
		 WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":programCode",$this->programCode);
		$stmt->bindParam(":program",$this->program);
		$stmt->bindParam(":id",$this->id);
		$flag=$stmt->execute();
		return $flag;
	}
	public function readOne(){
		$query='SELECT  id,
			programCode,
			program
		FROM t_program WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id',$this->id);
		$stmt->execute();
		return $stmt;
	}
	public function getData(){

		$query='SELECT  id,
			programCode,
			program
		FROM t_program ';
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}
	function delete(){
		$query='DELETE FROM t_program WHERE id=:id';
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
		$query ="SELECT MAX(CODE) AS MXCode FROM t_program WHERE CODE LIKE ?";
		$stmt = $this->conn->prepare($query);
		$prefix="{$prefix}%";
		$stmt->bindParam(1, $prefix);
		$stmt->execute();
		return $stmt;
	}
}

?>