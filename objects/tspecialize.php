<?php
include_once "keyWord.php";
class  tspecialize{
	private $conn;
	private $table_name="t_specialize";
	public function __construct($db){
            $this->conn = $db;
        	}
	public $code;
	public $specialize;
	public $parent;
	public $levelNo;
	public $orderNo;
	public $enable;
	public function create(){
		$query='INSERT INTO t_specialize  
        	SET 
			code=:code,
			specialize=:specialize,
			parent=:parent,
			levelNo=:levelNo,
			orderNo=:orderNo
	';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":code",$this->code);
		$stmt->bindParam(":specialize",$this->specialize);
		$stmt->bindParam(":parent",$this->parent);
		$stmt->bindParam(":levelNo",$this->levelNo);
		$stmt->bindParam(":orderNo",$this->orderNo);
		$flag=$stmt->execute();
		return $flag;
	}
	public function update(){
		$query='UPDATE t_specialize 
        	SET 
			code=:code,
			specialize=:specialize,
			parent=:parent,
			levelNo=:levelNo,
			orderNo=:orderNo
		 WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":code",$this->code);
		$stmt->bindParam(":specialize",$this->specialize);
		$stmt->bindParam(":parent",$this->parent);
		$stmt->bindParam(":levelNo",$this->levelNo);
		$stmt->bindParam(":orderNo",$this->orderNo);
		$stmt->bindParam(":id",$this->id);
		$flag=$stmt->execute();
		return $flag;
	}
	public function readOne(){
		$query='SELECT  id,
			code,
			specialize,
			parent,
			levelNo,
			orderNo
		FROM t_specialize WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id',$this->id);
		$stmt->execute();
		return $stmt;
	}


	public function listParent($groupType){
		$query='SELECT  
			id,
			code,
			specialize,
			parent,
			levelNo,
			orderNo,
			enable
		FROM t_specialize WHERE levelNo=0 
		AND groupType=:groupType';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":groupType",$groupType);
		$stmt->execute();
		return $stmt;
	}

	public function listTree($levelNo,$parent,$groupType){
		$query='SELECT  
			id,
			code,
			specialize,
			parent,
			levelNo,
			orderNo,
			enable
		FROM t_specialize 
		WHERE levelNo=:levelNo
		AND parent LIKE :parent
		AND groupType=:groupType 

		ORDER BY OrderNo
		';
		$stmt=$this->conn->prepare($query);
		$parent="%{$parent}%";
		$stmt->bindParam(':levelNo',$levelNo);
		$stmt->bindParam(':parent',$parent);
		$stmt->bindParam(':groupType',$groupType);
		$stmt->execute();
		return $stmt;
	}



	public function getData($keyWord){
		$key=KeyWord::getKeyWord($this->conn,$this->table_name);
		$key=($key!="")?$key:"keyWord";
		$query='SELECT  id,
			code,
			specialize,
			parent,
			levelNo,
			orderNo
		FROM t_specialize WHERE '.$key.' LIKE :keyWord';
		$stmt = $this->conn->prepare($query);
		$keyWord="%{$keyWord}%";
		$stmt->bindParam(':keyWord',$keyWord);
		$stmt->execute();
		return $stmt;
	}
	function delete(){
		$query='DELETE FROM t_specialize WHERE id=:id';
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
		$query ="SELECT MAX(CODE) AS MXCode FROM t_specialize WHERE CODE LIKE ?";
		$stmt = $this->conn->prepare($query);
		$prefix="{$prefix}%";
		$stmt->bindParam(1, $prefix);
		$stmt->execute();
		return $stmt;
	}
}

?>