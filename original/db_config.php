<?php

	$yrys_dbun		=	'root';	
	$yrys_dbpw		=	'';
	$yrys_dbname	=	'yrys_db';
	$yrys_dbhost	=	'localhost';
	
	$connect	=	mysql_connect($yrys_dbhost, $yrys_dbun, $yrys_dbpw) or die(mysql_error());
	mysql_select_db($yrys_dbname, $connect);

?>