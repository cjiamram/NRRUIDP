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
      //print_r($departmentId);


?>
<input type='hidden' id='obj_userCode' value="<?=$userCode?>">

<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<script src="<?=$rootPath?>/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=$rootPath?>/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<input type="hidden" id="obj_id" value="">
<section class="content-header">
     <h1>
        <b>ระบบพัฒนาตนเอง</b>

        <small>>>ข้อมูลส่วนบุคคล</small>
      </h1>
      <ol class="breadcrumb">
   
        <input type="button" id="btnInput"   class="btn btn-primary pull-right"  value="ข้อมูลความเชี่ยวชาญ">


      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
      <div id="dvProfile">
      </div>
        
    </section>




   
<script>
 function initProfile(){
      $("#dvProfile").load("<?=$rootPath?>/profile/displayProfile.php");

 }
 
 $( document ).ready(function() {
    initProfile();
    $("#btnInput").click(function(){
       var url="<?=$rootPath?>/texpertise/index.php";
       $("#dvMain").load(url);
    });

    

 });



</script>
