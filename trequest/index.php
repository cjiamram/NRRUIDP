<?php
      include_once '../config/database.php';
      include_once '../config/config.php';
      include_once '../objects/classLabel.php';
      session_start();
      $cnf=new Config();
      $rootPath=$cnf->path;
      $database = new Database();
      $db = $database->getConnection();
      $objLbl=new ClassLabel($db);

      function mb_basename($path) {
            if (preg_match('@^.*[\\\\/]([^\\\\/]+)([\\\\/]+)?$@s', $path, $matches)) {
                return $matches[1];
            } else if (preg_match('@^([^\\\\/]+)([\\\\/]+)?$@s', $path, $matches)) {
                return $matches[1];
            }
            return '';
      }
      $dir= getcwd();

      $lastPath=mb_basename($dir);

?>
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<script src="<?=$rootPath?>/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=$rootPath?>/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>


<input type="hidden" id="obj_id" value="">
<section class="content-header">
     <h1>
       <b>ระบบพัฒนาตนเอง</b>

        <small>>>การขออนุมัติผลงาน</small>
      </h1>
      <ol class="breadcrumb">
   
        <input type="button" id="btnInput"   class="btn btn-primary pull-right"  value="สร้าง">


      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box"></div>
      

      <div>&nbsp;</div>
      <div class="col-sm-12">
      <div class="box box-warning">
      <div class="box-header with-border">
      <h3 class="box-title"><b>การขออนุมัติผลงาน</b></h3>
      </div>
      <table id="tblDisplay" class="table table-bordered table-hover">
      </table>
      </div>  
      </div>
        
    </section>


   <div class="modal fade" id="modal-input">
     <div class="modal-dialog" id="dvInput" >
      <div class="modal-content">
          <div class="box-header with-border">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">การขออนุมัติผลงาน</h4>
           </div>
           <div class="modal-body" id="dvInputBody">
           
           </div>
          <div>
                 <div class="modal-footer">
                    <input type="button" id="btnClose" value="ปิด"  class="btn btn-default pull-left" >
                    
                    <a href='#' id="btnSave" class="btn btn-primary">บันทึก</a>
                  </div>
          </div>
      </div>
     </div>
   </div>

     <div class="modal fade" id="modal-search">
        <div class="modal-dialog" id="dvSearch">
           <div class="modal-content">
            <div class="box-header with-border">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Advance Search</h4>
           </div>
           <div class="modal-body" id="dvAdvBody">
           
           </div>
          <div>
                 <div class="modal-footer">
                    <input type="button" id="btnAdvClose" value="ปิด"  class="btn btn-default pull-left" data-dismiss="modal">
                    <input type="button" id="btnAdvSearch" value="ค้นหา"  class="btn btn-primary" data-dismiss="modal">
                  </div>
           </div>
        </div>
     </div>
   </div>
<script src="<?=$rootPath.'/'.$lastPath?>/jsExecute.js"></script>
<script>

 
 function createData(){
    var url='trequest/create.php';
    jsonObj={
      userCode:$("#obj_userCode").val(),
      fullName:$("#obj_fullName").val(),
      description:$("#obj_description").val(),
      createDate:$("#obj_createDate").val(),
      requestType:$("#obj_requestType").val()
    }
    var jsonData=JSON.stringify (jsonObj);
    var flag=executeData(url,jsonObj,false);
    return flag;
}
function updateData(){
    var url='trequest/update.php';
    jsonObj={
      userCode:$("#obj_userCode").val(),
      fullName:$("#obj_fullName").val(),
      description:$("#obj_description").val(),
      createDate:$("#obj_createDate").val(),
      requestType:$("#obj_requestType").val(),
      id:$("#obj_id").val()
    }
    var jsonData=JSON.stringify (jsonObj);
    var flag=executeData(url,jsonObj,false);
    return flag;
}
function readOne(id){
    
    $("#modal-input").modal("toggle");
    var url='<?=$rootPath?>/trequest/readOne.php?id='+id;
    //console.log(url);
    data=queryData(url);
    if(data!=""){
      $("#obj_userCode").val(data.userCode);
      $("#obj_fullName").val(data.fullName);
      $("#obj_description").val(data.description);
      $("#obj_createDate").val(data.createDate);
      $("#obj_progressStatus").val(data.progressStatus);
      $("#obj_requestType").val(data.requestType);
      $("#obj_id").val(data.id);
    }
}
function saveData(){
    var flag;
    flag=true;
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
      url="trequest/delete.php?id="+id;
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
      $("#obj_userCode").val("");
      $("#obj_fullName").val("");
      $("#obj_description").val("");
      $("#obj_createDate").val("");
      $("#obj_progressStatus").val("");
      $("#obj_requestType").val("");
}

 function loadInput(){
      var url="<?=$rootPath.'/'.$lastPath?>/input.php";
      $("#dvInputBody").load(url);
 }

function displayData(){

    var url="<?=$rootPath.'/'.$lastPath?>/displayData.php";
    console.log(url);
    $("#tblDisplay").load(url);
 }

 function loadPage(){
    loadInput();
    displayData();
 }

 $( document ).ready(function() {
    loadPage();
    $("#btnInput").click(function(){
        clearData();
        $("#obj_code").val(genCode());
    });

    $("#txtSearch").change(function(){
        displayData();
    });

    $("#btnSave").click(function(){
            $("#modal-input").modal("hide");

       saveData();
      
        
    });

    $("#btnClose").click(function(){
         $("#modal-input").modal("hide");
    });

    $(".close").click(function(){
         $("#modal-input").modal("hide");
    });

    $("#btnInput").click(function(){
      loadInput();
      $("#modal-input").modal("toggle");

    });
 });

</script>
