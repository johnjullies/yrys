<?php include 'db_config.php' ?>
<?php include 'check_login.php' ?>
<?php if (!isset($_SESSION['username'])) {
    header("Location:login.php");
    exit();
} ?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>

    <!-- Basic Page Needs
  ================================================== -->
    <meta charset="utf-8">
    <title>Y.R.Y.S. | Transaction</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Mobile Specific Metas
  ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- CSS
  ================================================== -->
    <link rel="stylesheet" href="stylesheets/base.css">
    <link rel="stylesheet" href="stylesheets/skeleton.css">
    <link rel="stylesheet" href="stylesheets/layout.css">
    <link rel="stylesheet" href="stylesheets/lightbox.css">
    <link rel="stylesheet" href="stylesheets/go-top.css">

    <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Favicons
    ================================================== -->
    <link rel="shortcut icon" href="images/favicon.jpg">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">
    
    <script src="/scripts/jquery-1.9.1.js" type="text/javascript"></script>
    <script src="/scripts/lightbox.js" type="text/javascript"></script>

</head>
<body>
    <div class="container">
    
    <div id="header"></div>

    <?php include 'menu.php' ?>

    <?php
	
	
	$buyer	= $_SESSION['username'];
	$code	= md5(uniqid(rand(), true));
	$time	= time();
	$total	= 0;
	
	$delete = $time - 86400;
	
	mysql_query("DELETE FROM pending_transaction WHERE timestamp = $delete");

	foreach($_SESSION['cart'] as $product_id => $quantity) {
		//get the name, description and price from the database - this will depend on your database implementation.
        //use sprintf to make sure that $product_id is inserted into the query as a number - to prevent SQL injection
        $sql = sprintf("SELECT id, name, price FROM products WHERE id = %d;", $product_id); 

        $result = mysql_query($sql);

        //Only display the row if there is a product (though there should always be as we have already checked)
        if(mysql_num_rows($result) > 0) {

            list($id, $name, $price) = mysql_fetch_row($result);

            $line_cost = $price * $quantity; //work out the line cost
			
			$total = $total + $line_cost;

            //show this information in table cells
            //along with a 'remove' link next to the quantity - which links to this page, but with an action of remove, and the id of the current product
			
			mysql_query("INSERT INTO pending_transactions (buyer, code, item_id, quantity, timestamp)
						VALUES ('$buyer', '$code', '$id', '$quantity', '$time')") or die(mysql_error());
        }
	}
	
	echo "<div class='sixteen columns add-bottom'>
			<h3>Your price: P" . $total . "</h3>
		</div>";
	
	echo '<div class="sixteen columns">
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" style="display:inline;">
				<input type="hidden" name="cmd" value="_xclick">
				<input type="hidden" name="business" value="markagliam@yahoo.com">
				<input type="hidden" name="cancel_return" value="' . $_SERVER["DOCUMENT_ROOT"] . '/checkout.php">
				<input type="hidden" name="return" value="' . $_SERVER["DOCUMENT_ROOT"] . '/paid.php?code=' . $code . '">
				<input type="hidden" name="rm" value="2">
				<input type="hidden" name="lc" value="US">
				<input type="hidden" name="item_name" value="Yrys Products">
				<input type="hidden" name="amount" value="' . $total . '">
				<input type="hidden" name="currency_code" value="PHP">
				<input type="hidden" name="button_subtype" value="products">
				<input type="hidden" name="add" value="1">
				<input type="hidden" name="bn" value="PP-ShopCartBF:btn_cart_LG.gif:NonHosted">
				<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
				<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
			</form>
		</div>';
?>

    <hr style="border:0px;" /><?php include 'footer.php' ?>

    </div>



</body>
</html>
