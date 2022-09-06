var full = location.pathname;
var res = full.split('/');
var projectPath='/'+res[1];
var regDec = /^\d+(\.\d{1,2})?$/;
var regEmail=/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/g;
var regTel=/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$/g;
var regDate=/(0[1-9]|1[012])[- \/.](0[1-9]|[12][0-9]|3[01])[- \/.](19|20)\d\d/;
function validInput(){
		var flag=true;
		flag=regDec.test($("#obj_budget").val());
		if (flag==false){
			$("#obj_budget").focus();
			return flag;
}
		flag=regDec.test($("#obj_joinGroup").val());
		if (flag==false){
			$("#obj_joinGroup").focus();
			return flag;
}
		flag=regDate.test($("#obj_createDate").val());
		if (flag==false){
				$("#obj_createDate").focus();
				return flag;
		}
		flag=regDec.test($("#obj_duration").val());
		if (flag==false){
			$("#obj_duration").focus();
			return flag;
}
		return flag;
}
/*function displayData(){
		var url="tvisit/displayData.php?tableName=t_visit&dbName=dbimprovement&keyWord="+$("#txtSearch").val();
		$("#tblDisplay").load(url);
}*/

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
			url="tvisit/delete.php?id="+id;
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
			$("#obj_visitObjective").val("");
			$("#obj_projectDetail").val("");
			$("#obj_expectation").val("");
			$("#obj_budget").val(0);
			$("#obj_joinGroup").val(1);
			//$("#obj_yearPlan").val("");
			$("#obj_createDate").val("");
			$("#obj_duration").val(1);
			//$("#obj_monthPlan").val("");
			//$("#obj_fileAttach").val("");
			//$("#obj_isAprove").val("");
}
function genCode(){
		//var url="genCode.php";
		//var data=queryData(url);
		//return data.code;
}
