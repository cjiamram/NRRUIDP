<?php
      session_start();
      include_once '../config/database.php';
      include_once '../config/config.php';
      include_once '../objects/classLabel.php';
      $cnf=new Config();
      $rootPath=$cnf->path;
      $module=$cnf->systemModule;
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
      
      $dapartmentId=isset($_SESSION["DepartmentId"])?$_SESSION["DepartmentId"]:"";
      $userCode=isset($_SESSION["UserName"])?$_SESSION["UserName"]:"";
      $topic=$objLbl->getLabel("t_mgmreport","aproval","th");
      
?>
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<script src="<?=$rootPath?>/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=$rootPath?>/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<input type="hidden" id="obj_id" value="">
<section class="content-header">
     <h1>
        <b><?=$module?></b>

        <small>>><?= $topic?>:</small>
      </h1>
      <ol class="breadcrumb">
   
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box"></div>
        <div class="form-group">
          <div class="col-sm-12">
             <div class="col-sm-6">
               <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-search"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="txtSearch">
                </div>
             </div>
             <div>
              <div  class="col-sm-4">
              </div>
          </div>
          </div>
        </div>

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
<script>


function setRequestStatus(id,pType,status){

  var url="";
  var flag=false;
  jsonObj={
        "id":id,
        "isAprove":status
      }

  jsonData=JSON.stringify(jsonObj);
  console.log(jsonData);

  switch(pType){
    case "1":
      {url="<?=$rootPath?>/tacademicplan/setAprove.php";
      flag=executeData(url,jsonObj,false);}
      break;
    case "2":
      {url="<?=$rootPath?>/tresearch/setAprove.php"; 
      flag=executeData(url,jsonObj,false);}
      break;
    case "3":
      {url="<?=$rootPath?>/tupposition/setAprove.php";
      flag=executeData(url,jsonObj,false);}
      break;
    case "4":
      {url="<?=$rootPath?>/tsemina/setAprove.php";
      flag=executeData(url,jsonObj,false);}
      break;
    case "5":
      url="<?=$rootPath?>/tvisit/setAprove.php";
      flag=executeData(url,jsonObj,false);
      break;
  }
  return flag;
}

function saveAprove(){
   

    var url ="<?=$rootPath?>/tsupervisoraprove/create.php";
    var supervisorCode='<?=$userCode?>';
    //console.log(url);
    var jsonObj={
        idRequest:$("#obj_requestId").val(),
        workType: $("#obj_workType").val(),
        userCode:$("#obj_userCode").val(),
        supervisorCode:supervisorCode,
        levelWork:$("#obj_levelWork").val(),
        notification:$("#obj_notification").val(),
        statusAprove:$('input[name="obj_status"]:checked').val()
    }
    var jsonData=JSON.stringify (jsonObj);
    //console.log(url);
    var flag=executeData(url,jsonObj,false);
    //console.log(jsonData);
    //console.log(flag);
    flag &=setRequestStatus($("#obj_requestId").val(),$("#obj_workType").val(),$('input[name="obj_status"]:checked').val());
    console.log(flag);
    return flag;
}



function sendEmail(requestCode,msg){
  var url="<?=$rootPath?>/retreiveData/sendMail.php";
  var jsonObj={
    "userCode":requestCode,
    "msg":msg
  }
  var jsonData=JSON.stringify (jsonObj);
  console.log(jsonData);
  flag=executeData(url,jsonObj,false);
  return flag;
}

function loadInput(){
   var url="<?=$rootPath?>/tsupervisoraprove/input.php";
   $("#dvInputBody").load(url);

}

function displayData(){
    var url="<?=$rootPath.'/'.$lastPath?>/displayDataWaitAproveByLevelJSON.php?userCode=<?=$userCode?>";
    $("#tblDisplay").html("");
    $("#tblDisplay").load(url);
 }


 function displayRequest(){

 }

 function loadPage(){
    loadInput();
    displayData();
 }

 function getAprove(id,pType){
    var url ="<?=$rootPath?>/taproverequest/input.php?id="+id+"&pType="+pType+"&userCode=<?=$userCode?>";
    $("#dvInputBody").load(url);
    $("#modal-input").modal("toggle");

 }

 function setAprove(id,pType,underCode,fullName,supervisorCode,levelStatus){
    $("#obj_requestId").val(id);  
    $("#obj_workType").val(pType);  
    $("#obj_supervisorCode").val(supervisorCode);
    $("#obj_levelWork").val(levelStatus);
    $("#obj_fullName").val(fullName);
    $("#obj_userCode").val(underCode);
    $("#modal-input").modal("toggle");
 }

 $( document ).ready(function() {
    loadPage();
    $("#btnInput").click(function(){
        $("#modal-input").modal("toggle");
    });

    $("#txtSearch").change(function(){
        displayData();
    });

    $("#btnSave").click(function(){
        flag=saveAprove();
        if(flag===1){
         swal.fire({
            title: "อนุมัติแผนพัฒนาเสร็จสมบูรณ์แล้ว",
            type: "success",
            buttons: [false, "ปิด"],
            dangerMode: false,
            }).then((result)=>{
                sendEmail($("#obj_userCode").val(),$("#obj_message").val());
                displayData();
            });
        }
        
        $("#modal-input").modal("hide");

    });


    $("#btnClose").click(function(){
       $("#modal-input").modal("hide");

    });

    $(".close").click(function(){
       $("#modal-input").modal("hide");

    });
 });

</script>
