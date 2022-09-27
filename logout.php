<?php
include_once "config/config.php";
$cnf=new Config();
session_start();

function clear($permanent = false)
{
	$key=$_SESSION["id"];
		/*if (isset($_COOKIE[$key])) {
			    unset($_COOKIE[$key]);
			    setcookie($key, '', time() - 3600, '/'); // empty value and old timestamp
			}*/
	unset($_COOKIE['fpc=AnsVOpIQQ2JDvqI7kLO-Oxk']);

    session_destroy();
    session_unset();
	session_destroy();
}


clear(false);


?>

<script>
		function deleteAllCookies(){
		   var cookies = document.cookie.split(";");
		   console.log(cookies);
		   for (var i = 0; i < cookies.length; i++){
		     console.log(i);
		     deleteCookie(cookies[i].split("=")[0]);
		    }
		}

		function setCookie(name, value, expirydays) {
		 var d = new Date();
		 d.setTime(d.getTime() + (expirydays*24*60*60*1000));
		 var expires = "expires="+ d.toUTCString();
		 document.cookie = name + "=" + value + "; " + expires;
		}

		function deleteCookie(name){
		  setCookie(name,"",-1);
		}

		deleteAllCookies();
		window.location.assign('<?=$cnf->restURL?>');
</script>