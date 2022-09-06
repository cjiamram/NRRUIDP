<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once "../config/database.php";
include_once "../config/config.php";
include_once "../objects/tupposition.php";
include_once "../objects/classLabel.php";
$database = new Database();
$db = $database->getConnection();
$objLbl = new ClassLabel($db);
$cnf=new Config();
$rootPath=$cnf->path;
$groupType=isset($_SESSION["staffGroup"])?$_SESSION["staffGroup"]:2;

//print_r($groupType);

?>
 

<form role='form'>
<div class="box-body" style="height:390px">
<div class="col-sm-5">

<aside class="main-sidebar" style="width:100%;vertical-align: text-top;">
<section class="sidebar">
	   <ul class="sidebar-menu" disabled style="width:100%;vertical-align: text-top;" data-widget="tree" id="ulSpecializeView">
   
      </ul>
</section>
</aside>

</div>
<div class="col-sm-7">
	<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_upposition","expertType","th").":" ?></label>
			<div class="col-sm-12">
				<label id="obj_specializeView" disabled class="form-control"></label>
				<input type='hidden' id='obj_specializeCodeView'>
			</div>
		</div>
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_upposition","yearPlan","th").":" ?></label>
			<div class="col-sm-12">
				<input type="text" id="obj_yearPlanView" disabled>
			</div>
		</div>
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_upposition","description","th").":" ?></label>
			<div class="col-sm-12">
				<textarea class="form-control" disabled style="width:100%;" rows="3" id='obj_descriptionView'></textarea>
			</div>
		</div>

		<div class='form-group'>
						<label class="col-sm-12">ความเห็นของผูบังคับบัญชา</label>

			<div class="col-sm-12">
		

				 <textarea class="form-control" disabled style="width:100%;" rows="3" id='obj_commentView'></textarea>

			</div>
		</div>
</div>		
</div>
</form>

<script>
	var i=1;
	var k=1;
	var n=0;
	var nT=0;



	

	


	function getLevel_2(parent){
		var url ="<?=$rootPath?>/tspecialize/listTree.php?levelNo=2&parent="+parent+"&groupType=<?=$groupType?>";
		var row="";

		var data=queryData(url);
		row+="<ul>\n";
		$.each(data, function (index, value) {
			row+="<li>\n";
			row+="<a  disabled >\n";
			row+="<i id=\"chkV"+i+"\" class=\"fa fa-square-o\"></i>"+value.specialize+"</a>\n";
			row+="<input type='hidden'  value='"+value.code+"' id='obj"+i+"'>\n";
			row+="</li>\n";
			i++;

		});
		row+="</ul>\n";
		return row;
	}i=1

	function getLevel_1(parent){
		var url ="<?=$rootPath?>/tspecialize/listTree.php?levelNo=1&parent="+parent+"&groupType=<?=$groupType?>";
		var row="";
	
		var data=queryData(url);
		row+="<ul class=\"treeview-menu\">\n";
		$.each(data, function (index, value) {
			row+="<li>\n";
			if(value.enable===0){
				row+="<a  disabled><i class=\"fa fa-plus\"></i>"+value.specialize+"</a>\n";
				row+=getLevel_2(value.code);
			}
			else
			{
				row+="<a  disabled >\n";
				row+="<i id=\"chkTV"+k+"\" class=\"fa fa-square-o\"></i>"+value.specialize+"</a>\n";
				row+="<input type='hidden' value='"+value.code+"' id='objT"+k+"'>\n";
				k++;
			}

				
			row+="</li>\n";
		});
		row+="</ul>\n";
		return row;
	}

	function displayTree(){
		var url ="<?=$rootPath?>/tspecialize/listTree.php?levelNo=0&parent=&groupType=<?=$groupType?>";
		//console.log(url);
		var row="";
		var data=queryData(url);
		$.each(data, function (index, value) {
		         row+="<li class=\"treeview active\">\n";
			     row+="<a disabled>\n"
			     row+="<i class=\"fa fa-university\"></i><span>"+value.specialize+"</span>\n";
			     row+="<span class=\"pull-right-container\">\n";
			     row+="<i class=\"fa fa-angle-left pull-right\"></i>\n";
			     row+="</span>\n";
			     row+="</a>\n";
			     row+=getLevel_1(value.code);
			     row+="</li>\n";
		 });
		$("#ulSpecializeView").html(row);
		nT=k;
		n=i;
		$("#obj_specialCount").val(n);
		$("#obj_specialCountT").val(nT);
		//console.log(n);
	}



	$(document).ready(function(){
		displayTree();
		setYearPlan();
	});
</script>
