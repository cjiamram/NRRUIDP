<?php
      session_start();
      include_once '../config/database.php';
      include_once '../config/config.php';
      include_once '../objects/classLabel.php';
      $cnf=new Config();
      $rootPath=$cnf->path;
      $database = new Database();
      $db = $database->getConnection();
      $objLbl=new ClassLabel($db);
      $userCode=isset($_SESSION["UserName"])?$_SESSION["UserName"]:"";
      $departmentId=isset($_SESSION["DepartmentId"])?$_SESSION["DepartmentId"]:"";
      $topic= $objLbl->getLabel("t_research","topic","th");


?>
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<script src="<?=$rootPath?>/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=$rootPath?>/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<input type="hidden" id="obj_id" value="">
<input type="hidden" id="obj_userCode" value="<?=$userCode?>">
<section class="content-header">
      <h1>
        <b>ระบบพัฒนาตนเอง</b>
        <small>>><?= $topic?>:</small>
      </h1>
      <ol class="breadcrumb">
        <input type="button" id="btnInput" class="btn btn-primary col-sm-12"  value="สร้าง">
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box"></div>
        

      <div>&nbsp;</div>
      <div class="col-sm-12">
      <div class="box box-warning">
      <div class="box-header with-border">
      <h3 class="box-title"><b><?= $topic?></b></h3>
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
                <h4 class="modal-title"><?= $topic?></h4>
           </div>
           <div class="modal-body" id="dvInputBody">
           </div>
          <div>
                 <div class="modal-footer">
                    <input type="button" id="btnClose" value="ปิด"  class="btn btn-default pull-left" >
                    <input type="button" id="btnSave" value="บันทึก"  class="btn btn-primary" >
                  </div>
          </div>
      </div>
     </div>
   </div>


   <div class="modal fade" id="modal-view">
     <div class="modal-dialog"  >
      <div class="modal-content">
          <div class="box-header with-border">
                <button type="button" class="close"  aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?= $topic?></h4>
           </div>
           <div class="modal-body" id="dvViewBody">
           </div>
       
      </div>
     </div>
   </div>

     <div class="modal fade" id="modal-status">
        <div class="modal-dialog" >
           <div class="modal-content">
            <div class="box-header with-border">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">บันทึกสถานะแผนการ</h4>
           </div>
           <div class="modal-body" id="dvStatusInput">
           
           </div>
          <div>
                 <div class="modal-footer">
                    <input type="button" id="btnStatusClose" value="ปิด"  class="btn btn-default pull-left" data-dismiss="modal">
                    <input type="button" id="btnStatusSave" value="บันทึก"  class="btn btn-primary" data-dismiss="modal">
                  </div>
           </div>
        </div>
     </div>
   </div>
<script src="<?=$rootPath?>/tresearch/jsExecute.js"></script>
<script>

 function loadInput(){
      var url="<?=$rootPath?>/tresearch/input.php";
      $("#dvInputBody").load(url);

      url="<?=$rootPath?>/tresearch/view.php";
      $("#dvViewBody").load(url);
 }

 function loadStatus(id){
      var url="<?=$rootPath?>/tresearch/inputStatus.php";
      $("#dvStatusInput").load(url);
      $("#obj_id").val(id);
      $("#modal-status").modal("toggle");

}


 function setSelfAction(){
    var url='tresearch/setSelfAction.php';
     jsonObj={
      id:$("#obj_id").val(),
      status:$('input[name="obj_status"]:checked').val(),
      message:$("#obj_message").val()
     }
    var jsonData=JSON.stringify (jsonObj);
    var flag=executeData(url,jsonObj,false);
    return flag;
 }


function displayData(){
    var url="<?=$rootPath?>/tresearch/displayDataJSON.php?userCode=<?=$userCode?>";
    $("#tblDisplay").load(url);

 }

 function loadPage(){
    loadInput();
    displayData();
 }

 function createData(){
    var url='tresearch/create.php';
    jsonObj={
      userCode:$("#obj_userCode").val(),
      research:$("#obj_research").val(),
      detail:$("#obj_detail").val(),
      yearPlan:$("#obj_yearPlan").val(),
      budget:$("#obj_budget").val(),
      budgetType:$('input[name="obj_budgetType"]:checked').val(),
      researchSource:$("#obj_researchSource").val(),
      departmentId:<?=$departmentId?>
    }
    var jsonData=JSON.stringify (jsonObj);
    console.log(jsonData);
    var flag=executeData(url,jsonObj,false);
    return flag;
}
function updateData(){
    var url='tresearch/update.php';
    jsonObj={
      userCode:$("#obj_userCode").val(),
      research:$("#obj_research").val(),
      detail:$("#obj_detail").val(),
      yearPlan:$("#obj_yearPlan").val(),
      budget:$("#obj_budget").val(),
      budgetType:$('input[name="obj_budgetType"]:checked').val(),
      researchSource:$("#obj_researchSource").val(),
      departmentId:<?=$departmentId?>,
      id:$("#obj_id").val()
    }
    var jsonData=JSON.stringify (jsonObj);
    console.log(jsonData);

    var flag=executeData(url,jsonObj,false);
    return flag;
}
function readOne(id){
    $("#modal-input").modal("toggle");
    var url='tresearch/readOne.php?id='+id;
    data=queryData(url);
    if(data!=""){
      $("#obj_research").val(data.research);
      $("#obj_detail").val(data.detail);
      $("#obj_yearPlan").val(data.yearPlan);
      $("#obj_budget").val(data.budget);
       switch(data.budgetType){
        case "01":
            $("#obj_budgetType_1").attr("checked",true);
            break;
        case "02":
            $("#obj_budgetType_2").attr("checked",true);
            break;
      }
      $("#obj_researchSource").val(data.researchSource);
      $("#obj_id").val(data.id);
    }
}

function getmessage(requestId,pType){
  var url="<?=$rootPath?>/taproverequest/getMessage.php?requestId="+requestId+"&pType="+pType;
  var data=queryData(url);
  return data.messageAprove;
}

function readOneView(id){
    $("#modal-view").modal("toggle");
    var url='tresearch/readOne.php?id='+id;
    data=queryData(url);
    if(data!=""){
      $("#obj_researchView").val(data.research);
      $("#obj_detailView").val(data.detail);
      $("#obj_yearPlanView").val(data.yearPlan);
      $("#obj_budgetView").val(data.budget);
       switch(data.budgetType){
        case "01":
            $("#obj_budgetType_1View").attr("checked",true);
            break;
        case "02":
            $("#obj_budgetType_2View").attr("checked",true);
            break;
      }
      $("#obj_researchSourceView").val(data.researchSource);
      var messageAprove= getmessage(id,2);
      $("#obj_commentView").val(messageAprove);
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

 $( document ).ready(function() {
    loadPage();
    $("#btnInput").click(function(){
        $("#modal-input").modal("toggle");
        clearData();
        $("#obj_code").val(genCode());
    });

    $("#txtSearch").change(function(){
        displayData();
    });

    $("#btnSave").click(function(){
        saveData();
        $("#modal-input").modal("hide");
    });

    $("#btnStatusSave").click(function(){
       setSelfAction();
       displayData();
       $("#modal-status").modal("hide");
    });

    $("#btnStatusClose").click(function(){
      $("#modal-status").modal("hide");
    });

    $("#btnClose").click(function(){
        $("#modal-input").modal("hide");
    });

    $(".close").click(function(){
        $("#modal-input").modal("hide");
        $("#modal-status").modal("hide");
        $("#modal-view").modal("hide");
    });
 });

</script>
