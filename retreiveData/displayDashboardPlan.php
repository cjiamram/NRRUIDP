<?php
  include_once "../config/config.php";
  $cnf=new Config();
  $rootPath=$cnf->path;
  $sYear=date("Y")+543;

?>


<input type='hidden' id='obj_specializeCode'>
<input type="hidden" id='obj_specialCount'>

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
</div>
</div>
</div>

</div>

<div class="col-sm-3">
<aside class="main-sidebar" style="width:100%;vertical-align: text-top;">
<section class="sidebar">
     <ul class="sidebar-menu" style="width:100%;vertical-align: text-top;" data-widget="tree" id="ulSpecialize">
   
      </ul>
</section>
</aside>

</div>
<div class="col-sm-9">
  <div class="row">
         <div class="col-sm-6" id="dvBudget">
            
         </div>
        <div class="col-sm-6" id="dvPlan">
           
        </div>
</div>
</div>




<script>
  
  $("#obj_sYear").val(<?=$sYear?>);
  $("#obj_fYear").val(<?=$sYear+5?>);
  var i=1;



  function setPieBudget(specialize){
      var url="<?=$rootPath?>/retreiveData/pieBudget.php?sYear="+$("#obj_sYear").val()+"&fYear="+$("#obj_fYear").val()+"&pType=<?=$pType?>";
      $("#dvBudget").load(url);
  }

   function setPiePlan(specialize){
      var url="<?=$rootPath?>/retreiveData/piePlan.php?sYear="+$("#obj_sYear").val()+"&fYear="+$("#obj_fYear").val()"&pType=<?=$pType?>";
      $("#dvPlan").load(url);
  }


  function getReport(specialize){

  }


  function getLevel_2(parent){
    var url ="<?=$rootPath?>/tspecialize/listTree.php?levelNo=2&parent="+parent;
    var row="";

    var data=queryData(url);
    row+="<ul>\n";
    $.each(data, function (index, value) {
      row+="<li>\n";
      row+="<a href=\"#\" onclick=\"getReport('"+value.code+"')\">\n";
      row+="<i id=\"chk"+i+"\" class=\"fa fa-square-o\"></i>"+value.specialize+"</a>\n";
      row+="<input type='hidden' value='"+value.code+"' id='obj"+i+"'>\n";
      row+="</li>\n";
      i++;

    });
    row+="</ul>\n";
    return row;
  }

  function getLevel_1(parent){
    var url ="<?=$rootPath?>/tspecialize/listTree.php?levelNo=1&parent="+parent;
    var row="";
    var data=queryData(url);
    row+="<ul class=\"treeview-menu\">\n";
    $.each(data, function (index, value) {
      row+="<li>\n";
      row+="<a href=\"#\"><i class=\"fa fa-plus\"></i>"+value.specialize+"</a>\n";
      row+=getLevel_2(value.code);
      row+="</li>\n";
    });
    row+="</ul>\n";
    return row;
  }

  function displayTree(){
    var url ="<?=$rootPath?>/tspecialize/listTree.php?levelNo=0&parent=";
    var row="";
    var data=queryData(url);
    $.each(data, function (index, value) {
             row+="<li class=\"treeview active\">\n";
           row+="<a>\n"
           row+="<i class=\"fa fa-university\"></i><span>"+value.specialize+"</span>\n";
           row+="<span class=\"pull-right-container\">\n";
           row+="<i class=\"fa fa-angle-left pull-right\"></i>\n";
           row+="</span>\n";
           row+="</a>\n";
           row+=getLevel_1(value.code);
           row+="</li>\n";
     });
    $("#ulSpecialize").html(row);

    n=i;
    $("#obj_specialCount").val(n);
  }


  $(document).ready(function(){
    displayTree();
    $("#btnReport").click(function(){
     
    });
  });

</script>