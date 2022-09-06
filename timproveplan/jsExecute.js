var full = location.pathname;
var res = full.split('/');
var projectPath='/'+res[1];
var regDec = /^\d+(\.\d{1,2})?$/;
var regEmail=/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/g;
var regTel=/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$/g;
var regDate=/(0[1-9]|1[012])[- \/.](0[1-9]|[12][0-9]|3[01])[- \/.](19|20)\d\d/;
function validInput(){
		var flag=true;
		flag=regDec.test($("#obj_improvementType").val());
		if (flag==false){
			$("#obj_improvementType").focus();
			return flag;
}
		flag=regDec.test($("#obj_budget").val());
		if (flag==false){
			$("#obj_budget").focus();
			return flag;
}
		flag=regDec.test($("#obj_sourceType").val());
		if (flag==false){
			$("#obj_sourceType").focus();
			return flag;
}
		flag=regDec.test($("#obj_duration").val());
		if (flag==false){
			$("#obj_duration").focus();
			return flag;
}
		return flag;
}
function displayData(){
		var url="timproveplan/displayData.php?tableName=t_improveplan&dbName=dbimprovement&keyWord="+$("#txtSearch").val();
		$("#tblDisplay").load(url);
}
function createData(){
		var url='timproveplan/create.php';
		jsonObj={
			staffCode:$("#obj_staffCode").val(),
			topic:$("#obj_topic").val(),
			improvementType:$("#obj_improvementType").val(),
			yearPlan:$("#obj_yearPlan").val(),
			description:$("#obj_description").val(),
			academicYear:$("#obj_academicYear").val(),
			budget:$("#obj_budget").val(),
			sourceDepartment:$("#obj_sourceDepartment").val(),
			sourceType:$("#obj_sourceType").val(),
			duration:$("#obj_duration").val(),
			monthPlan:$("#obj_monthPlan").val()
		}
		var jsonData=JSON.stringify (jsonObj);
		var flag=executeData(url,jsonObj,false);
		return flag;
}
function updateData(){
		var url='timproveplan/update.php';
		jsonObj={
			staffCode:$("#obj_staffCode").val(),
			topic:$("#obj_topic").val(),
			improvementType:$("#obj_improvementType").val(),
			yearPlan:$("#obj_yearPlan").val(),
			description:$("#obj_description").val(),
			academicYear:$("#obj_academicYear").val(),
			budget:$("#obj_budget").val(),
			sourceDepartment:$("#obj_sourceDepartment").val(),
			sourceType:$("#obj_sourceType").val(),
			duration:$("#obj_duration").val(),
			monthPlan:$("#obj_monthPlan").val(),
			id:$("#obj_id").val()
		}
		var jsonData=JSON.stringify (jsonObj);
		var flag=executeData(url,jsonObj,false);
		return flag;
}
function readOne(id){
		var url='timproveplan/readOne.php?id='+id;
		data=queryData(url);
		if(data!=""){
			$("#obj_staffCode").val(data.staffCode);
			$("#obj_topic").val(data.topic);
			$("#obj_improvementType").val(data.improvementType);
			$("#obj_yearPlan").val(data.yearPlan);
			$("#obj_description").val(data.description);
			$("#obj_academicYear").val(data.academicYear);
			$("#obj_budget").val(data.budget);
			$("#obj_sourceDepartment").val(data.sourceDepartment);
			$("#obj_sourceType").val(data.sourceType);
			$("#obj_duration").val(data.duration);
			$("#obj_monthPlan").val(data.monthPlan);
			$("#obj_id").val(data.id);
		}
}
function saveData(){
		var flag;
		flag=validInput();
		if(flag==true){
					if($("#obj_id").val()!=""){
			flag=updateData();
			}else{
			flag=createData();
		}
		if(flag==true){
			swal.fire({
			title: "การบันทึกข้อมูลเสร็จสมบูรณ์แล้ว",
			type: "success",
			buttons: [false, "ปิด"],
			dangerMode: true,
		});
		displayData();
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
			url="timproveplan/delete.php?id="+id;
			executeGet(url,false,"");
			displayData();
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
			$("#obj_staffCode").val("");
			$("#obj_topic").val("");
			$("#obj_improvementType").val("");
			$("#obj_yearPlan").val("");
			$("#obj_description").val("");
			$("#obj_academicYear").val("");
			$("#obj_budget").val("");
			$("#obj_sourceDepartment").val("");
			$("#obj_sourceType").val("");
			$("#obj_duration").val("");
			$("#obj_monthPlan").val("");
}
function genCode(){
		//var url="genCode.php";
		//var data=queryData(url);
		//return data.code;
}
