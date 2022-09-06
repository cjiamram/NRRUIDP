<?php
include_once "keyWord.php";
class  province{
	private $conn;
	private $table_name="province";
	public function __construct($db){
            $this->conn = $db;
        	}
	public $code;
	public $prvName_Th;
	public $prvName_En;
	public function create(){
		$query='INSERT INTO province  
        	SET 
			code=:code,
			prvName_Th=:prvName_Th,
			prvName_En=:prvName_En
	';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":code",$this->code);
		$stmt->bindParam(":prvName_Th",$this->prvName_Th);
		$stmt->bindParam(":prvName_En",$this->prvName_En);
		$flag=$stmt->execute();
		return $flag;
	}
	public function update(){
		$query='UPDATE province 
        	SET 
			code=:code,
			prvName_Th=:prvName_Th,
			prvName_En=:prvName_En
		 WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":code",$this->code);
		$stmt->bindParam(":prvName_Th",$this->prvName_Th);
		$stmt->bindParam(":prvName_En",$this->prvName_En);
		$stmt->bindParam(":id",$this->id);
		$flag=$stmt->execute();
		return $flag;
	}
	public function readOne(){
		$query='SELECT  id,
			code,
			prvName_Th,
			prvName_En
		FROM province WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id',$this->id);
		$stmt->execute();
		return $stmt;
	}
	public function getData($keyWord){
		$key=KeyWord::getKeyWord($this->conn,$this->table_name);
		$key=($key!="")?$key:"keyWord";
		$query='SELECT  id,
			code,
			prvName_Th,
			prvName_En
		FROM province WHERE '.$key.' LIKE :keyWord';
		$stmt = $this->conn->prepare($query);
		$keyWord="%{$keyWord}%";
		$stmt->bindParam(':keyWord',$keyWord);
		$stmt->execute();
		return $stmt;
	}

	public function listData(){
		$query='SELECT  id,
			code,
			prvName_Th,
			prvName_En
		FROM province ORDER BY prvName_Th';
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}
	function delete(){
		$query='DELETE FROM province WHERE id=:id';
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
		$query ="SELECT MAX(CODE) AS MXCode FROM province WHERE CODE LIKE ?";
		$stmt = $this->conn->prepare($query);
		$prefix="{$prefix}%";
		$stmt->bindParam(1, $prefix);
		$stmt->execute();
		return $stmt;
	}
}

?>