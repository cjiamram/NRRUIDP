<?php
include_once "keyWord.php";
class  tacademicplan{
	private $conn;
	private $table_name="t_academicplan";
	public function __construct($db){
            $this->conn = $db;
        	}
	public $userCode;
	public $educationPlan;
	public $degree;
	public $eduCertificate;
	public $budget;
	public $yearPlan;
	public $fundSource;
	public $sourceType;
	public $createDate;
	public $isAprove;
	public $university;
	public $description;
	public $placeType;
	public $departmentId;
	public $duration;
	public $eduType;
	public $message;


	public function setAprove($id,$status){
		$query="UPDATE t_academicplan 
		SET 
		isAprove=:status 
		WHERE id=:id
		";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":status",$status);
		$stmt->bindParam(":id",$id);
		$flag=$stmt->execute();
		return $flag;
	}

	public function setSelfAction($id,$status,$message){
		$query="UPDATE t_academicplan 
		SET 
		isAprove=:status,
		message=:message 
		WHERE id=:id
		";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":status",$status);
		$stmt->bindParam(":message",$message);
		$stmt->bindParam(":id",$id);
		$flag=$stmt->execute();
		return $flag;
	}
	

	public function create(){
		$query='INSERT INTO t_academicplan  
        	SET 
			userCode=:userCode,
			educationPlan=:educationPlan,
			degree=:degree,
			eduCertificate=:eduCertificate,
			budget=:budget,
			yearPlan=:yearPlan,
			fundSource=:fundSource,
			sourceType=:sourceType,
			createDate=:createDate,
			isAprove=:isAprove,
			university=:university,
			description=:description,
			placeType=:placeType,
			departmentId=:departmentId,
			duration=:duration,
			eduType=:eduType
	';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":userCode",$this->userCode);
		$stmt->bindParam(":educationPlan",$this->educationPlan);
		$stmt->bindParam(":degree",$this->degree);
		$stmt->bindParam(":eduCertificate",$this->eduCertificate);
		$stmt->bindParam(":budget",$this->budget);
		$stmt->bindParam(":yearPlan",$this->yearPlan);
		$stmt->bindParam(":fundSource",$this->fundSource);
		$stmt->bindParam(":sourceType",$this->sourceType);
		$stmt->bindParam(":createDate",$this->createDate);
		$stmt->bindParam(":isAprove",$this->isAprove);
		$stmt->bindParam(":university",$this->university);
		$stmt->bindParam(":description",$this->description);
		$stmt->bindParam(":placeType",$this->placeType);
		$stmt->bindParam(":departmentId",$this->departmentId);
		$stmt->bindParam(":duration",$this->duration);
		$stmt->bindParam(":eduType",$this->eduType);

		$flag=$stmt->execute();
		return $flag;
	}




	public function update(){
		$query='UPDATE t_academicplan 
        	SET 
			userCode=:userCode,
			educationPlan=:educationPlan,
			degree=:degree,
			eduCertificate=:eduCertificate,
			budget=:budget,
			yearPlan=:yearPlan,
			fundSource=:fundSource,
			sourceType=:sourceType,
			createDate=:createDate,
			isAprove=:isAprove,
			university=:university,
			description=:description,
			placeType=:placeType,
			departmentId=:departmentId,
			departmentId=:departmentId,
			duration=:duration,
			eduType=:eduType
		 WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":userCode",$this->userCode);
		$stmt->bindParam(":educationPlan",$this->educationPlan);
		$stmt->bindParam(":degree",$this->degree);
		$stmt->bindParam(":eduCertificate",$this->eduCertificate);
		$stmt->bindParam(":budget",$this->budget);
		$stmt->bindParam(":yearPlan",$this->yearPlan);
		$stmt->bindParam(":fundSource",$this->fundSource);
		$stmt->bindParam(":sourceType",$this->sourceType);
		$stmt->bindParam(":createDate",$this->createDate);
		$stmt->bindParam(":isAprove",$this->isAprove);
		$stmt->bindParam(":university",$this->university);
		$stmt->bindParam(":description",$this->description);
		$stmt->bindParam(":placeType",$this->placeType);
		$stmt->bindParam(":departmentId",$this->departmentId);
		$stmt->bindParam(":duration",$this->duration);
		$stmt->bindParam(":eduType",$this->eduType);
		$stmt->bindParam(":id",$this->id);
		$flag=$stmt->execute();
		return $flag;
	}
	public function readOne(){
		$query='SELECT  id,
			userCode,
			educationPlan,
			degree,
			eduCertificate,
			budget,
			yearPlan,
			fundSource,
			sourceType,
			createDate,
			isAprove,
			university,
			description,
			placeType,
			eduType,
			duration
		FROM t_academicplan WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id',$this->id);
		$stmt->execute();
		return $stmt;
	}
	public function getData($userCode){
		$query='SELECT  
			A.id,
			A.userCode,
			A.educationPlan,
			D.educationLevel AS degree,
			A.eduCertificate,
			A.budget,
			A.yearPlan,
			A.fundSource,
			B.sourceType,
			A.createDate,
			A.isAprove,
			E.status,
			A.university,
			A.description,
			C.placeType,
			A.duration,
			F.eduType

		FROM t_academicplan A LEFT OUTER JOIN t_sourcetype B
		ON A.sourceType=B.code LEFT OUTER JOIN t_placetype C 
		ON A.placeType=C.code LEFT OUTER JOIN t_edulevel D 
		ON A.degree=D.levelCode LEFT OUTER JOIN t_status E
		ON A.isAprove=E.code LEFT OUTER JOIN t_edutype F
		ON A.eduType=F.code
		WHERE userCode 
		LIKE :userCode';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':userCode',$userCode);
		$stmt->execute();
		return $stmt;
	}
	function delete(){
		$query='DELETE FROM t_academicplan WHERE id=:id';
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
		$query ="SELECT MAX(CODE) AS MXCode FROM t_academicplan WHERE CODE LIKE ?";
		$stmt = $this->conn->prepare($query);
		$prefix="{$prefix}%";
		$stmt->bindParam(1, $prefix);
		$stmt->execute();
		return $stmt;
	}
}

?>