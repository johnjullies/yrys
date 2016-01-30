<?php include 'db_config.php' ?>
<?php include 'check_login.php' ?>
<?php if (loggedin()) {
	if ($_SESSION['username'] == "admin") {
	header("Location:/admin");
	exit();
}
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
	<div id="lightbox">
    	<p>click to close</p>
    	<div id="lightbox-shade" onclick="closeLightbox()"></div>
    	<div id="lightbox-content" class="sixteen columns"></div>
    </div>

	<div class="container">
		<div id="header"></div>

		<?php include 'menu.php' ?>

		<!-- Posts / Products
		================================================== -->
			<?php				
				if(mysql_num_rows(mysql_query("SELECT * FROM products WHERE category='accessories'")) >= 1)
				{
					$select = mysql_query("SELECT * FROM products WHERE category='accessories' ORDER BY id desc LIMIT 0, 1") or die(mysql_error());
					$fetch = mysql_fetch_array($select);
					$category = 'accessories';
					
					echo '<h3 id="1">accessories</h3>';
					include 'display_items.php';
				}
				
				if(mysql_num_rows(mysql_query("SELECT * FROM products WHERE category='bags'")) >= 1)
				{
					$select = mysql_query("SELECT * FROM products WHERE category='bags' ORDER BY id desc LIMIT 0, 1") or die(mysql_error());
					$fetch = mysql_fetch_array($select);
					$category = 'bags';
					
					echo '<h3 id="2">bags</h3>';
					include 'display_items.php';
				}
				
				if(mysql_num_rows(mysql_query("SELECT * FROM products WHERE category='blouses'")) >= 1)
				{
					$select = mysql_query("SELECT * FROM products WHERE category='blouses' ORDER BY id desc LIMIT 0, 1") or die(mysql_error());
					$fetch = mysql_fetch_array($select);
					$category = 'blouses';
					
					echo '<h3 id="3">blouses</h3>';
					include 'display_items.php';
				}
				
				if(mysql_num_rows(mysql_query("SELECT * FROM products WHERE category='dress'")) >= 1)
				{
					$select = mysql_query("SELECT * FROM products WHERE category='dress' ORDER BY id desc LIMIT 0, 1") or die(mysql_error());
					$fetch = mysql_fetch_array($select);
					$category = 'dress';
					
					echo '<h3 id="4">dress</h3>';
					include 'display_items.php';
				}
				
				if(mysql_num_rows(mysql_query("SELECT * FROM products WHERE category='jackets'")) >= 1)
				{
					$select = mysql_query("SELECT * FROM products WHERE category='jackets' ORDER BY id desc LIMIT 0, 1") or die(mysql_error());
					$fetch = mysql_fetch_array($select);
					$category = 'jackets';
					
					echo '<h3 id="5">jackets</h3>';
					include 'display_items.php';
				}
				
				if(mysql_num_rows(mysql_query("SELECT * FROM products WHERE category='pants'")) >= 1)
				{
					$select = mysql_query("SELECT * FROM products WHERE category='pants' ORDER BY id desc LIMIT 0, 1") or die(mysql_error());
					$fetch = mysql_fetch_array($select);
					$category = 'pants';
					
					echo '<h3 id="6">pants</h3>';
					include 'display_items.php';
				}
				
				if(mysql_num_rows(mysql_query("SELECT * FROM products WHERE category='skirts'")) >= 1)
				{
					$select = mysql_query("SELECT * FROM products WHERE category='skirts' ORDER BY id desc LIMIT 0, 1") or die(mysql_error());
					$fetch = mysql_fetch_array($select);
					$category = 'skirts';
					
					echo '<h3 id="7">skirts</h3>';
					include 'display_items.php';
				}
				
				if(mysql_num_rows(mysql_query("SELECT * FROM products WHERE category='underwears'")) >= 1)
				{
					$select = mysql_query("SELECT * FROM products WHERE category='underwears' ORDER BY id desc LIMIT 0, 1") or die(mysql_error());
					$fetch = mysql_fetch_array($select);
					$category = 'underwears';
					
					echo '<h3 id="8">underwear</h3>';
					include 'display_items.php';
				}
			?>

			<?php include 'footer.php' ?>

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