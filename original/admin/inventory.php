<?php include '../db_config.php' ?>
<?php include '../check_login.php' ?>
<?php if ($_SESSION['username'] != "admin") {
	header("Location:404");
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
	<title>Y.R.Y.S. | Your rules, your style.</title>
	<meta name="description" content="">
	<meta name="author" content="">

	<!-- Mobile Specific Metas
  ================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- CSS
  ================================================== -->
	<link rel="stylesheet" href="../stylesheets/base.css">
	<link rel="stylesheet" href="../stylesheets/skeleton.css">
	<link rel="stylesheet" href="../stylesheets/layout.css">
    <link rel="stylesheet" href="../stylesheets/lightbox.css">
    <link rel="stylesheet" href="../stylesheets/go-top.css">

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
	<div id="lightbox">
    	<p>click to close</p>
    	<div id="lightbox-shade" onclick="closeLightbox()"></div>
    	<div id="lightbox-content"></div>
    </div>

	<div class="container">
		<div id="header"></div>

		<?php include 'menu.php' ?>

		<!-- Posts / Products
		================================================== -->
			<div class="sixteen columns">
	<h3 class="add-bottom">Product List</h3>
	<table>
    	<thead>
        	<th>Id</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>stocks</th>
        </thead>
        <tbody>
        	<?php
			
				$select = mysql_query("SELECT * FROM products ORDER BY id ASC");
				
				while($fetch = mysql_fetch_array($select)) {
					echo '<tr>';
					echo '	<td>' . $fetch['id'] . '</td>';
					echo '	<td>' . $fetch['name'] . '</td>';
					echo '	<td>' . $fetch['category'] . '</td>';
					echo '	<td>' . $fetch['price'] . '</td>';
					echo '	<td>' . $fetch['stocks'] . '</td>';
					echo '</tr>';
				}
				
			?>
        </tbody>
    </table>
</div>

<div class="sixteen columns">
	<h3 class="add-bottom">Paid Transactions</h3>
	<table>
    	<thead>
        	<th>Id</th>
            <th>Buyer</th>
            <th>Code</th>
            <th>Item Id</th>
            <th>Quantity</th>
            <th>Shipped?</th>
            <th>Mark as Shipped</th>
        </thead>
        <tbody>
        	<?php
			
				$select = mysql_query("SELECT * FROM paid_transactions ORDER BY id ASC");
				
				while($fetch = mysql_fetch_array($select)) {
					echo '<tr>';
					echo '	<td>' . $fetch['id'] . '</td>';
					echo '	<td>' . $fetch['buyer'] . '</td>';
					echo '	<td>' . $fetch['code'] . '</td>';
					echo '	<td>' . $fetch['item_id'] . '</td>';
					echo '	<td>' . $fetch['quantity'] . '</td>';
					echo '	<td>'; if($fetch['shipped'] == '0') { echo 'no'; } else { echo 'yes'; }  
					echo '	</td>';
					echo '	<td style="text-align:center"><a href="/admin/ship.php?id=' . $fetch['id'] . '"><button><span class="glyph" style="">&#xe20b;</span></button></a></td>';
					echo '</tr>';
				}
				
			?>
        </tbody>
    </table>
</div>

	<hr style="border:0px" /><?php include '../footer.php' ?>

		<a href="#" class="go-top">BACK TO<br>TOP</a>
	</div>

	<script>
		$(document).ready(function() {
			// Show or hide the sticky footer button
			$(window).scroll(function() {
				if ($(this).scrollTop() > 200) {
					$('.go-top').fadeIn(200);
				} else {
					$('.go-top').fadeOut(200);
				}
			});
			
			// Animate the scroll to top
			$('.go-top').click(function(event) {
				event.preventDefault();
				
				$('html, body').animate({scrollTop: 0}, 500);
			})
		});
	</script>


<!-- End Document
================================================== -->
</body>
</html>