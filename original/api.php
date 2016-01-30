<?php include 'db_config.php' ?>
<?php
	$return_arr = Array();

	// $query = mysql_real_escape_string($_GET['qery']);
	$result = mysql_query("SELECT * FROM products"); 

	if($result === FALSE) { 
	    die(mysql_error()); // TODO: better error handling
	}

	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
	    array_push($return_arr, $row);
	}
	echo json_encode($return_arr);
?>