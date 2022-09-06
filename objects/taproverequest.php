<?php
include_once "keyWord.php";
class  taproverequest{
	private $conn;
	private $table_name="t_aproverequest";
	public function __construct($db){
            $this->conn = $db;
        	}
	public $requestId;
	public $pType;
	public $message;
	public $status;
	public function create(){
		$query='INSERT INTO t_aproverequest  
        	SET 
			requestId=:requestId,
			pType=:pType,
			message=:message,
			status=:status
	';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":requestId",$this->requestId);
		$stmt->bindParam(":pType",$this->pType);
		$stmt->bindParam(":message",$this->message);
		$stmt->bindParam(":status",$this->status);
		$flag=$stmt->execute();
		return $flag;
	}
	public function update(){
		$query='UPDATE t_aproverequest 
        	SET 
			requestId=:requestId,
			pType=:pType,
			message=:message
		 WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":requestId",$this->requestId);
		$stmt->bindParam(":pType",$this->pType);
		$stmt->bindParam(":message",$this->message);
		$stmt->bindParam(":id",$this->id);
		$flag=$stmt->execute();
		return $flag;
	}
	public function readOne(){
		$query='SELECT  id,
			requestId,
			pType,
			message
		FROM t_aproverequest WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id',$this->id);
		$stmt->execute();
		return $stmt;
	}

	public function getMessage($requestId,$pType){
		$query="SELECT message 
			FROM t_aproverequest 
			WHERE 
			requestId=:requestId 
			AND 
			pType=:pType";
		$stmt=$this->conn->prepare($query);
		$stmt->bindParam(":requestId",$requestId);
		$stmt->bindParam(":pType",$pType);
		$stmt->execute();
		return $stmt;
	

	}
	
	public function getAproveMessage($requestId,$pType){
		$query="SELECT message 
			FROM t_aproverequest 
			WHERE 
			requestId=:requestId 
			AND 
			pType=:pType";
		$stmt=$this->conn->prepare($query);
		$stmt->bindParam(":requestId",$requestId);
		$stmt->bindParam(":pType",$pType);
		$stmt->execute();
		if($stmt->rowCount()>0){
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
			extract($row);
			return $message;
		}else{
			return "";
		}


	}

	public function getData($keyWord){
		
		$query='SELECT  id,
			requestId,
			pType,
			message
		FROM t_aproverequest WHERE message LIKE :keyWord';
		$stmt = $this->conn->prepare($query);
		$keyWord="%{$keyWord}%";
		$stmt->bindParam(':keyWord',$keyWord);
		$stmt->execute();
		return $stmt;
	}
	function delete(){
		$query='DELETE FROM t_aproverequest WHERE id=:id';
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
		$query ="SELECT MAX(CODE) AS MXCode FROM t_aproverequest WHERE CODE LIKE ?";
		$stmt = $this->conn->prepare($query);
		$prefix="{$prefix}%";
		$stmt->bindParam(1, $prefix);
		$stmt->execute();
		return $stmt;
	}
}

?>