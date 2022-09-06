<!DOCTYPE html>
<?php
    include_once "config/config.php";
    $cnf=new Config();
    $rootPath=$cnf->path;
?>
<html lang="en">
<head>
  <title>Login</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->  
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="Login Template/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="Login Template/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="Login Template/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
<!--<link rel="stylesheet" type="text/css" href="Login Template/vendor/animate/animate.css">-->
<!--===============================================================================================-->  
<!--<link rel="stylesheet" type="text/css" href="Login Template/vendor/css-hamburgers/hamburgers.min.css">-->
<!--===============================================================================================-->
<!--===============================================================================================-->
<!--===============================================================================================-->  
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="Login Template/css/util.css">
  <link rel="stylesheet" type="text/css" href="Login Template/css/main.css">
<!--===============================================================================================-->
</head>
<body>
  
  <div class="limiter">
    <div class="container-login100">
      <div class="wrap-login100">
        <div class="login100-form-title" style="background-image: url('Login Template/images/bg-01.jpg');">
          <span class="login100-form-title-1">
            NRRU Individual Development Plan
          </span>
        </div>

        <form class="login100-form validate-form">
          <div class="wrap-input100 validate-input m-b-26" data-validate="Username is required">
            <span class="label-input100">Username</span>
            <input class="input100" type="text" id="txtUser" name="username" placeholder="Enter username">
            <span class="focus-input100"></span>
          </div>

          <div class="wrap-input100 validate-input m-b-18" data-validate = "Password is required">
            <span class="label-input100">Password</span>
            <input class="input100" type="password" id="txtPassword" name="pass" placeholder="Enter password">
            <span class="focus-input100"></span>
          </div>



          <div class="container-login100-form-btn">

            <input type="button" id="btnLogin" value="login" class="login100-form-btn">
          </div>
        </form>
      </div>
    </div>
  </div>
  
<!--===============================================================================================-->
  <script src="Login Template/vendor/jquery/jquery-3.2.1.min.js"></script>
  <script src="js/plugins/sweetalert/sweetalert2.all.min.js"></script>

<!--===============================================================================================-->
<!--===============================================================================================-->
<!--===============================================================================================-->
  <!--<script src="Login Template/js/main.js"></script>-->

</body>
</html>
<script>

    function executeData(url,jsonObj){
    var result;
    var jsonData=JSON.stringify (jsonObj);
      $.ajax({
        //**************
          url: url,
          contentType: "application/json; charset=utf-8",
          type: "POST",
          dataType: "json",
          data:jsonData,
          async:false,
          success: function(data){
              result = data;
          } 
        //**************
      });
      return result;
  }

  function executeGet(url){
    var result;
    $.ajax({
      type:'GET',
      url:url,
      dataType:'json',
      async:false,
      success:function(data){
 
       result=data;
      }
    });
    return result;
  }


    function validLogin(){
      var url="<?=$rootPath?>/user/getUser.php";
      var jsonObj= {
        userName:$("#txtUser").val(),
        password:$("#txtPassword").val()        
      };
      var jsonData=JSON.stringify (jsonObj);
      var data=executeData(url,jsonObj);
      if(data.flag==true){
        $(location).attr('href','index.php');
      }
      else
      {
            url="<?=$rootPath?>/api/nrruCredential.php";
            data=executeData(url,jsonObj);
            if(data.message===true){
                url="<?=$rootPath?>/menu/setMenuDefault.php?UserCode="+$("#txtUser").val();
                flag=executeGet(url);
                $(location).attr('href','index.php');
            }else
            {
              swal.fire({
                            title: "รหัสผ่านไม่ถูกต้อง",
                            type: "error",
                            buttons: [false, "ปิด"],
                            dangerMode: true,
                        });
            }
      }
    }

    $("#btnLogin").click(function(){
        validLogin();
    });
 
</script>