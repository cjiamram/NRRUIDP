<?php
include_once "keyWord.php";
include_once "manage.php";
class  tmember{
	private $conn;
	private $table_name="t_member";
	public function __construct($db){
            $this->conn = $db;
        	}
	public $memberCode;
	public $title;
	public $firstName;
	public $lastName;
	public $nickName;
	public $birthDate;
	public $picture;
	public $profile;
	public $homeNo;
	public $moo;
	public $village;
	public $street;
	public $subDistrict;
	public $district;
	public $province;
	public $postalCode;
	public $telNo;
	public $email;
	public $facebook;
	public $lineId;
	public $workPlaceName;
	public $workplaceNo;
	public $workBuilding;
	public $workSoi;
	public $workStreet;
	public $workSubDistrict;
	public $workDistrict;
	public $workProvince;
	public $workPostalCode;
	public $workTel;
	public $sttusAprove;
	public $registerDate;
	//public $addressLocation;
	//public $workLocation;
	
	public function validEmail($email){
		$query="SELECT email FROM t_member WHERE email=:email";
		$stmt=$this->conn->prepare($query);
		$stmt->bindParam("email",$email);
		$stmt->execute();
		if($stmt->rowCount()>0)
			return true;
		else
			return false;
	}

	public function create(){
		$query="INSERT INTO t_member  
        	SET 
				memberCode=:memberCode,
				title=:title,
				firstName=:firstName,
				lastName=:lastName,
				nickName=:nickName,
				birthDate=:birthDate,
				profile=:profile,
				homeNo=:homeNo,
				moo=:moo,
				village=:village,
				street=:street,
				subDistrict=:subDistrict,
				district=:district,
				province=:province,
				postalCode=:postalCode,
				telNo=:telNo,
				email=:email,
				facebook=:facebook,
				lineId=:lineId,
				workPlaceName=:workPlaceName,
				workplaceNo=:workplaceNo,
				workBuilding=:workBuilding,
				workSoi=:workSoi,
				workStreet=:workStreet,
				workSubDistrict=:workSubDistrict,
				workDistrict=:workDistrict,
				workProvince=:workProvince,
				workPostalCode=:workPostalCode,
				workTel=:workTel,
				sttusAprove=:sttusAprove,
				registerDate=:registerDate";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":memberCode",$this->memberCode);
		$stmt->bindParam(":title",$this->title);
		$stmt->bindParam(":firstName",$this->firstName);
		$stmt->bindParam(":lastName",$this->lastName);
		$stmt->bindParam(":nickName",$this->nickName);
		$stmt->bindParam(":birthDate",$this->birthDate);
		$stmt->bindParam(":profile",$this->profile);
		$stmt->bindParam(":homeNo",$this->homeNo);
		$stmt->bindParam(":moo",$this->moo);
		$stmt->bindParam(":village",$this->village);
		$stmt->bindParam(":street",$this->street);
		$stmt->bindParam(":subDistrict",$this->subDistrict);
		$stmt->bindParam(":district",$this->district);
		$stmt->bindParam(":province",$this->province);
		$stmt->bindParam(":postalCode",$this->postalCode);
		$stmt->bindParam(":telNo",$this->telNo);
		$stmt->bindParam(":email",$this->email);
		$stmt->bindParam(":facebook",$this->facebook);
		$stmt->bindParam(":lineId",$this->lineId);
		$stmt->bindParam(":workPlaceName",$this->workPlaceName);
		$stmt->bindParam(":workplaceNo",$this->workplaceNo);
		$stmt->bindParam(":workBuilding",$this->workBuilding);
		$stmt->bindParam(":workSoi",$this->workSoi);
		$stmt->bindParam(":workStreet",$this->workStreet);
		$stmt->bindParam(":workSubDistrict",$this->workSubDistrict);
		$stmt->bindParam(":workDistrict",$this->workDistrict);
		$stmt->bindParam(":workProvince",$this->workProvince);
		$stmt->bindParam(":workPostalCode",$this->workPostalCode);
		$stmt->bindParam(":workTel",$this->workTel);
		$stmt->bindParam(":sttusAprove",$this->sttusAprove);
		$stmt->bindParam(":registerDate",$this->registerDate);
		$flag=$stmt->execute();
		return $flag;
	}
	public function update(){
		$query="UPDATE t_member 
        	SET 
				memberCode=:memberCode,
				title=:title,
				firstName=:firstName,
				lastName=:lastName,
				nickName=:nickName,
				birthDate=:birthDate,
				profile=:profile,
				homeNo=:homeNo,
				moo=:moo,
				village=:village,
				street=:street,
				subDistrict=:subDistrict,
				district=:district,
				province=:province,
				postalCode=:postalCode,
				telNo=:telNo,
				email=:email,
				facebook=:facebook,
				lineId=:lineId,
				workPlaceName=:workPlaceName,
				workplaceNo=:workplaceNo,
				workBuilding=:workBuilding,
				workSoi=:workSoi,
				workStreet=:workStreet,
				workSubDistrict=:workSubDistrict,
				workDistrict=:workDistrict,
				workProvince=:workProvince,
				workPostalCode=:workPostalCode,
				workTel=:workTel,
				sttusAprove=:sttusAprove,
				registerDate=:registerDate
		 WHERE id=:id";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":memberCode",$this->memberCode);
		$stmt->bindParam(":title",$this->title);
		$stmt->bindParam(":firstName",$this->firstName);
		$stmt->bindParam(":lastName",$this->lastName);
		$stmt->bindParam(":nickName",$this->nickName);
		$stmt->bindParam(":birthDate",$this->birthDate);
		$stmt->bindParam(":profile",$this->profile);
		$stmt->bindParam(":homeNo",$this->homeNo);
		$stmt->bindParam(":moo",$this->moo);
		$stmt->bindParam(":village",$this->village);
		$stmt->bindParam(":street",$this->street);
		$stmt->bindParam(":subDistrict",$this->subDistrict);
		$stmt->bindParam(":district",$this->district);
		$stmt->bindParam(":province",$this->province);
		$stmt->bindParam(":postalCode",$this->postalCode);
		$stmt->bindParam(":telNo",$this->telNo);
		$stmt->bindParam(":email",$this->email);
		$stmt->bindParam(":facebook",$this->facebook);
		$stmt->bindParam(":lineId",$this->lineId);
		$stmt->bindParam(":workPlaceName",$this->workPlaceName);
		$stmt->bindParam(":workplaceNo",$this->workplaceNo);
		$stmt->bindParam(":workBuilding",$this->workBuilding);
		$stmt->bindParam(":workSoi",$this->workSoi);
		$stmt->bindParam(":workStreet",$this->workStreet);
		$stmt->bindParam(":workSubDistrict",$this->workSubDistrict);
		$stmt->bindParam(":workDistrict",$this->workDistrict);
		$stmt->bindParam(":workProvince",$this->workProvince);
		$stmt->bindParam(":workPostalCode",$this->workPostalCode);
		$stmt->bindParam(":workTel",$this->workTel);
		$stmt->bindParam(":sttusAprove",$this->sttusAprove);
		$stmt->bindParam(":registerDate",$this->registerDate);
		$stmt->bindParam(":id",$this->id);
		$flag=$stmt->execute();
		return $flag;
	}
	public function readOne(){
		$query='SELECT  id,
			memberCode,
			title,
			firstName,
			lastName,
			nickName,
			birthDate,
			profile,
			homeNo,
			moo,
			village,
			street,
			subDistrict,
			district,
			province,
			postalCode,
			telNo,
			email,
			facebook,
			lineId,
			workPlaceName,
			workplaceNo,
			workBuilding,
			workSoi,
			workStreet,
			workSubDistrict,
			workDistrict,
			workProvince,
			workPostalCode,
			workTel,
			sttusAprove,
			registerDate
		FROM t_member WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id',$this->id);
		$stmt->execute();
		return $stmt;
	}
	public function getData($keyWord){
	
		$query="SELECT  id,
			memberCode,
			title,
			firstName,
			lastName,
			nickName,
			birthDate,
			profile,
			homeNo,
			moo,
			village,
			street,
			subDistrict,
			district,
			province,
			postalCode,
			telNo,
			email,
			facebook,
			lineId,
			workPlaceName,
			workplaceNo,
			workBuilding,
			workSoi,
			workStreet,
			workSubDistrict,
			workDistrict,
			workProvince,
			workPostalCode,
			workTel,
			sttusAprove,
			registerDate
		FROM t_member 
		WHERE CONCAT(memberCode,' ',title,' ',firstName,' ',lastName) 
		LIKE :keyWord";
		$stmt = $this->conn->prepare($query);
		$keyWord="%{$keyWord}%";
		$stmt->bindParam(':keyWord',$keyWord);
		$stmt->execute();
		return $stmt;
	}
	function delete(){
		$query='DELETE FROM t_member WHERE id=:id';
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
		$query ="SELECT MAX(memberCode) AS MXCode 
		FROM t_member WHERE memberCode LIKE ?";
		$stmt = $this->conn->prepare($query);
		$p="{$prefix}%";
		$stmt->bindParam(1, $p);
		$stmt->execute();
		$MXCode=$p."0001";
		if($stmt->rowCount()>0){
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
			extract($row);
			$res = Format::getLengthFormat(intval(substr($MXCode, 5, 4))+1,4); 
			$MXCode=$prefix.$res;
		}
		return $MXCode;
	}
}

?>