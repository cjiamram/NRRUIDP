<?php
  include_once "../config/config.php";
  include_once "../config/database.php";
  include_once "../objects/tdepartment.php";

  $cnf=new Config();
  $rootPath=$cnf->path;
  $sYear=date("Y")+543;

?>


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

<div class="col-sm-9">
	 <input type="button" id="btnReport" class="btn btn-primary" value="แสดงผล"  >
   <a href='#'  id="btnFilter" class="btn btn-success">ตัวกรอง</a>

</div>
</div>
</div>

</div>


<div class="row">
        <div class="col-sm-6" id="dvPType">
            
        </div>
        <div class="col-sm-6" id="dvStatus">
           
        </div>
</div>
<div class="row">
<iframe id="dvPivot" style="width:100%;height:600px"></iframe>
</div>

  <div class="modal fade" id="modal-filter">
     <div class="modal-dialog"  >
      <div class="modal-content" style="width:800px">
          <div class="box-header with-border">
                <button type="button" class="close"  aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">เลือกหน่วยงาน</h4>
           </div>
           <div class="modal-body" id="dvFilter">

            <?php
                $database=new Database();
                $db=$database->getConnection();

                $obj=new tdepartment($db);
                $stmt = $obj->getData();
                $num = $stmt->rowCount();
                $depArr="";
                if($num>0){
                $i=0;
                echo "<table class=\"table table-bordered table-hover\">\n";
                echo "<tr><td colspan='4'><input type='checkbox' id='chkAll' checked>ทั้งหมด</td></tr>\n";

                  while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
                    extract($row);
                    if(($i+1)%2!==0){
                      echo "<tr>\n";
                    }
                    
                    if($i<$num-1)
                      $depArr.="'".$departmentId."',";
                    else
                      $depArr.="'".$departmentId."'";
                    
                    echo "<td><input type='checkbox' checked onclick='chooseDept()' id='chkD".$i."'><input type='hidden' id='dep".$i."' value='".$departmentId."'></td>\n";
                    echo "<td>".$departmentName."</td>\n";
                    if(($i+1)%2==0||$i==$num-1){
                      echo "</tr>\n";
                    }
                    

                    $i++;
                  } 

                echo "</table>\n";

                }
            ?>
           <input type="hidden" id="depArr" value="<?= $depArr?>">
           </div>
          <div>
                 <div class="modal-footer">
                    <input type="button" id="btnClose" value="ปิด"  class="btn btn-default pull-left" >
                  </div>
          </div>
      </div>
     </div>
   </div>


<script>
  
  $("#obj_sYear").val(<?=$sYear?>);
  $("#obj_fYear").val(<?=$sYear+5?>);


  function displayProgressByPType(pType){
     var url="<?=$rootPath?>/retreiveData/pieProgressByPType.php?sYear="+$("#obj_sYear").val()+"&fYear="+$("#obj_fYear").val()+"&depArr="+$("#depArr").val()+"&pType="+pType;
     $("#dvStatus").load(url);
   }


  function setPiePType(){
     var url="<?=$rootPath?>/retreiveData/piePTypeProgress.php?sYear="+$("#obj_sYear").val()+"&fYear="+$("#obj_fYear").val()+"&depArr="+$("#depArr").val();
     $("#dvPType").load(url);
  }

  



  function chooseDept(){
     var depArr="";
     var i=0;
     while(document.getElementById("chkD"+i) !== null){
        
        if(document.getElementById('chkD'+i).checked==true){
          depArr+="'"+$("#dep"+i).val()+"'"+",";
        }
        i++;       
     }
     let length = depArr.length;
     let result = depArr.substring(0, length-1);
     $("#depArr").val(result);
     //console.log( $("#depArr").val());
  }


  function setPivot(){
      var url="<?=$rootPath?>/retreiveData/pivotProgress.php?sYear="+$("#obj_sYear").val()+"&fYear="+$("#obj_fYear").val()+"&depArr="+$("#depArr").val();
      $('#dvPivot').attr('src', url)

  }

  function displaAll(){
      setPiePType();
      setPivot();
  }

  displaAll();
  displayProgressByPType("");

  function selectAll(){

      var flag=document.getElementById('chkAll').checked;
      var i=0;
      while(document.getElementById("chkD"+i) !== null){
        document.getElementById('chkD'+i).checked=flag;
        i++;       
     }
  } 

  $("#chkAll").click(function(){
    selectAll();
    chooseDept();
    displaAll();
  });


  $("#btnReport").click(function(){
      displaAll();
      displayProgressByPType("");
  });

  $("#btnFilter").click(function(){
         
      $("#modal-filter").modal("toggle");
   });

  $("#btnClose").click(function(){
      displaAll()
       $("#modal-filter").modal("hide");
    });


  $(".close").click(function(){
        displaAll()
       $("#modal-filter").modal("hide");
  });

  $(document).ready(function(){
 

   
  });

</script>