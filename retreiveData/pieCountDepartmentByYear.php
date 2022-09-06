<?php
	header("content-type:text/html;charset=UTF-8");
	include_once "../config/config.php";
	$cnf=new Config();
	$rootPath=$cnf->path;
	$Year=isset($_GET["Year"])?$_GET["Year"]:date("Y")+543;
  $depArr=isset($_GET["depArr"])?$_GET["depArr"]:"";

  //print_r($Year);


?>

<script>
var datasets=[];
function displayPie() {
 var url="<?=$rootPath?>/retreiveData/getCountDepartmentByYear.php?Year=<?=$Year?>&depArr=<?=$depArr?>";
 //console.log(url);
 var data=queryData(url);
 if(data!==undefined){
         for(i=0;i<data.length;i++){
            datasets.push({"name":"หน่วยงาน :"+ data[i].departmentName, y: parseInt(data[i].countPlan)});
         }

        var chart = new CanvasJS.Chart("pieDeptByYear", {
          exportEnabled: true,
          animationEnabled: true,
          title:{
            text: "สัดส่วนแผนการพัฒนาตนเองโดยแยกตามหน่วยงานประจำปี :<?=$Year?>",
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
                  //setPiePTypeByDepartment(e.dataPoint.departmentCode);
            },
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

});
</script>

<div id="pieDeptByYear" style="height: 350px; max-width: 920px; margin: 0px auto;"></div>
