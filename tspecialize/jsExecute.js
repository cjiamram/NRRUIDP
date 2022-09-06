var regDec = /^\d+(\.\d{1,2})?$/;
var regEmail=/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/g;
var regTel=/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$/g;
var regDate=/(0[1-9]|1[012])[- \/.](0[1-9]|[12][0-9]|3[01])[- \/.](19|20)\d\d/;
function validInput(){
		var flag=true;
		flag=regDec.test($("#obj_levelNo").val());
		if (flag==false){
			$("#obj_levelNo").focus();
			return flag;
}
		flag=regDec.test($("#obj_orderNo").val());
		if (flag==false){
			$("#obj_orderNo").focus();
			return flag;
}
		flag=regDec.test($("#obj_groupType").val());
		if (flag==false){
			$("#obj_groupType").focus();
			return flag;
}
		return flag;
}
function displayData(){
		var url="tspecialize/displayData.php?tableName=t_specialize&dbName=dbimprovement&keyWord="+$("#txtSearch").val();
		$("#tblDisplay").load(url);
}
function createData(){
		var url='tspecialize/create.php';
		jsonObj={
			code:$("#obj_code").val(),
			specialize:$("#obj_specialize").val(),
			parent:$("#obj_parent").val(),
			levelNo:$("#obj_levelNo").val(),
			orderNo:$("#obj_orderNo").val(),
			enable:$("#obj_enable").val(),
			groupType:$("#obj_groupType").val()
		}
		var jsonData=JSON.stringify (jsonObj);
		var flag=executeData(url,jsonObj,false);
		return flag;
}
function updateData(){
		var url='tspecialize/update.php';
		jsonObj={
			code:$("#obj_code").val(),
			specialize:$("#obj_specialize").val(),
			parent:$("#obj_parent").val(),
			levelNo:$("#obj_levelNo").val(),
			orderNo:$("#obj_orderNo").val(),
			enable:$("#obj_enable").val(),
			groupType:$("#obj_groupType").val(),
			id:$("#obj_id").val()
		}
		var jsonData=JSON.stringify (jsonObj);
		var flag=executeData(url,jsonObj,false);
		return flag;
}
function readOne(id){
		var url='tspecialize/readOne.php?id='+id;
		data=queryData(url);
		if(data!=""){
			$("#obj_code").val(data.code);
			$("#obj_specialize").val(data.specialize);
			$("#obj_parent").val(data.parent);
			$("#obj_levelNo").val(data.levelNo);
			$("#obj_orderNo").val(data.orderNo);
			$("#obj_enable").val(data.enable);
			$("#obj_groupType").val(data.groupType);
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
			url="tspecialize/delete.php?id="+id;
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
			$("#obj_code").val("");
			$("#obj_specialize").val("");
			$("#obj_parent").val("");
			$("#obj_levelNo").val("");
			$("#obj_orderNo").val("");
			$("#obj_enable").val("");
			$("#obj_groupType").val("");
}
function genCode(){
		//var url="genCode.php";
		//var data=queryData(url);
		//return data.code;
}
