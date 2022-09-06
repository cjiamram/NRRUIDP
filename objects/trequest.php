<?php
include_once "keyWord.php";
class  trequest{
	private $conn;
	private $table_name="t_request";
	public function __construct($db){
            $this->conn = $db;
        	}
	public $userCode;
	public $fullName;
	public $description;
	public $createDate;
	public $progressStatus;
	public $requestType;
	public function create(){
		$query='INSERT INTO t_request  
        	SET 
			userCode=:userCode,
			fullName=:fullName,
			description=:description,
			createDate=:createDate,
			progressStatus=:progressStatus,
			requestType=:requestType
	';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":userCode",$this->userCode);
		$stmt->bindParam(":fullName",$this->fullName);
		$stmt->bindParam(":description",$this->description);
		$stmt->bindParam(":createDate",$this->createDate);
		$stmt->bindParam(":progressStatus",$this->progressStatus);
		$stmt->bindParam(":requestType",$this->requestType);
		$flag=$stmt->execute();
		return $flag;
	}
	public function update(){
		$query='UPDATE t_request 
        	SET 
			userCode=:userCode,
			fullName=:fullName,
			description=:description,
			createDate=:createDate,
			progressStatus=:progressStatus,
			requestType=:requestType

		 WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":userCode",$this->userCode);
		$stmt->bindParam(":fullName",$this->fullName);
		$stmt->bindParam(":description",$this->description);
		$stmt->bindParam(":createDate",$this->createDate);
		$stmt->bindParam(":progressStatus",$this->progressStatus);
		$stmt->bindParam(":requestType",$this->requestType);
		$stmt->bindParam(":id",$this->id);
		$flag=$stmt->execute();
		return $flag;
	}
	public function readOne(){
		$query='SELECT  id,
			userCode,
			fullName,
			description,
			createDate,
			progressStatus,
			requestType
		FROM t_request WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id',$this->id);
		$stmt->execute();
		return $stmt;
	}
	public function getData($userCode){
		$query='SELECT  A.id,
			A.userCode,
			A.fullName,
			A.description,
			A.createDate,
			C.progressType AS  progressStatus,
			B.requestType
		FROM t_request A 
		LEFT OUTER JOIN t_requesttype B 
		ON A.requestType=B.code 
		LEFT OUTER JOIN t_progressrequest C 
		ON A.progressStatus=C.code
		WHERE A.userCode=:userCode ';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':userCode',$userCode);
		$stmt->execute();
		return $stmt;
	}

	public function getSelfData($userCode){
		$query="SELECT  A.id,
			A.userCode,
			A.fullName,
			A.description,
			A.createDate,
			C.progressType AS  progressStatus,
			A.progressStatus AS progressCode,
			B.requestType
		FROM t_request A 
		LEFT OUTER JOIN t_requesttype B 
		ON A.requestType=B.code 
		LEFT OUTER JOIN t_progressrequest C 
		ON A.progressStatus=C.code
		WHERE userCode  = :userCode 
		";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":userCode",$userCode);
		$stmt->execute();
		return $stmt;
	}


	public function getDataByAdmin($keyWord){
		$query="SELECT  A.id,
			A.userCode,
			A.fullName,
			A.description,
			A.createDate,
			C.progressType AS  progressStatus,
			A.progressStatus AS progressCode,
			B.requestType
		FROM t_request A 
		LEFT OUTER JOIN t_requesttype B 
		ON A.requestType=B.code 
		LEFT OUTER JOIN t_progressrequest C 
		ON A.progressStatus=C.code
		WHERE CONCAT(A.userCode,' ' ,A.fullName)  LIKE :keyWord 
		OR A.description LIKE :keyWord
		";
		$stmt = $this->conn->prepare($query);
		$keyWord="%{$keyWord}%";
		$stmt->bindParam(":keyWord",$keyWord);
		$stmt->execute();
		return $stmt;
	}

	function modifyProgress($id,$progressStatus){
		$query="UPDATE t_request 
		SET progressStatus=:progressStatus 
		WHERE id=:id
		";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id',$id);
		$stmt->bindParam(':progressStatus',$progressStatus);
		$flag=$stmt->execute();
		return $flag;
	}

	function delete(){
		$query='DELETE FROM t_request WHERE id=:id';
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
		$query ="SELECT MAX(CODE) AS MXCode FROM t_request WHERE CODE LIKE ?";
		$stmt = $this->conn->prepare($query);
		$prefix="{$prefix}%";
		$stmt->bindParam(1, $prefix);
		$stmt->execute();
		return $stmt;
	}
}

?>