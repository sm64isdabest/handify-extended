<?php
session_start();
$_SESSION = array();
session_destroy();

if (isset($_COOKIE['userName'])) {
    unset($_COOKIE['userName']);
    setcookie('userName', '', time() - 3600, '/'); 
}

header('Location: login.php');
exit;
?>