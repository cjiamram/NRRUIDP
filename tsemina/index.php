<?php
      session_start();
      include_once '../config/database.php';
      include_once '../config/config.php';
      include_once '../objects/classLabel.php';
      $cnf=new Config();
     
      $database = new Database();
      $db = $database->getConnection();
      $objLbl=new ClassLabel($db);
      $rootPath=$cnf->path;
      $userCode=isset($_SESSION["UserName"])?$_SESSION["UserName"]:"";
      $departmentId=isset($_SESSION["DepartmentId"])?$_SESSION["DepartmentId"]:"";
      $departmentId=$departmentId=='ALL'?0:$departmentId;
      $topic=$objLbl->getLabel("t_semina","topic","th");

?>

<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<script src="<?=$rootPath?>/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=$rootPath?>/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<input type="hidden" id="obj_id" value="">
<input type="hidden" id="obj_userCode" value="<?=$userCode?>">
<section class="content-header">
     <h1>
        <h1>
        <b>ระบบพัฒนาตนเอง</b>

        <small>>><?php echo $topic.":" ?></small>
      </h1>
      </h1>
      <ol class="breadcrumb">
        <input type="button" id="btnInput"   class="btn btn-primary col-sm-12"  value="สร้าง">
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
     <div class="modal-dialog" id="dvInput" >
      <div class="modal-content">
          <div class="box-header with-border">
                <button type="button" class="close"  aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?=$topic?></h4>
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
                <h4 class="modal-title"><?=$topic?></h4>
           </div>
           <div class="modal-body" id="dvStatusInput">
           
           </div>
          <div>
                 <div class="modal-footer">
                    <input type="button" id="btnStatusClose" value="ปิด"  class="btn btn-default pull-left" >
                    <input type="button" id="btnStatusSave" value="บันทึก"  class="btn btn-primary" >
                  </div>
           </div>
        </div>
     </div>
   </div>
<script src="<?=$rootPath?>/tsemina/jsExecute.js"></script>
<script>
//var monthArray = ["January","February","March","April","May","June","July","August","September","October","November","December"];
var monthArray = ["มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤษจิกายน","ธันวาคม"];

function loadInput(){
      var url="<?=$rootPath?>/tsemina/input.php";
      $("#dvInputBody").load(url);

      url="<?=$rootPath?>/tsemina/view.php";
      $("#dvViewBody").load(url);
}

function loadStatus(id){
      var url="<?=$rootPath?>/tsemina/inputStatus.php";
      $("#dvStatusInput").load(url);
      $("#obj_id").val(id);
      $("#modal-status").modal("toggle");
}

function displayData(){
 
    var url="<?=$rootPath?>/tsemina/displayData.php?userCode="+$("#obj_userCode").val();
    $("#tblDisplay").load(url);
 }

 function loadPage(){
    loadInput();
    displayData();
   
 }

 function setSelfAction(){
    var url='tsemina/setSelfAction.php';
     jsonObj={
      id:$("#obj_id").val(),
      status:$('input[name="obj_status"]:checked').val(),
      message:$("#obj_message").val()
     }
    var jsonData=JSON.stringify (jsonObj);
    var flag=executeData(url,jsonObj,false);
    return flag;
 }

 function createData(){
    var url='tsemina/create.php';
    jsonObj={
      userCode:$("#obj_userCode").val(),
      improveSkill:$("#obj_improveSkill").val(),
      improveOpjective:$("#obj_improveOpjective").val(),
      budget:$("#obj_budget").val(),
      monthPlan:$("#obj_monthPlan").val(),
      yearPlan:$("#obj_yearPlan").val(),
      departmentId:<?=$departmentId?>
    }
    var jsonData=JSON.stringify (jsonObj);
    console.log(jsonData);
    var flag=executeData(url,jsonObj,false);
    return flag;
}
function updateData(){
    var url='tsemina/update.php';
    jsonObj={
      userCode:$("#obj_userCode").val(),
      improveSkill:$("#obj_improveSkill").val(),
      improveOpjective:$("#obj_improveOpjective").val(),
      budget:$("#obj_budget").val(),
      monthPlan:$("#obj_monthPlan").val(),
      yearPlan:$("#obj_yearPlan").val(),
      departmentId:<?=$departmentId?>,
      id:$("#obj_id").val()
    }
    var jsonData=JSON.stringify (jsonObj);
    var flag=executeData(url,jsonObj,false);
    return flag;
}
function readOne(id){
    $("#modal-input").modal("toggle");
    var url='tsemina/readOne.php?id='+id;
    data=queryData(url);
    if(data!=""){
      $("#obj_improveSkill").val(data.improveSkill);
      $("#obj_improveOpjective").val(data.improveOpjective);
      $("#obj_budget").val(data.budget);
      $("#obj_monthPlan").val(data.monthPlan);
      $("#obj_yearPlan").val(data.yearPlan);
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
    var url='tsemina/readOne.php?id='+id;
    data=queryData(url);
    if(data!=""){
      $("#obj_improveSkillView").val(data.improveSkill);
      $("#obj_improveOpjectiveView").val(data.improveOpjective);
      $("#obj_budgetView").val(data.budget);
      $("#obj_monthPlanView").val(data.monthPlan);
      $("#obj_yearPlanView").val(data.yearPlan);

      var messageAprove= getmessage(id,4);
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

  function setYearPlan(){
    const d = new Date();
    let year = d.getFullYear()+543;
    setDDLRange("#obj_yearPlan",year,year+20);
    setDDLRange("#obj_yearPlanView",year,year+20);

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
    $("#obj_monthPlanView").html(cb);
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

    $("#btnInput").click(function(){
        $("#modal-input").modal("toggle");
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
