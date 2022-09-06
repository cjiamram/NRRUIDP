<?php
	header("content-type:text/html;charset=UTF-8");
	include_once "../config/config.php";
	$cnf=new Config();
	$rootPath=$cnf->path;
	$sYear=isset($_GET["sYear"])?$_GET["sYear"]:date("Y")+543;
  $fYear=isset($_GET["fYear"])?$_GET["fYear"]:date("Y")+548;
  $depArr=isset($_GET["depArr"])?$_GET["depArr"]:"";

?>

<script>
var datasets=[];


  function setPiePTypeByDepartment(departmentCode){
     var url="<?=$rootPath?>/retreiveData/piePTypeByDepartment.php?sYear="+$("#obj_sYear").val()+"&fYear="+$("#obj_fYear").val()+"&departmentCode="+departmentCode;
     $("#dvPType").load(url);
  } 



function displayPie() {
 var url="<?=$rootPath?>/retreiveData/getCountDepartment.php?sYear=<?=$sYear?>&fYear=<?=$fYear?>&depArr=<?=$depArr?>";
 //console.log(url);
 var data=queryData(url);

if(data!==undefined){


 for(i=0;i<data.length;i++){
    datasets.push({"name":"หน่วยงาน :"+ data[i].departmentName, y: parseInt(data[i].CNT),"departmentCode":data[i].departmentCode});
 }

var chart = new CanvasJS.Chart("pieDept", {
  exportEnabled: true,
  animationEnabled: true,
  title:{
    text: "สัดส่วนแผนการพัฒนาตนเองโดยแยกตามหน่วยงาน",
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
          setPiePTypeByDepartment(e.dataPoint.departmentCode);
    },
    type: "pie",
    showInLegend: true,
    indexLabel: "{name}:#percent%",
    //toolTipContent: "{name}: <strong>{y}(#percent%) .</strong>",

    percentFormatString: "#0.##",
    toolTipContent: "{name}: <strong>{y}(#percent%) .</strong>",
    //indexLabel: "{name} จำนวนแผน {y}",
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

$(document).ready(function(){
  /*$("#pieDept").click( 
                        function(evt){
                            var activePoints = myNewChart.getSegmentsAtEvent(evt);
                            var url = "http://example.com/?label=" + activePoints[0].label + "&value=" + activePoints[0].value;
                            alert(url);
                        }
                    ); */    
});
</script>

<div id="pieDept" style="height: 400px; max-width: 920px; margin: 0px auto;"></div>
