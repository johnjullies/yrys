<?php include '../db_config.php' ?>
<?php include '../check_login.php' ?>
<?php

	if(isset($_GET['id'])) {
		$id = $_GET['id'];
		
		mysql_query("UPDATE paid_transactions SET shipped = 1 WHERE id = '$id'") or die(mysql_error());;
		
		header('location: dashboard.php');
	}
	
	header('location: dashboard.php');

?>