<?php
    include_once "../config/config.php";
    $cnf=new Config();
    $rootPath=$cnf->path;
    $sYear=isset($_GET["sYear"])?$_GET["sYear"]:date("Y")+543;
    $fYear=isset($_GET["fYear"])?$_GET["fYear"]:date("Y")+548;
    $depArr=isset($_GET["depArr"])?$_GET["depArr"]:"";


?>
<html>
<head>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script  src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script  src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script  src="<?=$rootPath?>/dist/pivot.js"></script>


<link rel="stylesheet" type="text/css" href="../dist/pivot.css">

<link rel="stylesheet" href="<?=$rootPath?>/bower_components/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="<?=$rootPath?>/bower_components/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="<?=$rootPath?>/bower_components/Ionicons/css/ionicons.min.css">
<link rel="stylesheet" href="<?=$rootPath?>/dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="<?=$rootPath?>/dist/css/skins/skin-blue.min.css">
<link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

<style>

body {font-family: Verdana;}
		.node {
		border: solid 1px white;
		font: 10px sans-serif;
		line-height: 12px;
		overflow: hidden;
		position: absolute;
		text-indent: 2px;
}

</style>
</head>

<script>

	function setPivotData(){
		var url="<?=$rootPath?>/retreiveData/getPivotProgress.php?sYear=<?=$sYear?>&fYear=<?=$fYear?>&depArr=<?=$depArr?>";
        $.getJSON(url, function(mps) {


            $("#output").pivotUI(mps, {
                rows: ["ประเภทแผน","สถานะแผนงาน"],
                cols: ["หน่วยงาน","ปี"],
                aggregatorName: "Integer Sum",
                vals: ["จำนวนแผน"],
                rendererName: "Heatmap",
                rendererOptions: {
                    table: {
                        clickCallback: function(e, value, filters, pivotData){
                            var names = [];
                            pivotData.forEachMatchingRecord(filters,
                                function(record){ names.push(record.Name); });
                            alert(names.join("\n"));
                        }
                    }
                }
            });
        });
    }
    

    $( document ).ready(function() {
    		setPivotData();

            $('script').each(function() {

            if (this.src === '../dist/pivot.js') {
                  this.parentNode.removeChild( this );
                }
            });
	});

</script>

<body>
<div class="col-sm-12">
<div id="output"  style="margin: 30px;width:900px"></div>
</div>

</body>
</html>