<?php

	class Data{
		private $conn;
		private $table_name="t_academicplan";
		public function __construct($db){
	            $this->conn = $db;
	       }



	    public function getCountYear($sYear,$fYear,$depArr){
	    	$query="SELECT yearPlan,COUNT(id) AS countPlan
	    			FROM (SELECT id,1 AS pType,budget,departmentId,yearPlan
						FROM t_academicplan 
					UNION 
						SELECT id,2 AS pType,budget,departmentId,yearPlan 
						FROM t_research 
					UNION 
						SELECT A.id,3 AS pType,0 AS budget,A.departmentId,A.yearPlan 
						FROM t_upposition A 
						LEFT OUTER JOIN t_specialize B ON A.expertType=B.code 
					UNION
						SELECT id,4 AS pType,budget,departmentId,yearPlan 
						FROM t_semina
					UNION
						SELECT id,5 AS pType,budget,departmentId,yearPlan 
						FROM t_visit) AS V

				WHERE V.yearPlan BETWEEN :sYear AND :fYear 
				AND V.yearPlan IS NOT NULL 
				AND departmentId IN (".$depArr.")
				GROUP BY V.yearPlan ORDER BY V.yearPlan 

				 ";
				 $stmt=$this->conn->prepare($query);
				 $stmt->bindParam(":sYear",$sYear);
				 $stmt->bindParam(":fYear",$fYear);
				 $stmt->execute();
				 return $stmt;
	    }

	     public function getCountDepartmentByYear($Year,$depArr){
	    	$query="SELECT A.departmentName,COUNT(V.id) AS countPlan
	    			FROM (SELECT id,1 AS pType,budget,departmentId,yearPlan
						FROM t_academicplan 
					UNION 
						SELECT id,2 AS pType,budget,departmentId,yearPlan 
						FROM t_research 
					UNION 
						SELECT A.id,3 AS pType,0 AS budget,A.departmentId,A.yearPlan 
						FROM t_upposition A 
						LEFT OUTER JOIN t_specialize B ON A.expertType=B.code 
					UNION
						SELECT id,4 AS pType,budget,departmentId,yearPlan 
						FROM t_semina
					UNION
						SELECT id,5 AS pType,budget,departmentId,yearPlan 
						FROM t_visit) AS V 
				LEFT OUTER JOIN t_department A ON V.departmentId=A.departmentId 

				WHERE V.yearPlan LIKE :year 
				AND A.departmentName IS NOT NULL 
				AND V.departmentId IN (".$depArr.")
				GROUP BY A.departmentName";
				$Year=trim($Year); 
				$Year="{$Year}%";
				$stmt=$this->conn->prepare($query);
				$stmt->bindParam(":year",$Year);
				$stmt->execute();
				return $stmt;
	    }


	    public function getCountPTypeByYear($Year,$depArr){
	    	$query="SELECT A.pType,COUNT(V.id) AS countPlan
	    			FROM (SELECT id,1 AS pType,budget,departmentId,yearPlan
						FROM t_academicplan 
					UNION 
						SELECT id,2 AS pType,budget,departmentId,yearPlan 
						FROM t_research 
					UNION 
						SELECT A.id,3 AS pType,0 AS budget,A.departmentId,A.yearPlan 
						FROM t_upposition A 
						LEFT OUTER JOIN t_specialize B ON A.expertType=B.code 
					UNION
						SELECT id,4 AS pType,budget,departmentId,yearPlan 
						FROM t_semina
					UNION
						SELECT id,5 AS pType,budget,departmentId,yearPlan 
						FROM t_visit) AS V 
				LEFT OUTER JOIN t_ptype A ON V.pType=A.code 

				WHERE V.yearPlan LIKE :year 
				AND V.yearPlan IS NOT NULL
				AND V.departmentId IN (".$depArr.") 
				GROUP BY A.pType 
				";
				$Year=trim($Year); 
				$Year="{$Year}%";
				//print_r($Year);
				$stmt=$this->conn->prepare($query);
				$stmt->bindParam(":year",$Year);
				$stmt->execute();
				return $stmt;
	    }

	    //********************************************************************

	    public function getPivot($sYear,$fYear,$depArr){
	    	$query="SELECT DISTINCT
				D.departmentName,
				B.pType,
				V.yearPlan,
				SUM(budget) AS Budget,
	    		COUNT(V.id) AS CNT
			FROM (SELECT id,1 AS pType,userCode,budget,departmentId,yearPlan
				FROM t_academicplan 
			UNION 
				SELECT id,2 AS pType,userCode,budget,departmentId,yearPlan 
				FROM t_research 
			UNION 
				SELECT A.id,3 AS pType,0 AS budget,A.userCode,A.departmentId,A.yearPlan 
				FROM t_upposition A 
				LEFT OUTER JOIN t_specialize B ON A.expertType=B.code 
			UNION
				SELECT id,4 AS pType,budget,userCode,departmentid,yearPlan 
				FROM t_semina
			UNION
				SELECT id,5 AS pType,budget,userCode,departmentid,yearPlan 
				FROM t_visit) 
			AS V
			LEFT OUTER JOIN t_ptype B 
			ON V.ptype=B.code 
			LEFT OUTER JOIN t_fullname C 
			ON V.userCode=C.userCode 
			INNER JOIN t_department D 
			ON V.departmentId=D.departmentId
			WHERE V.yearPlan BETWEEN :sYear AND :fYear
			AND V.departmentId IN (".$depArr.")
		
			GROUP BY 
			D.departmentName,B.pType,V.yearPlan
			";
			
			$stmt=$this->conn->prepare($query);
			$stmt->bindParam(":sYear",$sYear);
			$stmt->bindParam(":fYear",$fYear);
			$stmt->execute();
			return $stmt;
	    }

	      public function getBudgetDepartmentByPType($sYear,$fYear,$pType){
	    	$query="SELECT 
				D.departmentName,
	    		SUM(V.budget) AS Budget
			FROM (SELECT id,1 AS pType,userCode,budget,departmentId,yearPlan
				FROM t_academicplan 
			UNION 
				SELECT id,2 AS pType,userCode,budget,departmentId,yearPlan 
				FROM t_research 
			UNION 
				SELECT A.id,3 AS pType,0 AS budget,A.userCode,A.departmentId,A.yearPlan 
				FROM t_upposition A 
				LEFT OUTER JOIN t_specialize B ON A.expertType=B.code 
			UNION
				SELECT id,4 AS pType,budget,userCode,departmentid,yearPlan 
				FROM t_semina
			UNION
				SELECT id,5 AS pType,budget,userCode,departmentid,yearPlan 
				FROM t_visit) 
			AS V
			LEFT OUTER JOIN t_ptype B 
			ON V.ptype=B.code 
			LEFT OUTER JOIN t_fullname C 
			ON V.userCode=C.userCode 
			INNER JOIN t_department D 
			ON V.departmentId=D.departmentId
			WHERE V.yearPlan BETWEEN :sYear AND :fYear
			AND pType LIKE :pType 
			GROUP BY 
			D.departmentName
			";
			$pType ="{$pType}%";
			$stmt=$this->conn->prepare($query);
			$stmt->bindParam(":sYear",$sYear);
			$stmt->bindParam(":fYear",$fYear);
			$stmt->bindParam(":pType",$pType);
			$stmt->execute();
			return $stmt;
	    }  

	    public function getCountDepartmentByPType($sYear,$fYear,$pType){
	    	$query="SELECT 
				D.departmentName,
	    		COUNT(V.id) AS countPlan

			FROM (SELECT id,1 AS pType,userCode,budget,departmentId,yearPlan
				FROM t_academicplan 
			UNION 
				SELECT id,2 AS pType,userCode,budget,departmentId,yearPlan 
				FROM t_research 
			UNION 
				SELECT A.id,3 AS pType,0 AS budget,A.userCode,A.departmentId,A.yearPlan 
				FROM t_upposition A 
				LEFT OUTER JOIN t_specialize B ON A.expertType=B.code 
			

				SELECT id,4 AS pType,budget,userCode,departmentid,yearPlan 
				FROM t_semina
			UNION
				SELECT id,5 AS pType,budget,userCode,departmentid,yearPlan 
				FROM t_visit) 
			AS V
			LEFT OUTER JOIN t_ptype B 
			ON V.ptype=B.code 
			LEFT OUTER JOIN t_fullname C 
			ON V.userCode=C.userCode 
			INNER JOIN t_department D 
			ON V.departmentId=D.departmentId
			WHERE V.yearPlan BETWEEN :sYear AND :fYear
			AND pType LIKE :pType 
			GROUP BY 
			D.departmentName
			";
			$pType ="{$pType}%";
			$stmt=$this->conn->prepare($query);
			$stmt->bindParam(":sYear",$sYear);
			$stmt->bindParam(":fYear",$fYear);
			$stmt->bindParam(":pType",$pType);
			$stmt->execute();
			return $stmt;
	    } 


	    public function getCountDepartment($sYear,$fYear,$depArr){
	    	$query="SELECT 
				D.departmentName,
				V.departmentId AS departmentCode,
	    		COUNT(V.id) AS CNT,
	    		SUM(V.budget) AS Budget 

			FROM (SELECT id,1 AS pType,userCode,budget,departmentId,yearPlan
				FROM t_academicplan 
			UNION 
				SELECT id,2 AS pType,userCode,budget,departmentId,yearPlan 
				FROM t_research 
			UNION 
				SELECT A.id,3 AS pType,0 AS budget,A.userCode,A.departmentId,A.yearPlan 
				FROM t_upposition A 
				LEFT OUTER JOIN t_specialize B ON A.expertType=B.code 
			UNION
				SELECT id,4 AS pType,budget,userCode,departmentid,yearPlan 
				FROM t_semina
			UNION
				SELECT id,5 AS pType,budget,userCode,departmentid,yearPlan 
				FROM t_visit) 
			AS V
			LEFT OUTER JOIN t_ptype B 
			ON V.ptype=B.code 
			LEFT OUTER JOIN t_fullname C 
			ON V.userCode=C.userCode 
			INNER JOIN t_department D 
			ON V.departmentId=D.departmentId
			WHERE V.yearPlan BETWEEN :sYear AND :fYear 

			AND V.departmentId IN (".$depArr.")
			GROUP BY 
			D.departmentName,
			V.departmentId
			";
			
			$stmt=$this->conn->prepare($query);
			$stmt->bindParam(":sYear",$sYear);
			$stmt->bindParam(":fYear",$fYear);
			$stmt->execute();
			return $stmt;
	    } 


	    public function getCountPtypeByDepartment($sYear,$fYear,$departmentCode){
	    	$query="SELECT 
	    		B.pType,
	    		V.pType AS pTypeCode,
	    		COUNT(V.id) AS CNT,
	    		SUM(V.budget) AS Budget 

			FROM (SELECT id,1 AS pType,userCode,budget,departmentId,yearPlan
				FROM t_academicplan 
			UNION 
				SELECT id,2 AS pType,userCode,budget,departmentId,yearPlan 
				FROM t_research 
			UNION 
				SELECT A.id,3 AS pType,0 AS budget,A.userCode,A.departmentId,A.yearPlan 
				FROM t_upposition A 
				LEFT OUTER JOIN t_specialize B ON A.expertType=B.code 
			UNION
				SELECT id,4 AS pType,budget,userCode,departmentid,yearPlan 
				FROM t_semina
			UNION
				SELECT id,5 AS pType,budget,userCode,departmentid,yearPlan 
				FROM t_visit) 
			AS V
			LEFT OUTER JOIN t_ptype B 
			ON V.ptype=B.code 
			LEFT OUTER JOIN t_fullname C 
			ON V.userCode=C.userCode 
			INNER JOIN t_department D 
			ON V.departmentId=D.departmentId
			WHERE V.yearPlan BETWEEN :sYear AND :fYear
			AND V.departmentId LIKE :departmentCode
			GROUP BY 
			B.pType,V.pType
			";
			$departmentCode="{$departmentCode}%";
			$stmt=$this->conn->prepare($query);
			$stmt->bindParam(":sYear",$sYear);
			$stmt->bindParam(":fYear",$fYear);
			$stmt->bindParam(":departmentCode",$departmentCode);
			$stmt->execute();
			return $stmt;
	    }

	    public function getCountPtype($sYear,$fYear,$depArr){
	    	$query="SELECT 
	    		B.pType,
	    		V.pType AS pTypeCode,
	    		COUNT(V.id) AS CNT,
	    		SUM(V.budget) AS Budget 

			FROM (SELECT id,1 AS pType,userCode,budget,departmentId,yearPlan
				FROM t_academicplan 
			UNION 
				SELECT id,2 AS pType,userCode,budget,departmentId,yearPlan 
				FROM t_research 
			UNION 
				SELECT A.id,3 AS pType,0 AS budget,A.userCode,A.departmentId,A.yearPlan 
				FROM t_upposition A 
				LEFT OUTER JOIN t_specialize B ON A.expertType=B.code 
			UNION
				SELECT id,4 AS pType,budget,userCode,departmentid,yearPlan 
				FROM t_semina
			UNION
				SELECT id,5 AS pType,budget,userCode,departmentid,yearPlan 
				FROM t_visit) 
			AS V
			LEFT OUTER JOIN t_ptype B 
			ON V.ptype=B.code 
			LEFT OUTER JOIN t_fullname C 
			ON V.userCode=C.userCode 
			INNER JOIN t_department D 
			ON V.departmentId=D.departmentId
			WHERE V.yearPlan BETWEEN :sYear AND :fYear
			AND V.departmentId IN(".$depArr.")
			GROUP BY 
			B.pType,V.pType
			";
			$stmt=$this->conn->prepare($query);
			$stmt->bindParam(":sYear",$sYear);
			$stmt->bindParam(":fYear",$fYear);
			$stmt->execute();
			return $stmt;
	    }


	    public function getPlanStatus($sYear,$fYear,$pType){
	    		$query="SELECT 

				V.planStatus
				COUNT(V.id) AS CountPlan
				FROM (

						SELECT id,1 AS pType,userCode,budget,departmentId,yearPlan,isAprove,
						IF(YEAR((CURDATE())+543>yearPlan AND isAprove=1),
						5,isAprove) AS planStatus
						FROM t_academicplan 


						UNION 
						SELECT id,2 AS pType,userCode,budget,departmentId,yearPlan,isAprove,
						IF(YEAR((CURDATE())+543>yearPlan AND isAprove=1),
						5,isAprove) AS planStatus 
						FROM t_research 


						UNION 
						SELECT A.id,3 AS pType,A.userCode,0 AS budget,A.departmentId,A.yearPlan,A.isAprove,
						IF(YEAR((CURDATE())+543>A.yearPlan AND A.isAprove=1),
						5,A.isAprove) AS planStatus 
						FROM t_upposition A 
						LEFT OUTER JOIN t_specialize B ON A.expertType=B.code 


						UNION
						SELECT id,4 AS pType,budget,userCode,departmentid,yearPlan,isAprove,
						IF(YEAR((CURDATE())+543>yearPlan AND isAprove=1),
						5,isAprove) AS planStatus
						FROM t_semina

						UNION
						SELECT id,5 AS pType,budget,userCode,departmentid,yearPlan,isAprove,IF(YEAR((CURDATE())+543>yearPlan AND isAprove=1),
						5,isAprove) AS planStatus 
						FROM t_visit



				) AS V
				LEFT OUTER JOIN  
				t_specialize A ON
				V.pType=A.code
				LEFT OUTER JOIN t_status B
				ON V.planStatus=B.code
				LEFT OUTER JOIN t_department C 
				ON V.departmentId=C.departmentcode
				LEFT OUTER JOIN t_specialize D 
				ON V.pType=D.code

				WHERE (V.yearPlan BETWEEN :sDate AND :fDate)
				AND  V.pType LIKE :pType

				GROUP BY 
				V.pType,
				V.yearPlan,
				C.departmentName,
				D.specialize,
				V.planStatus";


				$stmt=$this->conn->prepare($query);
				$stmt->bindParam(":sYear",$sYear);
				$stmt->bindParam(":fYear",$fYear);
				$stmt->bindParam(":pType",$pType);

				$stmt->execute();
				return $stmt;
	    } 


	    public function getProgressByPtype($sYear,$fYear,$depArr,$pType){
	    	$query="SELECT planStatus,SUM(CountPlan) AS countPlan FROM (SELECT 
				DISTINCT

				B.status AS planStatus,
				1 AS CountPlan
				FROM (

						SELECT 1 AS CNT,1 AS pType,userCode,budget,departmentId,yearPlan,isAprove,
						IF(YEAR((CURDATE())+543>yearPlan AND isAprove=1),
						5,isAprove) AS planStatus
						FROM t_academicplan 


						UNION 
						SELECT 1 AS CNT,2 AS pType,userCode,budget,departmentId,yearPlan,isAprove,
						IF(YEAR((CURDATE())+543>yearPlan AND isAprove=1),
						5,isAprove) AS planStatus 
						FROM t_research 


						UNION 
						SELECT 1 AS CNT,3 AS pType,A.userCode,0 AS budget,A.departmentId,A.yearPlan,A.isAprove,
						IF(YEAR((CURDATE())+543>A.yearPlan AND A.isAprove=1),
						5,A.isAprove) AS planStatus 
						FROM t_upposition A 
						LEFT OUTER JOIN t_specialize B ON A.expertType=B.code 


						UNION
						SELECT 1 AS CNT,4 AS pType,budget,userCode,departmentid AS departmentId,yearPlan,isAprove,
						IF(YEAR((CURDATE())+543>yearPlan AND isAprove=1),
						5,isAprove) AS planStatus
						FROM t_semina

						UNION
						SELECT 1 AS CNT,5 AS pType,budget,userCode,departmentid AS departmentId,yearPlan,isAprove,IF(YEAR((CURDATE())+543>yearPlan AND isAprove=1),
						5,isAprove) AS planStatus 
						FROM t_visit


				) AS V
				LEFT OUTER JOIN  
				t_specialize A ON
				V.pType=A.code
				INNER JOIN t_status B
				ON V.planStatus=B.code
				INNER JOIN t_department C 
				ON V.departmentId=C.departmentcode
				WHERE (V.yearPlan BETWEEN :sYear AND :fYear) AND 
				C.departmentName IS NOT NULL 
				AND V.departmentId IN (".$depArr.") AND 
				V.pType LIKE :pType AND V.planStatus<>2
				) AS V1 
				
				GROUP BY V1.planStatus

				";

				//print_r($query);


				$stmt=$this->conn->prepare($query);
				$stmt->bindParam(":sYear",$sYear);
				$stmt->bindParam(":fYear",$fYear);
				$pType="%{$pType}%";
				$stmt->bindParam(":pType",$pType);
				$stmt->execute();
				return $stmt;

	    }


	    public function getPivotProgress($sYear,$fYear,$depArr){
	    	$query="SELECT yearPlan,pType,departmentName,planStatus,SUM(CountPlan) AS CountPlan FROM 
	    		(SELECT 
				DISTINCT
				V.yearPlan,
				A.pType,
				C.departmentName,
				B.status AS planStatus,
				1 AS CountPlan
				FROM (

				SELECT 1 AS CNT,1 AS pType,userCode,budget,departmentId,yearPlan,isAprove,
				IF(YEAR((CURDATE())+543>yearPlan AND isAprove=1),
				5,isAprove) AS planStatus
				FROM t_academicplan 


				UNION 
				SELECT 1 AS CNT,2 AS pType,userCode,budget,departmentId,yearPlan,isAprove,
				IF(YEAR((CURDATE())+543>yearPlan AND isAprove=1),
				5,isAprove) AS planStatus 
				FROM t_research 


				UNION 
				SELECT 1 AS CNT,3 AS pType,A.userCode,0 AS budget,A.departmentId,A.yearPlan,A.isAprove,
				IF(YEAR((CURDATE())+543>A.yearPlan AND A.isAprove=1),
				5,A.isAprove) AS planStatus 
				FROM t_upposition A 
				LEFT OUTER JOIN t_specialize B ON A.expertType=B.code 


				UNION
				SELECT 1 AS CNT,4 AS pType,budget,userCode,departmentid AS departmentId,yearPlan,isAprove,
				IF(YEAR((CURDATE())+543>yearPlan AND isAprove=1),
				5,isAprove) AS planStatus
				FROM t_semina

				UNION
				SELECT 1 AS CNT,5 AS pType,budget,userCode,departmentid AS departmentId,yearPlan,isAprove,IF(YEAR((CURDATE())+543>yearPlan AND isAprove=1),
				5,isAprove) AS planStatus 
				FROM t_visit



				) AS V
				LEFT OUTER JOIN  
				t_ptype A ON
				V.pType=A.code
				INNER JOIN t_status B
				ON V.planStatus=B.code
				INNER JOIN t_department C 
				ON V.departmentId=C.departmentcode
			

				WHERE (V.yearPlan BETWEEN :sYear AND :fYear) AND 
				C.departmentName IS NOT NULL 
				AND V.departmentId IN (".$depArr.")
				
				) AS V1 
				
				GROUP BY yearPlan,pType,departmentName,planStatus

				";


				$stmt=$this->conn->prepare($query);
				$stmt->bindParam(":sYear",$sYear);
				$stmt->bindParam(":fYear",$fYear);
				$stmt->execute();
				return $stmt;

	    }


	    public function getDashboardList($departmentId,$pType,$sYear,$fYear){
	    	$query="SELECT
	    	V.id, 
	    	V.userCode,
	    	C.fullName,
	    	B.pType,
	    	V.pType AS pTypeCode,
	    	V.Topic,
	    	V.description,
	    	V.budget,
	    	V.departmentId,
	    	V.createDate,
	    	V.yearPlan,
	    	D.departmentName,
	    	E.status AS planStatus 
	    	FROM (
		    	SELECT id,1 AS pType, userCode,CONCAT(educationPlan,' ',eduCertificate) AS Topic,description,budget,departmentId,createDate,yearPlan,IF(YEAR((CURDATE())+543>yearPlan AND isAprove=1),
				5,isAprove) AS planStatus
				FROM t_academicplan 
			UNION 
				SELECT id,2 AS pType,userCode,research AS Topic,detail AS description,budget,departmentId,createDate,yearPlan,IF(YEAR((CURDATE())+543>yearPlan AND isAprove=1),
				5,isAprove) AS planStatus FROM t_research 
			UNION 
				SELECT A.id,3 AS pType,A.userCode,B.specialize AS Topic,A.description,0 AS budget,A.departmentId,A.createDate,A.yearPlan,IF(YEAR((CURDATE())+543>yearPlan AND isAprove=1),
				5,A.isAprove) AS planStatus FROM t_upposition A 
				LEFT OUTER JOIN t_specialize B ON A.expertType=B.code 
			UNION
				SELECT id,4 AS pType,userCode,improveSkill AS Topic,improveOpjective AS description,budget,departmentid,createDate,yearPlan,IF(YEAR((CURDATE())+543>yearPlan AND isAprove=1),
				5,isAprove) AS planStatus FROM t_semina
			UNION
				SELECT id,5 AS pType,userCode,visitObjective AS Topic,projectDetail AS description,budget,departmentid,createDate,yearPlan,IF(YEAR((CURDATE())+543>yearPlan AND isAprove=1),
				5,isAprove) AS planStatus FROM t_visit 
			) AS V 
			LEFT OUTER JOIN t_ptype B 
			ON V.ptype=B.code 
			LEFT OUTER JOIN t_fullname C 
			ON V.userCode=C.userCode 
			LEFT OUTER JOIN t_department D 
			ON V.departmentId=D.departmentId
			LEFT OUTER JOIN t_status E 
			ON V.planStatus=E.code

			WHERE 
			V.departmentid LIKE :department 
			AND 
			V.pType LIKE :pType 
			AND 
			V.yearPlan BETWEEN :sYear AND :fYear
			ORDER BY V.createDate DESC";
			
			$stmt=$this->conn->prepare($query);
			$department="%{$departmentId}%";
			$pType="%{$pType}%";
			$stmt->bindParam(":department",$department);
			$stmt->bindParam(":sYear",$sYear);
			$stmt->bindParam(":fYear",$fYear);
			$stmt->bindParam(":pType",$pType);
			$stmt->execute();
			return $stmt;
	    } 

	public function getDashboardList_1($departmentId,$pType,$sYear,$fYear,$staffType){
	    	$query="SELECT
	    	V.id, 
	    	V.userCode,
	    	C.fullName,
	    	B.pType,
	    	V.pType AS pTypeCode,
	    	V.Topic,
	    	V.description,
	    	V.budget,
	    	V.departmentId,
	    	V.createDate,
	    	V.yearPlan,
	    	D.departmentName,
	    	E.status AS planStatus,
	    	G.staffType AS staffGroup 
	    	FROM (
		    	SELECT id,1 AS pType, userCode,CONCAT(educationPlan,' ',eduCertificate) AS Topic,description,budget,departmentId,createDate,yearPlan,IF(YEAR((CURDATE())+543>yearPlan AND isAprove=1),
				5,isAprove) AS planStatus
				FROM t_academicplan 
			UNION 
				SELECT id,2 AS pType,userCode,research AS Topic,detail AS description,budget,departmentId,createDate,yearPlan,IF(YEAR((CURDATE())+543>yearPlan AND isAprove=1),
				5,isAprove) AS planStatus FROM t_research 
			UNION 
				SELECT A.id,3 AS pType,A.userCode,B.specialize AS Topic,A.description,0 AS budget,A.departmentId,A.createDate,A.yearPlan,IF(YEAR((CURDATE())+543>yearPlan AND isAprove=1),
				5,A.isAprove) AS planStatus FROM t_upposition A 
				LEFT OUTER JOIN t_specialize B ON A.expertType=B.code 
			UNION
				SELECT id,4 AS pType,userCode,improveSkill AS Topic,improveOpjective AS description,budget,departmentid,createDate,yearPlan,IF(YEAR((CURDATE())+543>yearPlan AND isAprove=1),
				5,isAprove) AS planStatus FROM t_semina
			UNION
				SELECT id,5 AS pType,userCode,visitObjective AS Topic,projectDetail AS description,budget,departmentid,createDate,yearPlan,IF(YEAR((CURDATE())+543>yearPlan AND isAprove=1),
				5,isAprove) AS planStatus FROM t_visit 
			) AS V 
			LEFT OUTER JOIN t_ptype B 
			ON V.ptype=B.code 
			LEFT OUTER JOIN t_fullname C 
			ON V.userCode=C.userCode 
			LEFT OUTER JOIN t_department D 
			ON V.departmentId=D.departmentId
			LEFT OUTER JOIN t_status E 
			ON V.planStatus=E.code 
			LEFT OUTER JOIN t_staffgroup F 
			ON V.userCode=F.userCode
			LEFT OUTER JOIN t_stafftype G
			ON F.staffGroup=G.code

			WHERE 
			V.departmentid LIKE :department 
			AND 
			V.pType LIKE :pType 
			AND 
			V.yearPlan BETWEEN :sYear AND :fYear
			AND 
			F.staffGroup LIKE :staffType 
			ORDER BY V.createDate DESC";
			
			$stmt=$this->conn->prepare($query);
			$department="%{$departmentId}%";
			$pType="%{$pType}%";
			$staffType="%{$staffType}%";
			$stmt->bindParam(":department",$department);
			$stmt->bindParam(":sYear",$sYear);
			$stmt->bindParam(":fYear",$fYear);
			$stmt->bindParam(":pType",$pType);
			$stmt->bindParam(":staffType",$staffType);
			$stmt->execute();
			return $stmt;
	    }

	public function getSelfAcademicPlan($userCode,$yearPlan){
		$query="SELECT id,1 AS pType, userCode,CONCAT(educationPlan,' ',eduCertificate) AS Topic,description,budget,departmentId,createDate,yearPlan,isAprove,
				IF(YEAR((CURDATE())+543>yearPlan AND isAprove=1),
				5,isAprove) AS planStatus
				FROM t_academicplan 
				WHERE userCode=:userCode AND yearPlan LIKE :yearPlan";
		$stmt=$this->conn->prepare($query);
		$stmt->bindParam(":userCode",$userCode);
		$yearPlan="{$yearPlan}%";
		$stmt->bindParam(":yearPlan",$yearPlan);

		$stmt->execute();
		return $stmt;
	}

	public function getSelfResearchPlan($userCode,$yearPlan){
		$query="SELECT id,2 AS pType,userCode,research AS Topic,detail AS description,budget,departmentId,createDate,yearPlan,isAprove,
				IF(YEAR((CURDATE())+543>yearPlan AND isAprove=1),
				5,isAprove) AS planStatus 
				FROM t_research 
				WHERE userCode=:userCode AND yearPlan LIKE :yearPlan";
		$stmt=$this->conn->prepare($query);
		$stmt->bindParam(":userCode",$userCode);
		$yearPlan="{$yearPlan}%";
		$stmt->bindParam(":yearPlan",$yearPlan);

		$stmt->execute();
		return $stmt;
	}

	public function getSelfUppositionPlan($userCode,$yearPlan){
		$query="SELECT A.id,3 AS pType,A.userCode,B.specialize AS Topic,A.description,0 AS budget,A.departmentId,A.createDate,A.yearPlan,A.isAprove,
				IF(YEAR((CURDATE())+543>A.yearPlan AND A.isAprove=1),
				5,A.isAprove) AS planStatus 
				FROM t_upposition A 
				LEFT OUTER JOIN t_specialize B ON A.expertType=B.code
				WHERE A.userCode=:userCode AND A.yearPlan LIKE :yearPlan";
		$stmt=$this->conn->prepare($query);
		$stmt->bindParam(":userCode",$userCode);
		$yearPlan="{$yearPlan}%";
		$stmt->bindParam(":yearPlan",$yearPlan);

		$stmt->execute();
		return $stmt;
	}

	public function getSelfSeminaPlan($userCode,$yearPlan){
		$query="SELECT id,4 AS pType,userCode,improveSkill AS Topic,improveOpjective AS description,budget,departmentid,createDate,yearPlan,isAprove,
				IF(YEAR((CURDATE())+543>yearPlan AND isAprove=1),
				5,isAprove) AS planStatus 
				FROM t_semina
				WHERE userCode=:userCode AND yearPlan LIKE :yearPlan";
		$stmt=$this->conn->prepare($query);
		$stmt->bindParam(":userCode",$userCode);
		$yearPlan="{$yearPlan}%";
		$stmt->bindParam(":yearPlan",$yearPlan);

		$stmt->execute();
		return $stmt;
	}

	public function getSelfVisitPlan($userCode,$yearPlan){
		$query="SELECT id,5 AS pType,userCode,visitObjective AS Topic,projectDetail AS description,budget,departmentid,createDate,yearPlan,isAprove,
				IF(YEAR((CURDATE())+543>yearPlan AND isAprove=1),
				5,isAprove) AS planStatus 
				FROM t_visit
				WHERE userCode=:userCode AND yearPlan LIKE :yearPlan";
		$stmt=$this->conn->prepare($query);
		$stmt->bindParam(":userCode",$userCode);
		$yearPlan="{$yearPlan}%";
		$stmt->bindParam(":yearPlan",$yearPlan);

		$stmt->execute();
		return $stmt;
	}

	public function getSelfSemina($userCode,$yearPlan){
	    	$query="SELECT
	    	V.id, 
	    	V.userCode,
	    	C.fullName,
	    	B.pType,
	    	V.pType AS pTypeCode,
	    	V.Topic,
	    	V.description,
	    	V.budget,
	    	V.departmentId,
	    	V.createDate,
	    	V.yearPlan,
	    	V.isAprove
	    	FROM (
		    	SELECT id,1 AS pType, userCode,CONCAT(educationPlan,' ',eduCertificate) AS Topic,description,budget,departmentId,createDate,yearPlan,isAprove
				FROM t_academicplan 
				WHERE userCode=:userCode AND yearPlan LIKE :yearPlan
			UNION 
				SELECT id,2 AS pType,userCode,research AS Topic,detail AS description,budget,departmentId,createDate,yearPlan,isAprove 
				FROM t_research 
				WHERE userCode=:userCode AND yearPlan LIKE :yearPlan
			UNION 
				SELECT A.id,3 AS pType,A.userCode,B.specialize AS Topic,A.description,0 AS budget,A.departmentId,A.createDate,A.yearPlan,A.isAprove=0 
				FROM t_upposition A 
				LEFT OUTER JOIN t_specialize B ON A.expertType=B.code
				WHERE A.userCode=:userCode AND A.yearPlan LIKE :yearPlan 
			UNION
				SELECT id,4 AS pType,userCode,improveSkill AS Topic,improveOpjective AS description,budget,departmentid,createDate,yearPlan,isAprove 
				FROM t_semina
				WHERE userCode=:userCode AND yearPlan LIKE :yearPlan 
			UNION
				SELECT id,5 AS pType,userCode,visitObjective AS Topic,projectDetail AS description,budget,departmentid,createDate,yearPlan,isAprove 
				FROM t_visit
				WHERE userCode=:userCode AND yearPlan LIKE :yearPlan
			) AS V 
			LEFT OUTER JOIN t_ptype B ON V.ptype=B.code 
			LEFT OUTER JOIN t_fullname C ON V.userCode=C.userCode 	
			ORDER BY V.createDate DESC";
			
			$stmt=$this->conn->prepare($query);
			$stmt->bindParam(":userCode",$userCode);
			$yearPlan="{$yearPlan}%";
			$stmt->bindParam(":yearPlan",$yearPlan);

			$stmt->execute();
			return $stmt;
	}  

	public function getSelfRequestReport($userCode,$yearPlan){
	    	$query="SELECT
	    	V.id, 
	    	V.userCode,
	    	C.fullName,
	    	B.pType,
	    	V.pType AS pTypeCode,
	    	V.Topic,
	    	V.description,
	    	V.budget,
	    	V.departmentId,
	    	V.createDate,
	    	V.yearPlan,
	    	V.isAprove,
	    	IF(YEAR((CURDATE())+543>V.yearPlan AND V.isAprove=1),
				5,V.isAprove) AS planStatus
	    	FROM (
		    	SELECT id,1 AS pType, userCode,CONCAT(educationPlan,' ',eduCertificate) AS Topic,description,budget,departmentId,createDate,yearPlan,isAprove
				FROM t_academicplan WHERE userCode=:userCode AND yearPlan=:yearPlan 
			UNION 
				SELECT id,2 AS pType,userCode,research AS Topic,detail AS description,budget,departmentId,createDate,yearPlan,isAprove 
				FROM t_research WHERE userCode=:userCode AND yearPlan=:yearPlan 
				
			UNION 
				SELECT A.id,3 AS pType,A.userCode,B.specialize AS Topic,A.description,0 AS budget,A.departmentId,A.createDate,A.yearPlan,A.isAprove
				FROM t_upposition A 
				LEFT OUTER JOIN t_specialize B ON A.expertType=B.code
				WHERE A.userCode=:userCode AND A.yearPlan=:yearPlan 
			UNION
				SELECT id,4 AS pType,userCode,improveSkill AS Topic,improveOpjective AS description,budget,departmentid,createDate,yearPlan,isAprove 
				FROM t_semina WHERE userCode=:userCode AND yearPlan=:yearPlan
			UNION
				SELECT id,5 AS pType,userCode,visitObjective AS Topic,projectDetail AS description,budget,departmentid,createDate,yearPlan,isAprove 
				FROM t_visit WHERE userCode=:userCode AND yearPlan=:yearPlan 
			) AS V 
			LEFT OUTER JOIN t_ptype B ON V.ptype=B.code 
			LEFT OUTER JOIN t_fullname C ON V.userCode=C.userCode 	

			

			ORDER BY createDate DESC";
			
			$stmt=$this->conn->prepare($query);
			$stmt->bindParam(":userCode",$userCode);
			$stmt->bindParam(":yearPlan",$yearPlan);
			$stmt->execute();
			return $stmt;
	    } 
	

	
	public function getRequestReport($departmentId,$keyWord){
	    	$query="SELECT
	    	V.id, 
	    	V.userCode,
	    	C.fullName,
	    	B.pType,
	    	V.pType AS pTypeCode,
	    	V.Topic,
	    	V.description,
	    	V.budget,
	    	V.departmentId,
	    	V.createDate,
	    	V.yearPlan,
	    	V.isAprove,
	    	V.planStatus
	    	FROM (
		    	SELECT id,1 AS pType, userCode,CONCAT(educationPlan,' ',eduCertificate) AS Topic,description,budget,departmentId,createDate,yearPlan,isAprove,
		    	IF(YEAR((CURDATE())+543>yearPlan AND isAprove=1),
				5,isAprove) AS planStatus
				FROM t_academicplan 
			UNION 
				SELECT id,2 AS pType,userCode,research AS Topic,detail AS description,budget,departmentId,createDate,yearPlan,isAprove,
				IF(YEAR((CURDATE())+543>yearPlan AND isAprove=1),
				5,isAprove) AS planStatus
				 FROM t_research 
				
			UNION 
				SELECT A.id,3 AS pType,A.userCode,B.specialize AS Topic,A.description,0 AS budget,A.departmentId,A.createDate,A.yearPlan,A.isAprove=0,
				IF(YEAR((CURDATE())+543>yearPlan AND A.isAprove=1),
				5,A.isAprove) AS planStatus
				 FROM t_upposition A 
				LEFT OUTER JOIN t_specialize B ON A.expertType=B.code 
			UNION
				SELECT id,4 AS pType,userCode,improveSkill AS Topic,improveOpjective AS description,budget,departmentid,createDate,yearPlan,isAprove,
				IF(YEAR((CURDATE())+543>yearPlan AND isAprove=1),
				5,isAprove) AS planStatus
				 FROM t_semina
			UNION
				SELECT id,5 AS pType,userCode,visitObjective AS Topic,projectDetail AS description,budget,departmentid,createDate,yearPlan,isAprove,
				IF(YEAR((CURDATE())+543>yearPlan AND isAprove=1),
				5,isAprove) AS planStatus
				 FROM t_visit 
			) AS V 
			LEFT OUTER JOIN t_ptype B ON V.ptype=B.code 
			LEFT OUTER JOIN t_fullname C ON V.userCode=C.userCode 	

			WHERE departmentid LIKE :department 
			AND C.fullName LIKE :keyWord

			ORDER BY createDate DESC";
			
			$stmt=$this->conn->prepare($query);
			$department="{$departmentId}%";
			$stmt->bindParam(":department",$department);
			$keyWord="%{$keyWord}%";
			$stmt->bindParam(":keyWord",$keyWord);
			$stmt->execute();
			return $stmt;
	    } 
	


	public function getRequest($departmentId,$keyWord){
	    	$query="SELECT
	    	V.id, 
	    	V.userCode,
	    	C.fullName,
	    	B.pType,
	    	V.pType AS pTypeCode,
	    	V.Topic,
	    	V.description,
	    	V.budget,
	    	V.departmentId,
	    	V.createDate,
	    	V.yearPlan
	    	 FROM (
		    	SELECT id,1 AS pType, userCode,CONCAT(educationPlan,' ',eduCertificate) AS Topic,description,budget,departmentId,createDate,yearPlan
				FROM t_academicplan WHERE isAprove=0
			UNION 
				SELECT id,2 AS pType,userCode,research AS Topic,detail AS description,budget,departmentId,createDate,yearPlan FROM t_research 
				WHERE isAprove=0
			UNION 
				SELECT A.id,3 AS pType,A.userCode,B.specialize AS Topic,A.description,0 AS budget,A.departmentId,A.createDate,A.yearPlan FROM t_upposition A 
				LEFT OUTER JOIN t_specialize B ON A.expertType=B.code WHERE A.isAprove=0
			UNION
				SELECT id,4 AS pType,userCode,improveSkill AS Topic,improveOpjective AS description,budget,departmentid,createDate,yearPlan FROM t_semina
				WHERE isAprove=0 
			UNION
				SELECT id,5 AS pType,userCode,visitObjective AS Topic,projectDetail AS description,budget,departmentid,createDate,yearPlan FROM t_visit 
				WHERE isAprove=0
			) AS V 
			LEFT OUTER JOIN t_ptype B ON V.ptype=B.code 
			LEFT OUTER JOIN t_fullname C ON V.userCode=C.userCode 	

			WHERE departmentid LIKE :department 
			AND C.fullName LIKE :keyWord

			ORDER BY createDate DESC";
			
			$stmt=$this->conn->prepare($query);
			$department="{$departmentId}%";
			$stmt->bindParam(":department",$department);
			$keyWord="%{$keyWord}%";
			$stmt->bindParam(":keyWord",$keyWord);
			$stmt->execute();
			return $stmt;
	    } 
	

	public function getAfterAprove($departmentId,$keyWord,$yearPlan,$staffType){
	    	$query="SELECT
	    	V.id, 
	    	V.userCode,
	    	C.fullName,
	    	B.pType,
	    	V.pType AS pTypeCode,
	    	V.Topic,
	    	V.description,
	    	V.budget,
	    	V.departmentId,
	    	V.createDate,
	    	V.yearPlan,
	    	E.status,
	    	G.staffType
	    	 FROM (
		    	SELECT id,1 AS pType, 
		    	userCode,
		    	CONCAT(educationPlan,' ',eduCertificate) AS Topic,
		    	description,budget,departmentId,createDate,yearPlan,
		    	IF(YEAR((CURDATE())+543>yearPlan AND isAprove=1),
				5,isAprove) AS planStatus	
				
				FROM t_academicplan WHERE isAprove<>0
			UNION 
				SELECT id,2 AS pType,
				userCode,
				research AS Topic,
				detail AS description,
				budget,
				departmentId,
				createDate,
				yearPlan, 
				IF(YEAR((CURDATE())+543>yearPlan AND isAprove=1),
				5,isAprove) AS planStatus	
				FROM t_research 
				WHERE isAprove<>0
			UNION 
				SELECT A.id,3 AS pType,
				A.userCode,
				B.specialize AS Topic,
				A.description,
				0 AS budget,
				A.departmentId,
				A.createDate,
				A.yearPlan, 
				IF(YEAR((CURDATE())+543>A.yearPlan AND A.isAprove=1),
				5,A.isAprove) AS planStatus	
				FROM t_upposition A 
				INNER JOIN t_specialize B ON A.expertType=B.code WHERE A.isAprove<>0
			UNION
				SELECT id,4 AS pType,
				userCode,
				improveSkill AS Topic,
				improveOpjective AS description,
				budget,
				departmentid,
				createDate,
				yearPlan, 
				IF(YEAR((CURDATE())+543>yearPlan AND isAprove=1),
				5,isAprove) AS planStatus	
				FROM t_semina
				WHERE isAprove<>0 
			UNION
				SELECT id,5 AS pType,
				userCode,
				visitObjective AS Topic,
				projectDetail AS description,
				budget,
				departmentid,
				createDate,
				yearPlan, 
				IF(YEAR((CURDATE())+543>yearPlan AND isAprove=1),
				5,isAprove) AS planStatus	
				FROM t_visit 
				WHERE isAprove<>0
			) AS V 
			LEFT OUTER JOIN t_ptype B ON V.ptype=B.code 
			LEFT OUTER JOIN t_fullname C ON V.userCode=C.userCode
			LEFT OUTER JOIN t_status E ON V.planStatus=E.code
			LEFT OUTER JOIN t_staffgroup F ON  V.userCode=F.userCode
			LEFT OUTER JOIN t_stafftype G ON F.staffGroup=G.code	
			WHERE departmentid LIKE :department 
			AND C.fullName LIKE :keyWord
			AND G.code LIKE :staffType
			AND V.yearPlan LIKE :yearPlan
			ORDER BY createDate DESC";
			
			$stmt=$this->conn->prepare($query);
			$department="{$departmentId}%";
			$stmt->bindParam(":department",$department);
			$keyWord="%{$keyWord}%";
			$stmt->bindParam(":keyWord",$keyWord);
			$staffType="{$staffType}%";
			$stmt->bindParam(":staffType",$staffType);
			$yearPlan="{$yearPlan}%";
			$stmt->bindParam(":yearPlan",$yearPlan);
			$stmt->execute();
			return $stmt;
	     
	}

}

?>