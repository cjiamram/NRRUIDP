<?php
include_once "keyWord.php";
class  timproveplan{
	private $conn;
	private $table_name="t_improveplan";
	public function __construct($db){
            $this->conn = $db;
        	}
	public $staffCode;
	public $topic;
	public $improvementType;
	public $yearPlan;
	public $description;
	public $academicYear;
	public $budget;
	public $sourceDepartment;
	public $sourceType;
	public $duration;
	public $monthPlan;
	public function create(){
		$query='INSERT INTO t_improveplan  
        	SET 
			staffCode=:staffCode,
			topic=:topic,
			improvementType=:improvementType,
			yearPlan=:yearPlan,
			description=:description,
			academicYear=:academicYear,
			budget=:budget,
			sourceDepartment=:sourceDepartment,
			sourceType=:sourceType,
			duration=:duration,
			monthPlan=:monthPlan
	';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":staffCode",$this->staffCode);
		$stmt->bindParam(":topic",$this->topic);
		$stmt->bindParam(":improvementType",$this->improvementType);
		$stmt->bindParam(":yearPlan",$this->yearPlan);
		$stmt->bindParam(":description",$this->description);
		$stmt->bindParam(":academicYear",$this->academicYear);
		$stmt->bindParam(":budget",$this->budget);
		$stmt->bindParam(":sourceDepartment",$this->sourceDepartment);
		$stmt->bindParam(":sourceType",$this->sourceType);
		$stmt->bindParam(":duration",$this->duration);
		$stmt->bindParam(":monthPlan",$this->monthPlan);
		$flag=$stmt->execute();
		return $flag;
	}
	public function update(){
		$query='UPDATE t_improveplan 
        	SET 
			staffCode=:staffCode,
			topic=:topic,
			improvementType=:improvementType,
			yearPlan=:yearPlan,
			description=:description,
			academicYear=:academicYear,
			budget=:budget,
			sourceDepartment=:sourceDepartment,
			sourceType=:sourceType,
			duration=:duration,
			monthPlan=:monthPlan
		 WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":staffCode",$this->staffCode);
		$stmt->bindParam(":topic",$this->topic);
		$stmt->bindParam(":improvementType",$this->improvementType);
		$stmt->bindParam(":yearPlan",$this->yearPlan);
		$stmt->bindParam(":description",$this->description);
		$stmt->bindParam(":academicYear",$this->academicYear);
		$stmt->bindParam(":budget",$this->budget);
		$stmt->bindParam(":sourceDepartment",$this->sourceDepartment);
		$stmt->bindParam(":sourceType",$this->sourceType);
		$stmt->bindParam(":duration",$this->duration);
		$stmt->bindParam(":monthPlan",$this->monthPlan);
		$stmt->bindParam(":id",$this->id);
		$flag=$stmt->execute();
		return $flag;
	}
	public function readOne(){
		$query='SELECT  id,
			staffCode,
			topic,
			improvementType,
			yearPlan,
			description,
			academicYear,
			budget,
			sourceDepartment,
			sourceType,
			duration,
			monthPlan
		FROM t_improveplan WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id',$this->id);
		$stmt->execute();
		return $stmt;
	}
	public function getData($keyWord){
		$key=KeyWord::getKeyWord($this->conn,$this->table_name);
		$key=($key!="")?$key:"keyWord";
		$query='SELECT  id,
			staffCode,
			topic,
			improvementType,
			yearPlan,
			description,
			academicYear,
			budget,
			sourceDepartment,
			sourceType,
			duration,
			monthPlan
		FROM t_improveplan WHERE '.$key.' LIKE :keyWord';
		$stmt = $this->conn->prepare($query);
		$keyWord="%{$keyWord}%";
		$stmt->bindParam(':keyWord',$keyWord);
		$stmt->execute();
		return $stmt;
	}
	function delete(){
		$query='DELETE FROM t_improveplan WHERE id=:id';
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
		$query ="SELECT MAX(CODE) AS MXCode FROM t_improveplan WHERE CODE LIKE ?";
		$stmt = $this->conn->prepare($query);
		$prefix="{$prefix}%";
		$stmt->bindParam(1, $prefix);
		$stmt->execute();
		return $stmt;
	}
}

?>