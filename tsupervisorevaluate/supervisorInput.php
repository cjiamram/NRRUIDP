<?php
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		header("Access-Control-Allow-Methods: POST");
		header("Access-Control-Max-Age: 3600");
		header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
		include_once "../config/database.php";
		include_once "../objects/tsupervisorevaluate.php";
		include_once "../objects/classLabel.php";
		include_once "../config/config.php";
		$cnf=new Config();
		$rootPath=$cnf->path;
		$database = new Database();
		$db = $database->getConnection();
		$objLbl = new ClassLabel($db);
		$topic= $objLbl->getLabel("t_supervisorevaluate","topic","th");

?>

<script src="<?=$rootPath?>/bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?=$rootPath?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?=$rootPath?>/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=$rootPath?>/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<style> 
div.scrollBox {
  height: 500px;
  width: 100%;
  overflow-y: scroll;
}
</style>

<input type="hidden" id="obj_id" value="">
<section class="content-header">
     <h1>
         <b>ระบบพัฒนาตนเอง</b>

        <small>>><?=$topic?></small>
      </h1>
      <ol class="breadcrumb">
        
        <!--<input type="button" id="btnInput"   class="btn btn-primary pull-right"  value="สร้าง">-->
      </ol>
 </section>

  <section class="content container-fluid">
<form role='form'>
<div class="box">
<div class="box box-warning">
		<div class='form-group'>
			<label class="col-sm-12">หน่วยงาน/คำค้น
				</label>
			
			<div class="col-sm-6">
				<select id="obj_departmentCode" class="form-control"></select>
			</div>
			<div class="col-sm-6">
				
			</div>
		</div>

		<div class='form-group'>
				<label class="col-sm-12">
				<?php echo $objLbl->getLabel("t_supervisorevaluate","userCode","th").":" ?>
				
			</label>	
				<div class="col-sm-6">
			   
			   <table width="100%">
			   	<tr>
			   		<td>
			   				<input type="text" 
							class="form-control" id='obj_userCode' 
							placeholder='<?=$objLbl->getLabel("t_supervisorevaluate","userCode","th")?>'>

			   		</td>
			   		<td width='150px'>
			   				<div id="dvSearchButton">
			   				<a href='#' id="btnSearch" class='btn btn-success'><i class="fa fa-search" aria-hidden="true"></i>&nbsp;ค้นหา<a>
			   				</div>
			   				<div id="dvDelButton" style="display:none">
			   				<a href='#' id="btnDel" class='btn btn-danger'><i class="fa fa-trash" aria-hidden="true"></i>&nbsp;ลบ<a>
			   				</div>
			   		</td>
			   		
			   	</tr>
			   </table>

			   </div>

			   <div class="col-sm-6">
				<input type="text" 
							class="form-control" id='obj_supervisorName' 
							placeholder='<?=$objLbl->getLabel("t_supervisorevaluate","supervisorName","th")?>'>
			   </div>
		</div>

		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_supervisorevaluate","evaluateLevel","th").":" ?>/<?php echo $objLbl->getLabel("t_supervisorevaluate","depPosition","th").":" ?></label>
			<div class="col-sm-6">
				<select class="form-control" id='obj_evaluateLevel' >
					<option value="1" >ระดับการประเมินที่ 1 ผู้บังคับบัญชาขั้นต้น</option>
					<option value="2">ระดับการประเมินที่ 2 ผู้บังคับบัญชาสูงสุด</option>
					
				</select>
			</div>
			<div class="col-sm-6">
				<input type="text" 
							class="form-control" id='obj_depPosition' 
							placeholder='<?=$objLbl->getLabel("t_supervisorevaluate","depPosition","th")?>'>
			</div>
		</div>
		
		<div class="form-group"><hr>
		</div>

		<div class="modal-footer">
          <a  id="btnSave" href="#" class="btn btn-primary pull-left"><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;บันทึก</a>
         </div>	
</div>

<div id="dvUnder" style="display:none">
<input type="checkbox" id="chkAll"><label>&nbsp;เลือกทั้งหมด</label>
<div class="box box-warning">
<div class="form-group">
	<div class="col-sm-1">
		<label>กรองข้อมูล</label>
	</div>
	<div class="col-sm-3">
		<input type="text" placeholder='[user name/ชื่อ-สกุล/]*' class="form-control" id="obj_keyWord">
	</div>
	<div class="col-sm-3">
		<select id="obj_departmentFilter" class="form-control">

		</select>
		
	</div>
	<div class="col-sm-5">&nbsp;
	</div>
</div>
<div class='scrollBox'>
<table id="tblDisplay"   class="table table-bordered table-hover ">

</table>
</div>
</div>
</div>


<div class="modal fade" id="modal-searchPanel">
 <div class="modal-dialog"  >
  <div class="modal-content">
      <div class="box-header with-border">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">ค้นหา</h4>
       </div>
       <div class="modal-body" id="dvSearch">
       	<table id="tblSearch" class="table table-bordered table-hover"></table>

       </div>
  </div>
 </div>
</div>
</form>
</section>

<script>



   function deleteSupervisor(){
   		
   		if($("#obj_userCode").val()!==""&&$("#obj_departmentCode").val()!=="" ){
		   		var url="<?=$rootPath?>/tsupervisorevaluate/deleteSupervisor.php?userCode="+$("#obj_userCode").val()+"&departmentCode="+$("#obj_departmentCode").val();
		   		var flag=executeGet(url);

		   		url="<?=$rootPath?>/tunderevaluate/deleteBySupervisor.php?supervisorCode="+$("#obj_userCode").val()+"&departmentCode="+$("#obj_departmentCode").val();
		   		flag&=executeGet(url);
		   		displayUser();
   		}else{
		   		 swal.fire({
					title: "กรุณาระบุหน่วยงานและชื่อของผู้ประเมินให้ถูกต้อง!",
					type: "error",
					buttons: [false, "ปิด"],
					dangerMode: true,
				});

   		}

   }

   function saveUnder(userCode,index){
		var superVisorCode=$("#obj_userCode").val();
		//console.log(superVisorCode);
		var departmentCode=$("#obj_departmentCode").val();
		var levelEvaluate=$("#obj_evaluateLevel").val();
   		
   		var isCheck=document.getElementById("obj_chk-"+index).checked;
   		if(isCheck===true){


		   		var url="<?=$rootPath?>/tunderevaluate/isUnderExistBySuper.php?userCode="+userCode+"&supervisorCode="+superVisorCode;
		   		var data=queryData(url);
		   		var flag=data.flag;

		   		console.log(flag);
		   			
		   		if(flag===false){
				   		var url="<?=$rootPath?>/tunderevaluate/create.php";
				   		var jsonObj={
				   				supervisorCode:superVisorCode,
				   				userCode:userCode,
				   				departmentCode:departmentCode,
				   				levelEvaluate:levelEvaluate
				   		}
				   		var flag1=executeData(url,jsonObj,false);
				   		console.log(flag1);
				   		return flag1;
		   		}
   		}else{
   			//Please Carely Delete User
   			//var url="<?=$rootPath?>/tunderevaluate/deleteUser.php?userCode="+userCode+"&departmentCode="+$("#obj_departmentCode").val();
   			//var flag1=executeGet(url);
   			//return flag1;
   			var url="<?=$rootPath?>/tunderevaluate/deleteUnderBySupervisor.php?userCode="+userCode+"&supervisorCode="+superVisorCode;
   			console.log(url);
   			var flag1=executeGet(url);
   			return flag1;
   		}	
   }


   function getSupervisor(){
   		var url="<?=$rootPath?>/tsupervisorevaluate/getSupervisor.php?departmentCode="+$("#obj_departmentCode").val()+"&level="+$("#obj_evaluateLevel").val();
   		var data=queryData(url);
   		if(data.message===true){
   			$("#obj_id").val(data.id);
   			$("#obj_userCode").val(data.userCode);
   			$("#obj_depPosition").val(data.depPosition);
   			$("#obj_supervisorName").val(data.supervisorName);

   		}
   		displayUser();	
   }

   function createData(){
		var url='<?=$rootPath?>/tsupervisorevaluate/create.php';
		jsonObj={
			userCode:$("#obj_userCode").val(),
			departmentCode:$("#obj_departmentCode").val(),
			evaluateLevel:$("#obj_evaluateLevel").val(),
			depPosition:$("#obj_depPosition").val(),
			supervisorName:$("#obj_supervisorName").val()
		}
		var jsonData=JSON.stringify (jsonObj);
		//console.log(jsonData);
		var flag=executeData(url,jsonObj,false);
		return flag;
	}
	

	function updateData(){
			var url='<?=$rootPath?>/tsupervisorevaluate/update.php';
			jsonObj={
				userCode:$("#obj_userCode").val(),
				departmentCode:$("#obj_departmentCode").val(),
				evaluateLevel:$("#obj_evaluateLevel").val(),
				depPosition:$("#obj_depPosition").val(),
				supervisorName:$("#obj_supervisorName").val(),
				id:$("#obj_id").val()
			}
			var jsonData=JSON.stringify (jsonObj);
			var flag=executeData(url,jsonObj,false);
			return flag;
	}



	function readOne(id){
			var url='tsupervisorevaluate/readOne.php?id='+id;
			data=queryData(url);
			if(data!=""){
				$("#obj_userCode").val(data.userCode);
				$("#obj_departmentCode").val(data.departmentCode);
				$("#obj_evaluateLevel").val(data.evaluateLevel);
				$("#obj_depPosition").val(data.depPosition);
				$("#obj_createDate").val(data.createDate);
				$("#obj_id").val(data.id);
			}
	}

	function getId(){
		var userCode=$("#obj_userCode").val();
		var url="<?=$rootPath?>/tsupervisorevaluate/getId.php?userCode="+userCode;
	 	var data=queryData(url);
	 	return data.id;
	}

	function deleteByLevel(){
		var url="<?=$rootPath?>/tunderevaluate/deleteByLevel.php?departmentCode="+$("#departmentCode").val()+"&evaluateLevel="+$("#obj_evaluateLevel").val();
		var flag=executeGet(url);
		return flag;

	}

	function saveData(){
			
		var flag;
		flag=true;
		if(flag==true){
			deleteByLevel();
			if($("#obj_id").val()!=""){
				flag=updateData();
				displayUser();
			}else{
				flag=createData();
			 	displayUser();
		}
		if(flag==true){
			swal.fire({
			title: "การบันทึกข้อมูลเสร็จสมบูรณ์แล้ว",
			type: "success",
			buttons: [false, "ปิด"],
			dangerMode: true,
		});
		loadUser();
		}
		else{
			swal.fire({
			title: "การบันทึกข้อมูลผิดพลาด",
			type: "error",
			buttons: [false, "ปิด"],
			dangerMode: true,
		});
		}
		}else{
			swal.fire({
				title: "รูปแบบการกรอกข้อมูลไม่ถูกต้อง",
				type: "error",
				buttons: [false, "ปิด"],
				dangerMode: true,
			});
			}
	}
	function confirmDelete(id){
			swal.fire({
				title: "คุณต้องการที่จะลบข้อมูลนี้หรือไม่?",
				text: "***กรุณาตรวจสอบข้อมูลให้ครบถ้วนก่อนกดปุ่มตกลง",
				type: "warning",
				confirmButtonText: "ตกลง",
				cancelButtonText: "ยกเลิก",
				showCancelButton: true,
				showConfirmButton: true
			}).then((willDelete) => {
			if (willDelete.value) {
				url="tsupervisorevaluate/delete.php?id="+id;
				executeGet(url,false,"");
				loadUser();
			swal.fire({
				title: "ลบข้อมูลเรียบร้อยแล้ว",
				type: "success",
				buttons: "ตกลง",
			});
			} else {
				swal.fire({
				title: "ยกเลิกการทำรายการ",
				type: "error",
				buttons: [false, "ปิด"],
				dangerMode: true,
			})
			}
			});
	}
	function clearData(){
				$("#obj_userCode").val("");
				$("#obj_departmentCode").val("");
				$("#obj_evaluateLevel").val("");
				$("#obj_depPosition").val("");
				$("#obj_createDate").val("");
	}
   

   function selectAll(){
      var flag=document.getElementById('chkAll').checked;
 
	      var i=1;
	      while(document.getElementById("obj_chk-"+i) !== null){
	        document.getElementById('obj_chk-'+i).checked=flag;
	        var userCode=document.getElementById('obj_id-'+i).value;
	        saveUnder(userCode,i);
	        i++;       
	     }
    } 



	function loadUser(){
		var departmentCode=$("#obj_departmentCode").val();
		var keyWord=$("#obj_keyWord").val();
		var url	="<?=$rootPath?>/tstaffmigrate/displayDataJSON.php?departmentCode="+departmentCode+"&keyWord="+keyWord+"&supervisorCode="+$("#obj_userCode").val();
		$("#tblDisplay").load(url);
	}

	function filterStaff(){
		var departmentCode=$("#obj_departmentFilter").val();
		var keyWord=$("#obj_keyWord").val();
		var url	="<?=$rootPath?>/tstaffmigrate/displayDataJSON.php?departmentCode="+departmentCode+"&keyWord="+keyWord+"&supervisorCode="+$("#obj_userCode").val();
		$("#tblDisplay").load(url);

	}



	function listDepartment(){
		var url="<?=$rootPath?>/tdepartment/getHierachyData.php";
		setDDLPrefix(url,"#obj_departmentCode","***เลือกหน่วยงาน***");
		setDDLPrefix(url,"#obj_departmentFilter","***เลือกหน่วยงาน***");

	}

	function getHasUnder(departmentCode,levelEvaluate){
		var url="<?=$rootPath?>/tunderevaluate/getHasUnder.php?departmentCode="+departmentCode+"&levelEvaluate="+levelEvaluate;
		var data=queryData(url);
		return data.flag;

	}


	function getHasSupervisor(){
		var url="<?=$rootPath?>/tsupervisorevaluate/getHasSupervisor.php?departmentCode="+$("#obj_departmentCode").val()+"&level="+$("#obj_evaluateLevel").val();
		var data=queryData(url);
		return data.flag;
	}

	function displayUser(){
		var flag= getHasSupervisor();
		if(flag===true){
			$("#dvDelButton").attr('style','display:block');
			$("#dvSearchButton").attr('style','display:none');
			$("#dvUnder").attr('style','display:block');
		}else
		{
			$("#dvDelButton").attr('style','display:none');
			$("#dvSearchButton").attr('style','display:block');
			$("#dvUnder").attr('style','display:none');
		}
	}


	function chooseSupervisor(userCode,staffFullName){
		$("#obj_userCode").val(userCode);
		$("#obj_supervisorName").val(staffFullName);
		$("#modal-searchPanel").modal("hide");
		getSupervisor();
	}

	
	$(document).ready(function(){
		listDepartment();
		displayUser();

		$("#obj_departmentFilter").val($("#obj_departmentCode").val());

		$("#obj_keyWord").change(function(){
			filterStaff();
		});

		$("#obj_departmentFilter").change(function(){
			filterStaff();
		});
			
		


		$("#chkAll").click(function(){
			selectAll();
		});

		$("#btnSave").click(function(){
			saveData();
		});

		$("#obj_evaluateLevel").change(function(){
			getSupervisor();
			loadUser();
		});

		$("#obj_departmentCode").change(function(){
			
			$("#obj_userCode").val("");
			$("#obj_supervisorName").val("");
			$("#obj_departmentFilter").val($("#obj_departmentCode").val());

			getSupervisor();
			loadUser();
		});

		$("#btnDel").click(function(){
			deleteSupervisor();
		});

		$("#btnSearch").click(function(){
			var url="<?=$rootPath?>/tsupervisorevaluate/searchPanel.php";
			$("#dvSearch").load(url);
			$("#modal-searchPanel").modal("toggle");

		});

	})

</script>
