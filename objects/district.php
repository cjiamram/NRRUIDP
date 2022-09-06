<?php
include_once "keyWord.php";
class  district{
	private $conn;
	private $table_name="district";
	public function __construct($db){
            $this->conn = $db;
        	}
	public $code;
	public $disName_Th;
	public $disName_En;
	public $prv_Code;
	public function create(){
		$query='INSERT INTO district  
        	SET 
			code=:code,
			disName_Th=:disName_Th,
			disName_En=:disName_En,
			prv_Code=:prv_Code
	';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":code",$this->code);
		$stmt->bindParam(":disName_Th",$this->disName_Th);
		$stmt->bindParam(":disName_En",$this->disName_En);
		$stmt->bindParam(":prv_Code",$this->prv_Code);
		$flag=$stmt->execute();
		return $flag;
	}
	public function update(){
		$query='UPDATE district 
        	SET 
			code=:code,
			disName_Th=:disName_Th,
			disName_En=:disName_En,
			prv_Code=:prv_Code
		 WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":code",$this->code);
		$stmt->bindParam(":disName_Th",$this->disName_Th);
		$stmt->bindParam(":disName_En",$this->disName_En);
		$stmt->bindParam(":prv_Code",$this->prv_Code);
		$stmt->bindParam(":id",$this->id);
		$flag=$stmt->execute();
		return $flag;
	}
	public function readOne(){
		$query='SELECT  id,
			code,
			disName_Th,
			disName_En,
			prv_Code
		FROM district WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id',$this->id);
		$stmt->execute();
		return $stmt;
	}

	public function listData($province){
		$query='SELECT  id,
			code,
			disName_Th,
			disName_En,
			prv_Code
		FROM district WHERE prv_Code LIKE :province';
		$stmt = $this->conn->prepare($query);
		$province="%{$province}%";
		$stmt->bindParam(':province',$province);
		$stmt->execute();
		return $stmt;
	}

	public function getData($keyWord){
		$key=KeyWord::getKeyWord($this->conn,$this->table_name);
		$key=($key!="")?$key:"keyWord";
		$query='SELECT  id,
			code,
			disName_Th,
			disName_En,
			prv_Code
		FROM district WHERE '.$key.' LIKE :keyWord';
		$stmt = $this->conn->prepare($query);
		$keyWord="%{$keyWord}%";
		$stmt->bindParam(':keyWord',$keyWord);
		$stmt->execute();
		return $stmt;
	}
	function delete(){
		$query='DELETE FROM district WHERE id=:id';
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
		$query ="SELECT MAX(CODE) AS MXCode FROM district WHERE CODE LIKE ?";
		$stmt = $this->conn->prepare($query);
		$prefix="{$prefix}%";
		$stmt->bindParam(1, $prefix);
		$stmt->execute();
		return $stmt;
	}
}

?>