<?php
include_once "keyWord.php";
class  tprogressrequest{
	private $conn;
	private $table_name="t_progressrequest";
	public function __construct($db){
            $this->conn = $db;
        	}
	public $code;
	public $progressType;
	public $requestType;
	public function create(){
		$query='INSERT INTO t_progressrequest  
        	SET 
			code=:code,
			progressType=:progressType,
			requestType=:requestType
	';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":code",$this->code);
		$stmt->bindParam(":progressType",$this->progressType);
		$stmt->bindParam(":requestType",$this->requestType);
		$flag=$stmt->execute();
		return $flag;
	}
	public function update(){
		$query='UPDATE t_progressrequest 
        	SET 
			code=:code,
			progressType=:progressType,
			requestType=:requestType
		 WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":code",$this->code);
		$stmt->bindParam(":progressType",$this->progressType);
		$stmt->bindParam(":requestType",$this->requestType);
		$stmt->bindParam(":id",$this->id);
		$flag=$stmt->execute();
		return $flag;
	}
	public function readOne(){
		$query='SELECT  id,
			code,
			progressType,
			requestType
		FROM t_progressrequest WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id',$this->id);
		$stmt->execute();
		return $stmt;
	}
	public function getData(){
		$query='SELECT  id,
			code,
			progressType,
			requestType
		FROM t_progressrequest WHERE requestType=1  ';
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	public function getDataSupport(){
		$query='SELECT  id,
			code,
			progressType,
			requestType
		FROM t_progressrequest WHERE requestType=2  ';
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}


	function delete(){
		$query='DELETE FROM t_progressrequest WHERE id=:id';
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
		$query ="SELECT MAX(CODE) AS MXCode FROM t_progressrequest WHERE CODE LIKE ?";
		$stmt = $this->conn->prepare($query);
		$prefix="{$prefix}%";
		$stmt->bindParam(1, $prefix);
		$stmt->execute();
		return $stmt;
	}
}

?>