<?php
	header ("content-type:html/text;charset=UTF-8");
	include_once "../config/config.php";
	$cnf=new Config();
	$rootPath=$cnf->path;


?>

<link rel="stylesheet" href="<?=$rootPath?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">


<form role='form'>
<div class="box-body">
	<div class='form-group'>
		<label class="col-sm-3">คำค้น</label>
		<div class="col-sm-9">
			<input type="text" 
			class="form-control" id='obj_keySupervise' 
			placeholder='keyword'>
		</div>
	</div>
	<div class='form-group'>
		<table id="tblSearch" class="table table-bordered table-hover"></table>
	</div>
</div>
</form>

<script src="<?=$rootPath?>/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=$rootPath?>/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>


<script>
	function displayData(){
		//console.log($("#obj_keyWord").val());
		var url="<?=$rootPath?>/tsupervisorevaluate/searchSupervisor.php?keyWord="+$("#obj_keySupervise").val();
		//console.log(url);
		$("#tblSearch").load(url);
	}

	$(document).ready(function(){
		displayData();
		$("#obj_keySupervise").change(function(){
			displayData();
		});
	});

</script>

