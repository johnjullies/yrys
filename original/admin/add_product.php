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
	<title>Y.R.Y.S. | Add Product</title>
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
			<?php
			if(!isset($_POST['name']) || !isset($_POST['desc']) || !isset($_POST['cat']) || !isset($_POST['price']) || !isset($_FILES["img"]) ) 
			{
				echo '<h3 class="add-bottom">Add Product</h3>';
				echo '<form action="' . $_SERVER['PHP_SELF']  . '" enctype="multipart/form-data" method="post">';
				echo '	<p>Name:<br /><input type="text" name="name" /></p>';
				echo '	<p>Description:<br /><textarea name="desc"></textarea></p>';
				echo '	<p>Category:<br />';
				echo '		<select name="cat">';
				echo '			<option>accessories</option>';
				echo '			<option>bags</option>';
				echo '			<option>blouses</option>';
				echo '			<option>dress</option>';
				echo '			<option>jackets</option>';
				echo '			<option>pants</option>';
				echo '			<option>skirts</option>';
				echo '			<option>underwears</option>';	
				echo '		</select></p>';
				echo '	<p>Price:<br /><input type="text" name="price" /></p>';
				echo '	<p>Stock: <input type="number" name="stock" /></p>';
				echo '	<p>Image: (for best Image proportions, use 620 x 465 resolutions)<br /><input type="file" name="img" /></p>';
				echo '	<input type="submit" value="Upload" name="submit" />';
				echo '</form>';
			}
			
			else
			{	
				$name	=	stripslashes($_POST['name']);
				$desc	=	stripslashes($_POST['desc']);
				$cat	=	stripslashes($_POST['cat']);
				$price	=	stripslashes($_POST['price']);
				$stock	=	stripslashes($_POST['stock']);
				$date	=	time();
				
				$filename		=	stripslashes($_FILES["img"]["name"]);
				$filetype		=	$_FILES['img']['type'];
				$filesize		=	$_FILES['img']['size'];
				$temp			=	$_FILES['img']["tmp_name"];
				$path			=	'../images/temp/img_temp.jpg';
				$thumb_path		=	'../images/temp/thumb_temp.jpg';
				
				if(($filetype=='image/jpeg')||($filetype=='image/pjpeg')||($filetype=='image/gif')||($filetype=='image/png'))
				{
					list($width, $height) = getimagesize($temp);
					
					if($width > 1)
					{
						if		($filetype=='image/jpeg')	{	$image	=	imagecreatefromjpeg($temp);	}
						else if	($filetype=='image/pjpeg')	{	$image	=	imagecreatefromjpeg($temp);	}
						else if	($filetype=='image/png')	{	$image	=	imagecreatefrompng($temp);	}
						else if	($filetype=='image/gif')	{	$image	=	imagecreatefromgif($temp);	}
						else								{	echo	'INVALID FILE TYPE';	}
						
						$old_width  = imagesx($image);
						$old_height = imagesy($image);
						
						if(($old_width >= 619) || ($old_height >= 464))
						{	
							$new_width	=	620;
							$new_height	=	465;
							$new		=	imagecreatetruecolor($new_width, $new_height);
							
							imagecopyresampled($new, $image, 0, 0, 0, 0, $new_width, $new_height, $old_width, $old_height);
							
							ob_start();
							imagejpeg($new, $path, 100);
							
							$new_thumb_width	=	420;
							$new_thumb_height	=	315;
							$new_thumb		=	imagecreatetruecolor($new_thumb_width, $new_thumb_height);
							
							imagecopyresampled($new_thumb, $image, 0, 0, 0, 0, $new_thumb_width, $new_thumb_height, $old_width, $old_height);
							
							ob_start();
							imagejpeg($new_thumb, $thumb_path, 100);
							
						}
						
						else
						{
							echo 'Upload a bigger image';
							break;
						}
						
						$dir		=	'/images/products/' . $cat . '_' . $date.'.jpg';
						$dir_thumb	=	'/images/products/' . $cat . '_' . $date.'_thumb.jpg';
						
						$name	=	mysql_real_escape_string($name);
						$desc	=	mysql_real_escape_string($desc);
						$cat	=	mysql_real_escape_string($cat);
						$price	=	mysql_real_escape_string($price);
						
						mysql_query("INSERT INTO products(name, description, category, price, date, thumb, image, stocks)
												VALUES('$name', '$desc', '$cat', '$price', '$date', '$dir_thumb', '$dir', '$stock')") or die(mysql_error());
												
						copy($path, $_SERVER["DOCUMENT_ROOT"] . $dir);
						copy($thumb_path, $_SERVER["DOCUMENT_ROOT"] . $dir_thumb);
						
						if(file_exists($dir))
						{
							$handle = fopen($path, 'r');
							fclose($handle);
							unlink($path);
						}
						
						if(file_exists($dir_thumb))
						{
							$handle = fopen($thumb_path, 'r');
							fclose($handle);
							unlink($thumb_path);
						}
						
						echo 'Upload Success<br /> <a href="' . $_SERVER['PHP_SELF'] . '">Upload More</a>';
						
					}
				
				}
			}
		?>
	</div>

		<hr style="border:0px" /><?php include '../footer.php' ?>

	</div>


<!-- End Document
================================================== -->
</body>
</html>