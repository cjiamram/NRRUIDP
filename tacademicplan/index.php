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
      $departmentId=$departmentId=='ALL'?0:$departmentId;
      $topic= $objLbl->getLabel("t_academicplan","topic","th");


?>
<input type='hidden' id='obj_userCode' value="<?=$userCode?>">

<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<script src="<?=$rootPath?>/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=$rootPath?>/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<input type="hidden" id="obj_id" value="">
<section class="content-header">
     <h1>
        <b>ระบบพัฒนาตนเอง</b>

        <small>>><?= $topic?>:</small>
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
      <h3 class="box-title"><b><?= $topic?></b></h3>
      </div>
      <table id="tblDisplay" class="table table-bordered table-hover">
      </table>
      </div>  
      </div>
        
    </section>


   <div class="modal fade" id="modal-input">
     <div class="modal-dialog" id="dvInput" style="width:800px" >
      <div class="modal-content">
          <div class="box-header with-border">
                <button type="button" class="close"  aria-label="Close">
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
     <div class="modal-dialog"  style="width:800px" >
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
<script src="<?=$rootPath?>/tacademicplan/jsExecute.js"></script>
<script>

 function loadInput(){
      var url="<?=$rootPath?>/tacademicplan/input.php";
      $("#dvInputBody").load(url);

      var url="<?=$rootPath?>/tacademicplan/view.php";
      $("#dvViewBody").load(url);
 }

function loadStatus(id){
      var url="<?=$rootPath?>/tacademicplan/inputStatus.php";
      $("#dvStatusInput").load(url);
      $("#obj_id").val(id);
      $("#modal-status").modal("toggle");

}


function displayData(){
 
    var url="<?=$rootPath?>/tacademicplan/displayData.php?userCode="+$("#obj_userCode").val();
    $("#tblDisplay").load(url);
 }

 function loadPage(){
    loadInput();
    displayData();
 }

 function readOne(id){
    $("#modal-input").modal("toggle");
    var url='tacademicplan/readOne.php?id='+id;
    data=queryData(url);
    if(data!=""){
      setYearPlan();
      $("#obj_userCode").val(data.userCode);
      $("#obj_educationPlan").val(data.educationPlan);
      $("#obj_degree").val(data.degree);
      $("#obj_eduCertificate").val(data.eduCertificate);
      $("#obj_budget").val(data.budget);
      $("#obj_yearPlan").val(data.yearPlan);
      $("#obj_fundSource").val(data.fundSource);
      $("#obj_duration").val(data.duration);
     
      switch(data.sourceType){
        case "01":
            $("#obj_sourceType_1").attr("checked",true);
            break;
        case "02":
            $("#obj_sourceType_2").attr("checked",true);
            break;
      }
      $("#obj_university").val(data.university);
      $("#obj_description").val(data.description);

      switch(data.placeType){
        case "01":
            $("#obj_placeType_1").attr("checked",true);
            break;
        case "02":
            $("#obj_placeType_2").attr("checked",true);
            break;
      }
      $("#obj_id").val(data.id);
    }
}

function getmessage(requestId,pType){
  var url="<?=$rootPath?>/taproverequest/getMessage.php?requestId="+requestId+"&pType="+pType;
  //console.log(url);
  var data=queryData(url);
  return data.messageAprove;
}


function readOneView(id){
    $("#modal-view").modal("toggle");
    var url='tacademicplan/readOne.php?id='+id;
    data=queryData(url);
    if(data!=""){
      setYearPlan();
      $("#obj_userCodeView").val(data.userCode);
      $("#obj_educationPlanView").val(data.educationPlan);
      $("#obj_degreeView").val(data.degree);
      $("#obj_eduCertificateView").val(data.eduCertificate);
      $("#obj_budgetView").val(data.budget);
      $("#obj_yearPlanView").val(data.yearPlan);
      $("#obj_fundSourceView").val(data.fundSource);
      $("#obj_durationView").val(data.duration);
     
      switch(data.sourceType){
        case "01":
            $("#obj_sourceType_1View").attr("checked",true);
            break;
        case "02":
            $("#obj_sourceType_2View").attr("checked",true);
            break;
      }
      $("#obj_universityView").val(data.university);
      $("#obj_descriptionView").val(data.description);

      switch(data.placeType){
        case "01":
            $("#obj_placeType_1View").attr("checked",true);
            break;
        case "02":
            $("#obj_placeType_2View").attr("checked",true);
            break;
      }

      var messageAprove= getmessage(id,1);
      $("#obj_commentView").val(messageAprove);
    }
}

 function setSelfAction(){
    var url='tacademicplan/setSelfAction.php';
     //$data->id,$data->status,$message
     jsonObj={
      id:$("#obj_id").val(),
      status:$('input[name="obj_status"]:checked').val(),
      message:$("#obj_message").val()
     }
    var jsonData=JSON.stringify (jsonObj);
    //console.log(jsonData);
    var flag=executeData(url,jsonObj,false);
    return flag;
 }

 function createData(){
    var url='tacademicplan/create.php';
    jsonObj={
      userCode:$("#obj_userCode").val(),
      educationPlan:$("#obj_educationPlan").val(),
      degree:$("#obj_degree").val(),
      eduCertificate:$("#obj_eduCertificate").val(),
      budget:$("#obj_budget").val(),
      yearPlan:$("#obj_yearPlan").val(),
      fundSource:$("#obj_fundSource").val(),
      sourceType:$('input[name="obj_sourceType"]:checked').val(),
      university:$("#obj_university").val(),
      description:$("#obj_description").val(),
      placeType:$('input[name="obj_placeType"]:checked').val(),
      eduType:$('input[name="obj_eduType"]:checked').val(),
      duration:$("#obj_duration").val(),
      departmentId:<?=$departmentId?>
    }
    var jsonData=JSON.stringify (jsonObj);
    //console.log(jsonData);
    var flag=executeData(url,jsonObj,false);
    return flag;
}


function updateData(){
    var url='tacademicplan/update.php';
    jsonObj={
      userCode:$("#obj_userCode").val(),
      educationPlan:$("#obj_educationPlan").val(),
      degree:$("#obj_degree").val(),
      eduCertificate:$("#obj_eduCertificate").val(),
      budget:$("#obj_budget").val(),
      yearPlan:$("#obj_yearPlan").val(),
      fundSource:$("#obj_fundSource").val(),
      sourceType:$('input[name="obj_sourceType"]:checked').val(),
      university:$("#obj_university").val(),
      description:$("#obj_description").val(),
      placeType:$('input[name="obj_placeType"]:checked').val(),
      eduType:$('input[name="obj_eduType"]:checked').val(),
      duration:$("#obj_duration").val(),
      departmentId:<?=$departmentId?>,
      id:$("#obj_id").val()
    }
    var jsonData=JSON.stringify (jsonObj);
    var flag=executeData(url,jsonObj,false);
    return flag;
}


function clearData(){
      $("#obj_educationPlan").val("");
      $("#obj_degree").val("");
      $("#obj_eduCertificate").val("");
      $("#obj_budget").val(0);
      $("#obj_fundSource").val("");
      $("#obj_sourceType_1").attr("checked",true);
      $("#obj_university").val("");
      $("#obj_description").val("");
      $("#obj_placeType_1").attr("checked",true);
      setYearPlan();

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

 function setYearPlan(){
    const d = new Date();
    let year = d.getFullYear()+543;
    setDDLRange("#obj_yearPlan",year,year+20);
    $("#obj_yearPlan").val(year);
 }

 $( document ).ready(function() {
    loadPage();
    setYearPlan();
    $("#btnInput").click(function(){
        clearData();
        $("#obj_code").val(genCode());
    });

    $("#txtSearch").change(function(){
        displayData();
    });

    $("#btnSave").click(function(){
        saveData();
    });

    $("#btnInput").click(function(){
      $("#modal-input").modal("toggle");
      clearData();
    });

    $("#btnStatusSave").click(function(){
      setSelfAction();
      displayData();
      $("#modal-input").modal("hide");
    });

    $("#btnStatusClose").click(function(){
      $("#modal-input").modal("hide");
    });


    $("#btnSave").click(function(){
      $("#modal-input").modal("hide");
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
