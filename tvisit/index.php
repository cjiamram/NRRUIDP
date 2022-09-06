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
      $topic= $objLbl->getLabel("t_visit","topic","th");


?>
<input type="hidden" id="obj_userCode" value="<?=$userCode?>" >
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<script src="<?=$rootPath?>/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=$rootPath?>/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<input type="hidden" id="obj_id" value="">
<section class="content-header">
     <h1>
         <b>ระบบพัฒนาตนเอง</b>

        <small>>><?=$topic?>:</small>
      </h1>
      <ol class="breadcrumb">
   
        <input type="button" id="btnInput"   class="btn btn-primary col-sm-12" data-toggle="modal" data-target="#modal-input" value="สร้าง">


      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box"></div>
        

      <div>&nbsp;</div>
      <div class="col-sm-12">
      <div class="box box-warning">
      <div class="box-header with-border">
      <h3 class="box-title"><b><?=$topic?></b></h3>
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
                <h4 class="modal-title"><?=$topic?></h4>
           </div>
           <div class="modal-body" id="dvInputBody">
           
           </div>
          <div>
                 <div class="modal-footer">
                    <input type="button" id="btnClose" value="ปิด"  class="btn btn-default pull-left" data-dismiss="modal">
                    <input type="button" id="btnSave" value="บันทึก"  class="btn btn-primary" data-dismiss="modal">
                  </div>
          </div>
      </div>
     </div>
   </div>

   <div class="modal fade" id="modal-view">
     <div class="modal-dialog" >
      <div class="modal-content">
          <div class="box-header with-border">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?=$topic?></h4>
           </div>
           <div class="modal-body" id="dvViewBody">
           
           </div>
      </div>
     </div>
   </div>

     <div class="modal fade" id="modal-status">
        <div class="modal-dialog">
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
<script src="<?=$rootPath?>/tvisit/jsExecute.js"></script>
<script>

var monthArray = ["มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤษจิกายน","ธันวาคม"];


 function loadInput(){
      var url="<?=$rootPath?>/tvisit/input.php";
      $("#dvInputBody").load(url);
       var url="<?=$rootPath?>/tvisit/view.php";
      $("#dvViewBody").load(url);
 }

function loadStatus(id){
      var url="<?=$rootPath?>/tupposition/inputStatus.php";
      $("#dvStatusInput").load(url);
      $("#obj_id").val(id);
      $("#modal-status").modal("toggle");

}


function createData(){
    var url='tvisit/create.php';
    jsonObj={
      userCode:$("#obj_userCode").val(),
      visitObjective:$("#obj_visitObjective").val(),
      projectDetail:$("#obj_projectDetail").val(),
      expectation:$("#obj_expectation").val(),
      budget:$("#obj_budget").val(),
      joinGroup:$("#obj_joinGroup").val(),
      yearPlan:$("#obj_yearPlan").val(),
      duration:$("#obj_duration").val(),
      monthPlan:$("#obj_monthPlan").val(),
      visitSite:$('input[name="obj_visitSite"]:checked').val(),
      departmentId:<?=$departmentId?>
    }
    var jsonData=JSON.stringify (jsonObj);
    //console.log(jsonData);
    var flag=executeData(url,jsonObj,false);
    return flag;
}
function updateData(){
    var url='tvisit/update.php';
    jsonObj={
      userCode:$("#obj_userCode").val(),
      visitObjective:$("#obj_visitObjective").val(),
      projectDetail:$("#obj_projectDetail").val(),
      expectation:$("#obj_expectation").val(),
      budget:$("#obj_budget").val(),
      joinGroup:$("#obj_joinGroup").val(),
      yearPlan:$("#obj_yearPlan").val(),
      duration:$("#obj_duration").val(),
      monthPlan:$("#obj_monthPlan").val(),
      visitSite:$('input[name="obj_visitSite"]:checked').val(),
      departmentId:<?=$departmentId?>,
      id:$("#obj_id").val()
    }
    var jsonData=JSON.stringify (jsonObj);
    var flag=executeData(url,jsonObj,false);
    return flag;
}
function readOne(id){
    $("#modal-input").modal("toggle");
    var url='tvisit/readOne.php?id='+id;
    data=queryData(url);
    if(data!=""){
      $("#obj_visitObjective").val(data.visitObjective);
      $("#obj_projectDetail").val(data.projectDetail);
      $("#obj_expectation").val(data.expectation);
      $("#obj_budget").val(data.budget);
      $("#obj_joinGroup").val(data.joinGroup);
      $("#obj_yearPlan").val(data.yearPlan);
      $("#obj_duration").val(data.duration);
      $("#obj_monthPlan").val(data.monthPlan);

      switch(data.visitSite) {
          case "01":
              $("#obj_visitSite_1").attr("checked",true);
              break;
          case "02":
              $("#obj_visitSite_2").attr("checked",true);
              break;
      }
      $("#obj_id").val(data.id);
    }
}

function getmessage(requestId,pType){
  var url="<?=$rootPath?>/taproverequest/getMessage.php?requestId="+requestId+"&pType="+pType;
  var data=queryData(url);
  return data.messageAprove;
}

function readView(id){
    $("#modal-view").modal("toggle");
    var url='tvisit/readOne.php?id='+id;
    data=queryData(url);
    if(data!=""){
      $("#obj_visitObjectiveView").val(data.visitObjective);
      $("#obj_projectDetailView").val(data.projectDetail);
      $("#obj_expectationView").val(data.expectation);
      $("#obj_budgetView").val(data.budget);
      $("#obj_joinGroupView").val(data.joinGroup);
      $("#obj_yearPlanView").val(data.yearPlan);
      $("#obj_durationView").val(data.duration);
      $("#obj_monthPlanView").val(data.monthPlan);

      switch(data.visitSite) {
          case "01":
              $("#obj_visitSite_1").attr("checked",true);
              break;
          case "02":
              $("#obj_visitSite_2").attr("checked",true);
              break;
      }
      var messageAprove= getmessage(id,5);
      //console.log(messageAprove);
      $("#obj_commentView").val(messageAprove);
      //$("#obj_id").val(data.id);
    }
}


function setSelfAction(){
    var url='tvisit/setSelfAction.php';
     jsonObj={
      id:$("#obj_id").val(),
      status:$('input[name="obj_status"]:checked').val(),
      message:$("#obj_message").val()
     }
    var jsonData=JSON.stringify (jsonObj);
    var flag=executeData(url,jsonObj,false);
    return flag;
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

function displayData(){
 
    var url="<?=$rootPath?>/tvisit/displayData.php?userCode="+$("#obj_userCode").val();
    //console.log(url);
    $("#tblDisplay").load(url);
 }

 function loadPage(){
    loadInput();
    displayData();


 }
 function setYearPlan(){
    const d = new Date();
    let year = d.getFullYear()+543;
    setDDLRange("#obj_yearPlan",year,year+20);
 }

 function pad(d) {
    return (d < 10) ? '0' + d.toString() : d.toString();
}

  function setMonth(){
    var cb="";
    for(i=0;i<12;i++){
       cb+="<option value='"+pad(i+1)+"'>"+monthArray[i]+"</option>";
    }
    $("#obj_monthPlan").html(cb);
 }


 $( document ).ready(function() {
    loadPage();
    $("#btnInput").click(function(){
        clearData();
        $("#obj_code").val(genCode());
    });


    $("#btnStatusSave").click(function(){
        setSelfAction();
        $("#modal-status").modal("hide");
        displayData();
    });

    $("#btnStatusClose").click(function(){
      $("#modal-status").modal("hide");
    });

    $("#txtSearch").change(function(){
        displayData();
    });

    $("#btnSave").click(function(){
        saveData();
    });

    
     $(".close").click(function(){
        $("#modal-input").modal("hide");
        $("#modal-status").modal("hide");

    });
 });

</script>
