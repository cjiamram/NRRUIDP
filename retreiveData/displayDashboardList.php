<?php
  include_once "../config/config.php";
  $cnf=new Config();
  $rootPath=$cnf->path;
  $sYear=date("Y")+543;

?>

<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<script src="<?=$rootPath?>/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=$rootPath?>/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<div class="box box-primary">

<div class="box box-success">
<div class="row">

<div class="col-sm-1">&nbsp;
	<label>ปี พ.ศ.</label>
</div>
<div class="col-sm-2">
  <table width="100%">
    <tr>
      <td>
        <select id="obj_sYear" class="form-control">
        <?php
        for($i=$sYear;$i<=$sYear+10;$i++){
            echo "<option value='".$i."'>".$i."</option>";
        }
        ?>

        </select>
      </td>
      <td>-
      </td>
      <td>
          <select id="obj_fYear" class="form-control">
          <?php
              for($i=$sYear;$i<=$sYear+10;$i++){
                  echo "<option value='".$i."'>".$i."</option>";
              }
          ?>
          </select>
      </td>
    </tr>  
  </table>
  
</div>
<div class="col-sm-1"><label>หน่วยงาน</label>
</div>
<div class="col-sm-2">
  <select id="obj_department" class="form-control"></select>
</div>
<div class="col-sm-1"><label>ประเภทแผนงาน</label>
</div>
<div class="col-sm-1">
  <select id="obj_pType" class="form-control"></select>
</div>
<div class="col-sm-1"><label>สายงาน</label>
</div>
<div class="col-sm-1">
  <select id="obj_staffType" class="form-control"></select>
</div>

<div class="col-sm-2">
	 <input type="button" id="btnReport" class="btn btn-primary" value="แสดงผล">
   <input type="button" id="btnExport" class="btn btn-success" value="Export"  >

</div>
</div>
</div>

</div>

<div class="row" id="dvData">
<div class="col-sm-12">
      <div class="box box-warning">
      <div class="box-header with-border">
      <h3 class="box-title"><b>รายการแผนพัฒนาตนเอง</b></h3>
      </div>
      <table id="tblDisplay" class="table table-bordered table-hover">
      </table>
      </div>  
      </div>
</div>


<script>
  
  $("#obj_sYear").val(<?=$sYear?>);
  $("#obj_fYear").val(<?=$sYear+5?>);

  function displayData(){
    var url="<?=$rootPath?>/retreiveData/displayReportPlan.php?departmentId="+$("#obj_department").val()+"&pType="+$("#obj_pType").val()+"&sYear="+$("#obj_sYear").val()+"&fYear="+$("#obj_fYear").val()+"&staffType="+$("#obj_staffType").val();
    $("#tblDisplay").load(url);
  }

   function exportData(){
    var url="<?=$rootPath?>/retreiveData/ExportPlanXLS.php?departmentId="+$("#obj_department").val()+"&pType="+$("#obj_pType").val()+"&sYear="+$("#obj_sYear").val()+"&fYear="+$("#obj_fYear").val()+"&staffType="+$("#obj_staffType").val();
    window.location.href = url;
  }

  function setDepartment(){
    var url="<?=$rootPath?>/tdepartment/getData.php";
    setDDL(url,"#obj_department");
  }




    function setPType(){
    var url="<?=$rootPath?>/tptype/getData.php";
    setDDL(url,"#obj_pType");
  }

  function setStaffType(){
    var url="<?=$rootPath?>/tstafftype/getData.php";
    setDDL(url,"#obj_staffType");
  }

  $(document).ready(function(){

    setDepartment();
    setPType();
    setStaffType();
    displayData();

    $("#btnReport").click(function(){
      displayData();
    });

    $("#btnExport").click(function(){
      exportData();
    });

  });

</script>