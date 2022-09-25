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
      $userCode=!isset($_SESSION["UserName"])?$_SESSION["UserName"]:"";
      $sYear=date("Y")+543;
?>
<input type="hidden" id="obj_id" value="">
<section class="content-header">
     <h1>
        <b><?=$module?></b>

        <small>>><?=$objLbl->getLabel("t_mgmreport","afterAprove","th")?></small>
      </h1>
      <ol class="breadcrumb">
   

      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box"></div>
        <div class="form-group">
          <div class="col-sm-12">
             <div class="col-sm-4">
               <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-search"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="txtSearch">
                </div>
             </div>
             <div  class="col-sm-1">
                  ปี พ.ศ.
              </div>
              <div  class="col-sm-1">
                  <select id="obj_yearNo" class="form-control">
                        <?php
                        for($i=$sYear;$i<=$sYear+10;$i++){
                            echo "<option value='".$i."'>".$i."</option>";
                        }
                        ?>
                  </select>
              </div>
              <div  class="col-sm-6">
                  
              </div>
              <div  class="col-sm-1">
                  สายงาน
              </div>
              <div  class="col-sm-2">
                  <select id="obj_staffType" class="form-control">
                    <option value="">***เลือก***</option>
                    <option value="1">สายวิชาการ</option>
                    <option value="2">สายสนับสนุน</option>
                  </select>
              </div>
              <div  class="col-sm-3">
                  
              </div>
          </div>
        </div>

      <div>&nbsp;</div>
      <div class="col-sm-12">
      <div class="box box-warning">
      <div class="box-header with-border">
      <h3 class="box-title"><b><?=$objLbl->getLabel("t_mgmreport","input","th")?></b></h3>
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
                <h4 class="modal-title"><?=$objLbl->getLabel("t_mgmreport","input","th")?></h4>
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

function getAproveMessage(requestId,pType){
  var url="<?=$rootPath?>/retreiveData/getAproveMessage.php?requestId="+requestId+"&pType="+pType;
 
  var data=queryData(url);
  //console.log(data.message);
  Swal.fire(data.message);
}

function saveAprove(){
    var url='<?=$rootPath?>/taproverequest/create.php';
    jsonObj={
      requestId:$("#obj_requestId").val(),
      pType:$("#obj_pType").val(),
      message:$("#obj_message").val(),
      status:$('input[name="obj_status"]:checked').val()
    }
    var jsonData=JSON.stringify (jsonObj);
    var flag=executeData(url,jsonObj,false);
    flag &=setRequestStatus($("#obj_requestId").val(),$("#obj_pType").val(),$('input[name="obj_status"]:checked').val());
    return flag;
}

function sendEmail(userCode,msg){
  var url="<?=$rootPath?>/retreiveData/sendMail.php";
  var jsonObj={
    "userCode":userCode,
    "msg":msg
  }
  flag=executeData(url,jsonObj,false);
  return flag;
}

function loadInput(){
}

function displayData(){
    var url="<?=$rootPath.'/'.$lastPath?>/displayAfterAproveJSON.php?departmentId=<?=$dapartmentId?>&keyWord="+$("#txtSearch").val()+"&yearNo="+$("#obj_yearNo").val()+"&staffType="+$("#obj_staffType").val();
    $("#tblDisplay").load(url);
 }

 function loadPage(){
    displayData();
 }

 
 $( document ).ready(function() {
    loadPage();
  

    $("#txtSearch").change(function(){
        displayData();
    });

    $("#obj_yearNo").change(function(){
        displayData();
    });

     $("#obj_staffType").change(function(){
        displayData();
    });




  
 });

</script>
