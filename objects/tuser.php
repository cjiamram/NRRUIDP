<?php
class tuser{
	private $conn;
	private $table_name;
	public function __construct($db){
            $this->conn = $db;
        	}
	public $UserName;
	public $Password;
	public $FullName;
	public $Picture;
	public $UserCode;
	public function create(){
		$query='INSERT INTO t_user  
        	SET 
			UserName=:UserName,
			Password=:Password,
			FullName=:FullName,
			Picture=:Picture,
			UserCode=:UserCode
	';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":UserName",$this->UserName);
		$stmt->bindParam(":Password",$this->Password);
		$stmt->bindParam(":FullName",$this->FullName);
		$stmt->bindParam(":Picture",$this->Picture);
		$stmt->bindParam(":UserCode",$this->UserCode);
		$flag=$stmt->execute();
		return $flag;
	}
	public function update(){
		$query='UPDATE t_user 
        	SET 
			UserName=:UserName,
			Password=:Password,
			FullName=:FullName,
			Picture=:Picture,
			UserCode=:UserCode
		 WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":UserName",$this->UserName);
		$stmt->bindParam(":Password",$this->Password);
		$stmt->bindParam(":FullName",$this->FullName);
		$stmt->bindParam(":Picture",$this->Picture);
		$stmt->bindParam(":UserCode",$this->UserCode);
		$stmt->bindParam(":id",$this->id);
		$flag=$stmt->execute();
		return $flag;
	}
	public function readOne(){
		$query='SELECT  id,
			UserName,
			Password,
			FullName,
			Picture,
			UserCode
		FROM t_user WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id',$this->id);
		$stmt->execute();
		return $stmt;
	}
	public function getData($keyWord){
		$query='SELECT  id,
			UserName,
			Password,
			FullName,
			Picture,
			UserCode
		FROM t_user WHERE keyWord LIKE :keyWord';
		$stmt = $this->conn->prepare($query);
		$keyWord="%{$keyWord}%";
		$stmt->bindParam(':keyWord',$keyWord);
		$stmt->execute();
		return $stmt;
	}
	function delete(){
		$query='DELETE FROM t_user WHERE id=:id';
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
		$query ="SELECT MAX(CODE) AS MXCode FROM t_user WHERE CODE LIKE ?";
		$stmt = $this->conn->prepare($query);
		$prefix="{$prefix}%";
		$stmt->bindParam(1, $prefix);
		$stmt->execute();
		return $stmt;
	}
}

?>