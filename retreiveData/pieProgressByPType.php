<?php
	header("content-type:text/html;charset=UTF-8");
	include_once "../config/config.php";
	$cnf=new Config();
	$rootPath=$cnf->path;
	$pType=isset($_GET["pType"])?$_GET["pType"]:"";
	$sYear=isset($_GET["sYear"])?$_GET["sYear"]:date("Y")+543;
  $fYear=isset($_GET["fYear"])?$_GET["fYear"]:date("Y")+548;
  $depArr=isset($_GET["depArr"])?$_GET["depArr"]:"";

?>

<script>
var datasets=[];


function getPTypeName(code){
  //code=code=="undefined"?code:"";
  //console.log(code==="");
  var url="<?=$rootPath?>/tptype/getPTypeName.php?code="+code;
  //console.log(url);
  var data=queryData(url);
  //console.log(data);
  if(data===null||data===undefined){
    return "ทุกแผนงาน";}
  else{
    return data.pType;
  }
}


function displayPie() {
 var url="<?=$rootPath?>/retreiveData/getProgressByPtype.php?sYear=<?=$sYear?>&fYear=<?=$fYear?>&pType=<?=$pType?>&depArr=<?=$depArr?>";

 var data=queryData(url);
 if(data!==undefined){

 for(i=0;i<data.length;i++){
    datasets.push({"name":"สถานะแผนงาน :"+ data[i].planStatus, y: parseInt(data[i].countPlan)});
 }

var chart = new CanvasJS.Chart("piePlanStatus", {
  exportEnabled: true,
  animationEnabled: true,
  title:{
    text: "สัดส่วนสถานะความคืบหน้าแผนงาน :"+getPTypeName(<?=$pType?>),
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

<div id="piePlanStatus" style="height: 400px; max-width: 920px; margin: 0px auto;"></div>
