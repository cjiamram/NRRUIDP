<?php
include_once "keyWord.php";
class  tsupervisoraprove{
	private $conn;
	private $table_name="t_supervisoraprove";
	public function __construct($db){
            $this->conn = $db;
        	}
	public $idRequest;
	public $workType;
	public $userCode;
	public $supervisorCode;
	public $levelWork;
	public $notification;
	public $statusAprove;
	
	public function create(){
		$query='INSERT INTO t_supervisoraprove  
        	SET 
			idRequest=:idRequest,
			workType=:workType,
			userCode=:userCode,
			supervisorCode=:supervisorCode,
			levelWork=:levelWork,
			notification=:notification,
			statusAprove=:statusAprove
	';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":idRequest",$this->idRequest);
		$stmt->bindParam(":workType",$this->workType);
		$stmt->bindParam(":userCode",$this->userCode);
		$stmt->bindParam(":supervisorCode",$this->supervisorCode);
		$stmt->bindParam(":levelWork",$this->levelWork);
		$stmt->bindParam(":notification",$this->notification);
		$stmt->bindParam(":statusAprove",$this->statusAprove);
		$flag=$stmt->execute();
		return $flag;
	}
	public function update(){
		$query='UPDATE t_supervisoraprove 
        	SET 
			idRequest=:idRequest,
			workType=:workType,
			userCode=:userCode,
			supervisorCode=:supervisorCode,
			levelWork=:levelWork,
			notification=:notification,
			statusAprove=:statusAprove

		 WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":idRequest",$this->idRequest);
		$stmt->bindParam(":workType",$this->workType);
		$stmt->bindParam(":userCode",$this->userserCode);
		$stmt->bindParam(":supervisorCode",$this->supervisorCode);
		$stmt->bindParam(":levelWork",$this->levelWork);
		$stmt->bindParam(":notification",$this->notification);
		$stmt->bindParam(":statusAprove",$this->statusAprove);
		$stmt->bindParam(":id",$this->id);
		$flag=$stmt->execute();
		return $flag;
	}
	public function readOne(){
		$query='SELECT  id,
			idRequest,
			workType,
			userCode,
			supervisorCode,
			levelWork,
			notification,
			statusAprove
		FROM t_supervisoraprove WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id',$this->id);
		$stmt->execute();
		return $stmt;
	}


	


	public function getData($supervisorCode,$levelWork){

		$query="SELECT  
			id,
			idRequest,
			workType,
			userCode,
			supervisorCode,
			levelWork,
			notification,
			statusAprove
		FROM t_supervisoraprove 
		WHERE 
			supervisorCode = :supervisorCode
		AND 
			levelWork=:levelWork
		";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':supervisorCode',$supervisorCode);
		$stmt->bindParam(':levelWork',$levelWork);
		$stmt->execute();
		return $stmt;
	}
	function delete(){
		$query='DELETE FROM t_supervisoraprove WHERE id=:id';
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
		$query ="SELECT MAX(CODE) AS MXCode FROM t_supervisoraprove WHERE CODE LIKE ?";
		$stmt = $this->conn->prepare($query);
		$prefix="{$prefix}%";
		$stmt->bindParam(1, $prefix);
		$stmt->execute();
		return $stmt;
	}
}

?>