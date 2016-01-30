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
    <title>Y.R.Y.S. | Checkout</title>
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
    echo '<div class="sixteen columns">';
    echo '<h3 class="add-bottom">Checkout</h3>';
    echo '<table class="add-bottom">';
    echo '<tr>
            <th>Name</th>
            <th>Quantity</th>
            <th>Cost</th>
            <th>Action</th>
        </tr>';
    foreach($_SESSION['cart'] as $product_id => $quantity) {
        //get the name, description and price from the database - this will depend on your database implementation.
        //use sprintf to make sure that $product_id is inserted into the query as a number - to prevent SQL injection
        $sql = sprintf("SELECT name, description, price FROM products WHERE id = %d;",
$product_id); 

        $result = mysql_query($sql);

        //Only display the row if there is a product (though there should always be as we have already checked)
        if(mysql_num_rows($result) > 0) {

            list($name, $description, $price) = mysql_fetch_row($result);

            $line_cost = $price * $quantity; //work out the line cost

            //show this information in table cells
            //along with a 'remove' link next to the quantity - which links to this page, but with an action of remove, and the id of the current product
            echo '<tr>
                    <td>'.$name.'</td>
                    <td>'.$quantity.'</td>
                    <td>'.$line_cost.'</td>
                    <td><a href=\"$_SERVER[PHP_SELF]?action=remove&id=$product_id\" style=\"display:inline;background:none;margin:0;padding:0;\">Remove</a></td>
                </tr>';            
        }
    }
    echo '<tr><td style="padding-top:15px"><a href="transaction.php"><button><span class="glyph">&#xe17c;</span>Pay</button></a></td></tr>';
    echo '</table>';
    echo '</div>';
?>

    <hr style="border:0px;" /><?php include 'footer.php' ?>

    </div>



</body>
</html>