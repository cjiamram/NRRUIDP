arr=window.location.pathname.split('/');

function makeFolder(folder){
     console.log(folder);
     $.ajax({
        url: '/'+arr[1]+'/fileManagement/makeFolder.php?folder='+folder,
        type: 'get',
        contentType: false,
        processData: false,
        success: function(response){

        }

     });

  }

  function fileUpload(flDoc,folder){
       makeFolder(folder);
       var fd = new FormData();
       var files = $('#'+flDoc)[0].files[0];
       fd.append('file',files);


       $.ajax({
            url: "/"+arr[1]+"/fileManagement/upload.php?folder="+folder,
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response){
                if(response != 0){
                }
                else{
                }
            }

       });
  }