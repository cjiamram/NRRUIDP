<?php
	header("content-type:text/html;charset=UTF-8");
	include_once "../config/config.php";
	$cnf=new Config();
	$rootPath=$cnf->path;
	$pType=isset($_GET["pType"])?$_GET["pType"]:"";
	$sYear=isset($_GET["sYear"])?$_GET["sYear"]:date("Y")+543;
  $fYear=isset($_GET["fYear"])?$_GET["fYear"]:date("Y")+548;

?>

<script>
var datasets=[];
function displayPie() {
 var url="<?=$rootPath?>/retreiveData/getCountDepartmentPType.php?sYear=<?=$sYear?>&fYear=<?=$fYear?>&pType=<?=$pType?>";
 console.log(url);
 var data=queryData(url);

 for(i=0;i<data.length;i++){
    datasets.push({"name":"หน่วยงาน :"+ data[i].pType, y: parseInt(data[i].countPlan)});
 }

var chart = new CanvasJS.Chart("piePlan", {
  exportEnabled: true,
  animationEnabled: true,
  title:{
    text: "สัดส่วนแผนงานของแต่ละหน่วยงาน",
    fontFamily:"tahoma",
    fontSize:16,
    fontWeight: "bold"
  },
  legend:{
    cursor: "pointer",
    itemclick: explodePie
  },
  data: [{
    type: "pie",
    showInLegend: true,
    indexLabel: "{name}:#percent%",
    percentFormatString: "#0.##",
    toolTipContent: "{name}: <strong>{y}(#percent%) .</strong>",
    //indexLabel: "{name} จำนวนแผน {y}",
    dataPoints:datasets
  }]
});
chart.render();
}

$( document ).ready(function() {
    displayPie();
});

function explodePie (e) {
  if(typeof (e.dataSeries.dataPoints[e.dataPointIndex].exploded) === "undefined" || !e.dataSeries.dataPoints[e.dataPointIndex].exploded) {
    e.dataSeries.dataPoints[e.dataPointIndex].exploded = true;
  } else {
    e.dataSeries.dataPoints[e.dataPointIndex].exploded = false;
  }
  e.chart.render();

}
</script>

<div id="piePlan" style="height: 400px; max-width: 920px; margin: 0px auto;"></div>
