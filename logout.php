<?php 
session_start();
setcookie(session_name(), '', time() - 42000);
session_destroy();
header('Location:login.php');