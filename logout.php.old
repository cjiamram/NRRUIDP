<?php
session_start();
session_unset();
session_destroy();
function Redirect($url, $permanent = false)
{
    header('Location: ' . $url, true, $permanent ? 301 : 302);
    exit();
}

Redirect('login.php', false);
?>