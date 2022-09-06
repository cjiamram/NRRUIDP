<?php
include_once "keyWord.php";
class  tsendslip{
	private $conn;
	private $table_name="t_sendslip";
	public function __construct($db){
            $this->conn = $db;
        	}
	public $email;
	public $slip;
	public $sendDate;
	public $isAprove;
	public function create(){
		$query='INSERT INTO t_sendslip  
        	SET 
			email=:email,
			slip=:slip,
			sendDate=:sendDate,
			isAprove=:isAprove
	';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":email",$this->email);
		$stmt->bindParam(":slip",$this->slip);
		$stmt->bindParam(":sendDate",$this->sendDate);
		$stmt->bindParam(":isAprove",$this->isAprove);
		$flag=$stmt->execute();
		return $flag;
	}
	public function update(){
		$query='UPDATE t_sendslip 
        	SET 
			email=:email,
			slip=:slip,
			sendDate=:sendDate,
			isAprove=:isAprove
		 WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":email",$this->email);
		$stmt->bindParam(":slip",$this->slip);
		$stmt->bindParam(":sendDate",$this->sendDate);
		$stmt->bindParam(":isAprove",$this->isAprove);
		$stmt->bindParam(":id",$this->id);
		$flag=$stmt->execute();
		return $flag;
	}
	public function readOne(){
		$query='SELECT  id,
			email,
			slip,
			sendDate,
			isAprove
		FROM t_sendslip WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id',$this->id);
		$stmt->execute();
		return $stmt;
	}
	public function getData($keyWord){
		$key=KeyWord::getKeyWord($this->conn,$this->table_name);
		$key=($key!="")?$key:"keyWord";
		$query='SELECT  id,
			email,
			slip,
			sendDate,
			isAprove
		FROM t_sendslip WHERE '.$key.' LIKE :keyWord';
		$stmt = $this->conn->prepare($query);
		$keyWord="%{$keyWord}%";
		$stmt->bindParam(':keyWord',$keyWord);
		$stmt->execute();
		return $stmt;
	}
	function delete(){
		$query='DELETE FROM t_sendslip WHERE id=:id';
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
		$query ="SELECT MAX(CODE) AS MXCode FROM t_sendslip WHERE CODE LIKE ?";
		$stmt = $this->conn->prepare($query);
		$prefix="{$prefix}%";
		$stmt->bindParam(1, $prefix);
		$stmt->execute();
		return $stmt;
	}
}

?>