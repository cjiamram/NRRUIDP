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
      $rootPath=$cnf->path;
      $userCode=isset($_SESSION["UserName"])?$_SESSION["UserName"]:"";
      $departmentId=isset($_SESSION["DepartmentId"])?$_SESSION["DepartmentId"]:"";
      $departmentId=$departmentId=='ALL'?0:$departmentId;
      $topic= $objLbl->getLabel("t_upposition","topic","th");


?>
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<script src="<?=$rootPath?>/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=$rootPath?>/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<input type="hidden" id="obj_id" value="">
<input type="hidden" id="obj_userCode" value="<?=$userCode?>">
<input type="hidden" id="obj_specialCount">
<input type="hidden" id="obj_specialCountT">
<section class="content-header">
     <h1>
        <b>ระบบพัฒนาตนเอง</b>

        <small>>><?=$topic?>:</small>
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


     <section class="content container-fluid">
      <div class="box"></div>
     
      <div>&nbsp;</div>
      <div class="col-sm-12">
      <div class="box box-primary">
      <div class="box-header with-border">
      <h3 class="box-title"><b>รายงานความคืบหน้าการขอผลงาน</b></h3>
      </div>
      <table id="tblProgress" class="table table-bordered table-hover">
      </table>
      </div>  
      </div>
        
    </section>


   <div class="modal fade" id="modal-input">
     <div class="modal-dialog" style="width:900px" id="dvInput" >
      <div class="modal-content">
          <div class="box-header with-border">
                <button type="button" class="close"  aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?=$topic?></h4>
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
     <div class="modal-dialog" style="width:900px"  >
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
<script src="<?=$rootPath?>/tupposition/jsExecute.js"></script>
<script>

  function setYearPlan(){
    const d = new Date();
    let year = d.getFullYear()+543;
    setDDLRange("#obj_yearPlan",year,year+20);
 }

 function loadInput(){
      var url="<?=$rootPath?>/tupposition/inputTree.php";
      $("#dvInputBody").load(url);

       var url="<?=$rootPath?>/tupposition/view.php";
      $("#dvViewBody").load(url);
 }

 function loadStatus(id){
      var url="<?=$rootPath?>/tupposition/inputStatus.php";
      $("#dvStatusInput").load(url);
      $("#obj_id").val(id);
      $("#modal-status").modal("toggle");

}

function displayData(){
 
    var url="<?=$rootPath?>/tupposition/displayUppositionJSON.php?userCode="+$("#obj_userCode").val();
    $("#tblDisplay").load(url);
 }

 function displayProgressData(){
 
    var url="<?=$rootPath?>/trequest/displaySelfData.php?userCode="+$("#obj_userCode").val();
    //console.log(url);
    $("#tblProgress").load(url);
 }


function loadStatus(id){
      var url="<?=$rootPath?>/tupposition/inputStatus.php";
      $("#dvStatusInput").load(url);
      $("#obj_id").val(id);
      $("#modal-status").modal("toggle");

}

function setSelfAction(){
    var url='tupposition/setSelfAction.php';
     jsonObj={
      id:$("#obj_id").val(),
      status:$('input[name="obj_status"]:checked').val(),
      message:$("#obj_message").val()
     }
    var jsonData=JSON.stringify (jsonObj);
    var flag=executeData(url,jsonObj,false);
    return flag;
 }



 function loadPage(){
    loadInput();
    setYearPlan();
    displayData();
    displayProgressData();
 }

 function createData(){
    var url='tupposition/create.php';
    jsonObj={
      expertType:$("#obj_specializeCode").val(),
      yearPlan:$("#obj_yearPlan").val(),
      description:$("#obj_description").val(),
      userCode:$("#obj_userCode").val(),
      departmentId:<?=$departmentId?>
    }
    var jsonData=JSON.stringify (jsonObj);
    console.log(jsonData);

    var flag=executeData(url,jsonObj,false);
    return flag;
}
function updateData(){
    var url='tupposition/update.php';
    jsonObj={
      expertType:$("#obj_specializeCode").val(),
      yearPlan:$("#obj_yearPlan").val(),
      description:$("#obj_description").val(),
      userCode:$("#obj_userCode").val(),
      departmentId:<?=$departmentId?>,
      id:$("#obj_id").val()
    }
    var jsonData=JSON.stringify (jsonObj);
    //console.log(jsonData);
    var flag=executeData(url,jsonObj,false);
    return flag;
}


  function setInitcheck(specialCode){
    var N=$("#obj_specialCount").val();
    for(j=1;j<=N;j++){
      if($("#obj"+j).val()===specialCode){
        $("#chk"+j).removeClass("fa fa-square-o");
        $("#chk"+j).addClass("fa fa-check-square-o");
      }else{
        $("#chk"+j).removeClass("fa fa-check-square-o");
        $("#chk"+j).addClass("fa fa-square-o");
      }
    }
     var NT=$("#obj_specialCountT").val();
     //console.log(NT);
     for(j=1;j<=NT;j++){
      if($("#objT"+j).val()===specialCode){
        $("#chkT"+j).removeClass("fa fa-square-o");
        $("#chkT"+j).addClass("fa fa-check-square-o");
      }else{
        $("#chkT"+j).removeClass("fa fa-check-square-o");
        $("#chkT"+j).addClass("fa fa-square-o");
      }
    }
  }  


function readOne(id){
    $("#modal-input").modal("toggle");
    var url='tupposition/readOne.php?id='+id;
    data=queryData(url);
    if(data!=""){
      setInitcheck(data.expertType);
      $("#obj_specializeCode").val(data.expertType);
      $("#obj_specialize").text(data.specialize);
      $("#obj_yearPlan").val(data.yearPlan);
      $("#obj_description").val(data.description);
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
    var url='tupposition/readOne.php?id='+id;
    data=queryData(url);
    if(data!=""){
      setInitcheck(data.expertType);
      $("#obj_specializeCodeView").val(data.expertType);
      $("#obj_specializeView").text(data.specialize);
      $("#obj_yearPlanView").val(data.yearPlan);
      $("#obj_descriptionView").val(data.description);

        var messageAprove= getmessage(id,3);
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
    clearData();
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

function clearData(){
      $("#obj_id").val("");
      $("#obj_expertType").val("");
      $("#obj_description").val("");

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
        saveData();
    });

    $("#btnInput").click(function(){
        $("#modal-input").modal("toggle");
    });

    $("#btnSave").click(function(){
        $("#modal-input").modal("hide");
    });

    $("#btnStatusSave").click(function(){
        setSelfAction();
        $("#modal-status").modal("hide");
        displayData();
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
