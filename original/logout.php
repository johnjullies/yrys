<?php  

include 'db_config.php'; 
session_start();

// destroy session
session_destroy(); // logout to the system

header("Location:index.php") // page redirection.

?>