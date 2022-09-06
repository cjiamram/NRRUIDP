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
      $staffId=isset($_SESSION["staffid"])?$_SESSION["staffid"]:0;

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
      $fullName=isset($_SESSION["FullName"])?$_SESSION["FullName"]:"";
      //print_r($userCode);
      $sYear=date("Y")+543;
?>
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<script src="<?=$rootPath?>/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=$rootPath?>/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<input type="hidden" id="obj_id" value="">
<section class="content-header">
     <h1>
        <b><?=$module?></b>

        <small>>><?=$objLbl->getLabel("t_mgmreport","selfReport","th")?></small>
      </h1>
      <ol class="breadcrumb">
              <input type="button" id="btnExport"   class="btn btn-primary pull-right"  value="พิมพ์รายงาน">


      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box"></div>
        <div class="form-group">
          <div class="col-sm-12">
            
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
              <div  class="col-sm-10">
                  
              </div>
            
          </div>
        </div>

      <div>&nbsp;</div>
      <div class="col-sm-12">
      <div class="box box-warning">
      <div class="box-header with-border">
      <h3 class="box-title"><b><?=$objLbl->getLabel("t_mgmreport","selfReport","th")?></b></h3>
      </div>
      <table id="tblDisplay" class="table table-bordered table-hover">
      </table>
      </div>  
      </div>
        
    </section>

    <div id="dvReport" style="display:none" >
      <iframe src="" id="frmRender"></iframe>
    </div>



<script>




function displayData(){
    var url="<?=$rootPath.'/'.$lastPath?>/displaySelfRequestReport.php?userCode=<?=$userCode?>&yearPlan="+$("#obj_yearNo").val()+"&staffId=<?=$staffId?>";
    //console.log(url);
    $("#tblDisplay").load(url);

 }

 function loadPage(){
    displayData();
    //capturPDF();
 }

  function capturPDF(){
      var url="<?=$rootPath?>/selfReport.php?userCode=<?=$userCode?>&yearPlan="+$("#obj_yearNo").val()+"&staffId=<?=$staffId?>";;
      $("#dvReport").load(url);
  }

 
 $( document ).ready(function() {
    loadPage();
    $("#obj_yearNo").change(function(){
        displayData();
        //capturPDF();
    });

    $("#btnExport").click(function(){
       var url="<?=$rootPath?>/retreiveData/genPDF.php?userCode=<?=$userCode?>&yearPlan="+$("#obj_yearNo").val()+"&staffId=<?=$staffId?>";;
        window.open(url);
       //$("#iframe").attr('src',url);
      //createPDF();
    });

    
    

  
 });

</script>
