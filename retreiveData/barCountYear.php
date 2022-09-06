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




function displayBar() {
 var url="<?=$rootPath?>/retreiveData/getCountYear.php?sYear=<?=$sYear?>&fYear=<?=$fYear?>&depArr=<?=$depArr?>";
 var data=queryData(url);

 if(data!==undefined){

         for(i=0;i<data.length;i++){
            datasets.push({label: data[i].yearPlan, y: parseInt(data[i].countPlan)});
         }

        var chart = new CanvasJS.Chart("barCountYear", {
          exportEnabled: true,
          animationEnabled: true,
          theme: "light2", // "light1", "light2", "dark1", "dark2"
          title:{
            text: "แผนภูมิแผนการพัฒนาตนเองรายปี",
            fontFamily:"tahoma",
            fontSize:16,
            fontWeight: "bold"
          },

           axisY: {
              title: "จำนวนแผน"
        },
         
          data: [{

                   click: function(e){
                     setPieDepartmentByYear(e.dataPoint.label);
                     setPiePTypeByYear(e.dataPoint.label);
                },
                type: "column",  
                showInLegend: true, 
                legendMarkerColor: "grey",
                legendText: "จำนวนแผนงานในแต่ละปี",
                dataPoints:datasets
          }]
        });
        chart.render();
    }
}

$( document ).ready(function() {
    displayBar();
});

</script>

<div id="barCountYear" style="height: 500px;width:920px; margin: 0px auto;"></div>
