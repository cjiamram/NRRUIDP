<?php
	header("content-type:text/html;charset=UTF-8");
	include_once "../config/config.php";
	$cnf=new Config();
	$rootPath=$cnf->path;
	$pType=isset($_GET["pType"])?$_GET["pType"]:"";
	$pTypeText=isset($_GET["pTypeText"])?$_GET["pTypeText"]:"";
	$sYear=isset($_GET["sYear"])?$_GET["sYear"]:date("Y")+543;
  $fYear=isset($_GET["fYear"])?$_GET["fYear"]:date("Y")+548;
  $depArr=isset($_GET["depArr"])?$_GET["depArr"]:"";


?>

<script>
var datasets=[];





function displayPie() {
 var url="<?=$rootPath?>/retreiveData/getCountPtype.php?sYear=<?=$sYear?>&fYear=<?=$fYear?>&depArr=<?=$depArr?>";
 var data=queryData(url);

if(data!==undefined){
 for(i=0;i<data.length;i++){
    datasets.push({"name":"หัวข้อ :"+ data[i].pType, y: parseInt(data[i].CNT),"pType":data[i].pTypeCode});
 }

var chart = new CanvasJS.Chart("piePType", {
  exportEnabled: true,
  animationEnabled: true,
  title:{
    text: "สัดส่วนแผนการพัฒนาตนเองโดยแยกตามหัวข้อการพัฒนาตนเอง",
    fontFamily:"tahoma",
    fontSize:16,
    fontWeight: "bold"
  },
  legend:{
    cursor: "pointer",
    itemclick: explodePie
  },
  data: [{
    click: function(e){
        displayProgressByPType(e.dataPoint.pType);
    },
    type: "pie",
    showInLegend: true,
    indexLabel: "{name}:#percent%",
    percentFormatString: "#0.##",
    toolTipContent: "{name}: <strong>{y}(#percent%) .</strong>",
    dataPoints:datasets
  }]
});
chart.render();
}
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

<div id="piePType" style="height: 400px; max-width: 920px; margin: 0px auto;"></div>
