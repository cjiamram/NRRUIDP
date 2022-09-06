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
	   <ul class="sidebar-menu" style="width:100%;vertical-align: text-top;" data-widget="tree" id="ulSpecialize">
   
      </ul>
</section>
</aside>

</div>
<div class="col-sm-7">
	<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_upposition","expertType","th").":" ?></label>
			<div class="col-sm-12">
				<label id="obj_specialize" class="form-control"></label>
				<input type='hidden' id='obj_specializeCode'>
			</div>
		</div>
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_upposition","yearPlan","th").":" ?></label>
			<div class="col-sm-12">
				<select class="form-control" id='obj_yearPlan' ></select>
			</div>
		</div>
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_upposition","description","th").":" ?></label>
			<div class="col-sm-12">
				<textarea class="form-control" style="width:100%;" rows="5" id='obj_description'></textarea>
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



	function getSpecial(specialCode,specialText,i){
		$("#obj_specializeCode").val(specialCode);
		$("#obj_specialize").text(specialText);
		//console.log(specialText);

		for(j=1;j<=n;j++){
			
			$("#chk"+j).removeClass("fa fa-check-square-o");
			$("#chk"+j).addClass("fa fa-square-o");
		}

		$("#chk"+i).removeClass("fa fa-square-o");
		$("#chk"+i).addClass("fa fa-check-square-o");
	}


		function getSpecialT(specialCode,specialText,k){
		$("#obj_specializeCode").val(specialCode);
		$("#obj_specialize").text(specialText);

		for(j=1;j<=nT;j++){
			
			$("#chkT"+j).removeClass("fa fa-check-square-o");
			$("#chkT"+j).addClass("fa fa-square-o");
		}

		$("#chkT"+k).removeClass("fa fa-square-o");
		$("#chkT"+k).addClass("fa fa-check-square-o");
	}


	function getLevel_2(parent){
		var url ="<?=$rootPath?>/tspecialize/listTree.php?levelNo=2&parent="+parent+"&groupType=<?=$groupType?>";
		var row="";

		var data=queryData(url);
		row+="<ul>\n";
		$.each(data, function (index, value) {
			row+="<li>\n";
			row+="<a href=\"#\" onclick=\"getSpecial('"+value.code+"','"+value.specialize+"',"+i+")\">\n";
			row+="<i id=\"chk"+i+"\" class=\"fa fa-square-o\"></i>"+value.specialize+"</a>\n";
			row+="<input type='hidden' value='"+value.code+"' id='obj"+i+"'>\n";
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
			//console.log(value.enable);
			if(value.enable===0){
				row+="<a href=\"#\"><i class=\"fa fa-plus\"></i>"+value.specialize+"</a>\n";
				row+=getLevel_2(value.code);
			}
			else
			{
				row+="<a href=\"#\" onclick=\"getSpecialT('"+value.code+"','"+value.specialize+"',"+k+")\">\n";
				row+="<i id=\"chkT"+k+"\" class=\"fa fa-square-o\"></i>"+value.specialize+"</a>\n";
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
