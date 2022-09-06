<?php
include_once "keyWord.php";
class  tstaffmigrate{
	private $conn;
	private $table_name="t_staffmigrate";
	public function __construct($db){
            $this->conn = $db;
        	}
	public $staffCode;
	public $userCode;
	public $stafffullname;
	public $stafffullnameeng;
	public $departmentcode;
	public $departmentcode1;
	




	public function create(){
		$query='INSERT INTO t_staffmigrate  
        	SET 
			staffCode=:staffCode,
			userCode=:userCode,
			stafffullname=:stafffullname,
			stafffullnameeng=:stafffullnameeng,
			departmentcode=:departmentcode,
			departmentcode1=:departmentcode1
	';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":staffCode",$this->staffCode);
		$stmt->bindParam(":userCode",$this->userCode);
		$stmt->bindParam(":stafffullname",$this->stafffullname);
		$stmt->bindParam(":stafffullnameeng",$this->stafffullnameeng);
		$stmt->bindParam(":departmentcode",$this->departmentcode);
		$stmt->bindParam(":departmentcode1",$this->departmentcode1);
		$flag=$stmt->execute();
		return $flag;
	}
	public function update(){
		$query='UPDATE t_staffmigrate 
        	SET 
			staffCode=:staffCode,
			userCode=:userCode,
			stafffullname=:stafffullname,
			stafffullnameeng=:stafffullnameeng,
			departmentcode=:departmentcode,
			departmentcode1=:departmentcode1
		 WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":staffCode",$this->staffCode);
		$stmt->bindParam(":userCode",$this->userCode);
		$stmt->bindParam(":stafffullname",$this->stafffullname);
		$stmt->bindParam(":stafffullnameeng",$this->stafffullnameeng);
		$stmt->bindParam(":departmentcode",$this->departmentcode);
		$stmt->bindParam(":departmentcode1",$this->departmentcode1);
		$stmt->bindParam(":id",$this->id);
		$flag=$stmt->execute();
		return $flag;
	}
	public function readOne(){
		$query='SELECT  id,
			staffCode,
			userCode,
			stafffullname,
			stafffullnameeng,
			departmentcode,
			departmentcode1
		FROM t_staffmigrate WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id',$this->id);
		$stmt->execute();
		return $stmt;
	}
	

	public function getDataByUser($keyWord){
		$query="SELECT  id,
			staffCode,
			userCode,
			stafffullname,
			stafffullnameeng,
			departmentcode,
			departmentcode1
		FROM t_staffmigrate 
		WHERE 
		
			CONCAT(stafffullname,' ',stafffullnameeng,' ',staffCode)
			LIKE :keyWord

		";
		$stmt = $this->conn->prepare($query);
		$keyWord="%{$keyWord}%";
		$stmt->bindParam(':keyWord',$keyWord);
		$stmt->execute();
		return $stmt;
	}

	public function getData($departmentCode,$keyWord){
		//$keyWord="%{$keyWord}%";
		$query="SELECT  id,
			staffCode,
			userCode,
			stafffullname,
			stafffullnameeng,
			departmentcode,
			departmentcode1
		FROM t_staffmigrate 
		WHERE 
			departmentCode = :departmentCode
		AND 
			CONCAT(stafffullname,' ',stafffullnameeng,' ',staffCode)
			LIKE :keyWord

		";
		$stmt = $this->conn->prepare($query);
		$keyWord="%{$keyWord}%";
		$stmt->bindParam(':departmentCode',$departmentCode);
		$stmt->bindParam(':keyWord',$keyWord);
		$stmt->execute();
		return $stmt;
	}

	public function getMigrateId($staffCode){
		$query="SELECT id FROM t_staffmigrate WHERE staffCode=:staffCode";
		$stmt=$this->conn->prepare($query);
		$stmt->bindParam(":staffCode",$staffCode);
		$stmt->execute();
		if($stmt->rowCount()>0){
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
			extract($row);
			return $id;
		}else
		{
			return 0;
		}

	}
	

	function delete(){
		$query='DELETE FROM t_staffmigrate WHERE id=:id';
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
		$query ="SELECT MAX(CODE) AS MXCode FROM t_staffmigrate WHERE CODE LIKE ?";
		$stmt = $this->conn->prepare($query);
		$prefix="{$prefix}%";
		$stmt->bindParam(1, $prefix);
		$stmt->execute();
		return $stmt;
	}
}

?>