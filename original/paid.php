<?php include 'db_config.php' ?>
<?php include 'check_login.php' ?>
<?php
	
	if(isset($_GET['code']))
	{
	
		$code = $_GET['code'];
		
		$select = mysql_query("SELECT * FROM pending_transactions WHERE code = '$code'");
		
		while($fetch = mysql_fetch_array($select)) {
			
			$buyer		=	$fetch['buyer'];
			$code		=	$fetch['code'];
			$item		=	$fetch['item_id'];
			$quantity	=	$fetch['quantity'];
			
			mysql_query("INSERT INTO paid_transactions (buyer, code, item_id, quantity, shipped)
						VALUES ('$buyer', '$code', '$item', '$quantity', '0')") or die(mysql_error());
						
			mysql_query("UPDATE products SET stocks = stocks - 1 WHERE id = '$item'");
			
		}
		
		mysql_query("DELETE FROM pending_transactions WHERE code = '$code'") or die(mysql_error());
		
		
		
		echo 'Payment successful!';
		echo '<br />';
		echo '<br />';
		echo '<a href="/index.php?action=empty">Go back to Homepage</a>';
	
	}
	
	else { echo 'forbidden'; }

?>