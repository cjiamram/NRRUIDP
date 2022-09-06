<?php
include_once "keyWord.php";
class  districts{
	private $conn;
	private $table_name="districts";
	public function __construct($db){
            $this->conn = $db;
        	}
	public $zip_code;
	public $name_th;
	public $name_en;
	public $amphure_id;
	public function create(){
		$query='INSERT INTO districts  
        	SET 
			zip_code=:zip_code,
			name_th=:name_th,
			name_en=:name_en,
			amphure_id=:amphure_id
	';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":zip_code",$this->zip_code);
		$stmt->bindParam(":name_th",$this->name_th);
		$stmt->bindParam(":name_en",$this->name_en);
		$stmt->bindParam(":amphure_id",$this->amphure_id);
		$flag=$stmt->execute();
		return $flag;
	}
	public function update(){
		$query='UPDATE districts 
        	SET 
			zip_code=:zip_code,
			name_th=:name_th,
			name_en=:name_en,
			amphure_id=:amphure_id
		 WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":zip_code",$this->zip_code);
		$stmt->bindParam(":name_th",$this->name_th);
		$stmt->bindParam(":name_en",$this->name_en);
		$stmt->bindParam(":amphure_id",$this->amphure_id);
		$stmt->bindParam(":id",$this->id);
		$flag=$stmt->execute();
		return $flag;
	}
	public function readOne(){
		$query='SELECT  id,
			zip_code,
			name_th,
			name_en,
			amphure_id
		FROM districts WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id',$this->id);
		$stmt->execute();
		return $stmt;
	}

	public function listData($province){
		$query='SELECT  id,
			zip_code,
			name_th,
			name_en,
			amphure_id
		FROM districts WHERE '.$key.' LIKE :keyWord';
		$stmt = $this->conn->prepare($query);
		$keyWord="%{$keyWord}%";
		$stmt->bindParam(':keyWord',$keyWord);
		$stmt->execute();
		return $stmt;
	}

	public function getData($keyWord){
		$key=KeyWord::getKeyWord($this->conn,$this->table_name);
		$key=($key!="")?$key:"keyWord";
		$query='SELECT  id,
			zip_code,
			name_th,
			name_en,
			amphure_id
		FROM districts WHERE '.$key.' LIKE :keyWord';
		$stmt = $this->conn->prepare($query);
		$keyWord="%{$keyWord}%";
		$stmt->bindParam(':keyWord',$keyWord);
		$stmt->execute();
		return $stmt;
	}
	function delete(){
		$query='DELETE FROM districts WHERE id=:id';
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
		$query ="SELECT MAX(CODE) AS MXCode FROM districts WHERE CODE LIKE ?";
		$stmt = $this->conn->prepare($query);
		$prefix="{$prefix}%";
		$stmt->bindParam(1, $prefix);
		$stmt->execute();
		return $stmt;
	}
}

?>