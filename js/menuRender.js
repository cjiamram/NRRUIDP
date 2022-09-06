
var full = location.pathname;
var res = full.split("/");
var rootPath="http://localhost"+"/"+res[1];
function getChildMenu(parentMenu){
   var url=rootPath+"/menu/getChildMenu.php?parent="+parentMenu;
   //console.log(url);

   var data=queryData(url);
   var row="<ul class=\"treeview-menu\">";
   var i=0;

   $.each(data, function (index, value) {
     row+="<li><a href=\"#\" onclick='clickMenu(\""+value.Link+"\")'><i class=\"fa fa-circle-o\"></i>"+value.MenuName+"</a></li>\n";
   });

   row+="</ul>";
   return row;
} 

function clickMenu(link){
  $("#dvMain").load(link);
}

function getHeadMenu(menuPane){
   var url=rootPath+"/menu/getHeadMenu.php";
   var data=queryData(url);
   var row="";
   var i=0;
   $.each(data, function (index, value) {
     row+="<li class=\"treeview active\">\n";
     row+="<a href=\"#\">\n"
     row+="<i class=\""+value.Icon+"\"></i><span>"+value.MenuName+"</span>\n";
     row+="<span class=\"pull-right-container\">\n";
     row+="<i class=\"fa fa-angle-left pull-right\"></i>\n";
     row+="</span></a>\n";
     row+=getChildMenu(value.MenuId);
     row+="</li>\n";
     i++;
   });

  row+="<li>\n";
  row+="<a href=\"#\" onclick='logout()'>\n"
  row+="<i class=\"fa fa-sign-out\"></i><span>ออกจากระบบ</span>\n";
  row+="<span class=\"pull-right-container\">\n";
  row+="</span></a>\n";
  row+="</li>\n";

   $(menuPane).html(row);
}