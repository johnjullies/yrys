<?php include 'db_config.php' ?>
<?php include 'check_login.php' ?>
<?php
			if(isset($_GET['id'])) 
			{
				$id			=	$_GET['id'];
				$select		=	mysql_query("SELECT * FROM products WHERE id = '$id'");
				$fetch		=	mysql_fetch_array($select);

				echo '<h3 class="add-bottom">Edit Product</h3>';
				echo '<form action="' . $_SERVER['PHP_SELF']  . '" enctype="multipart/form-data" method="post">';
				echo '	<p>Name:<br /><input type="text" name="name" value="'.$fetch['name'].'" /></p>';
				echo '	<p>Description:<br /><textarea name="desc">'.$fetch['description'].'</textarea></p>';
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
				echo '	<p>Price:<br /><input type="text" name="price" value="'.$fetch['price'].'" /></p>';
				echo '	<p>Stock: <input type="number" name="stock" value="'.$fetch['stocks'].'" /></p>';
				echo '	<p>Image: (for best Image proportions, use 620 x 465 resolutions)<br /><input type="file" name="img" /></p>';
				echo '	<input type="submit" value="Save" name="submit" />';
				echo '</form>';
			}
			
			if (isset($_POST['submit']))
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
				$path			=	'images/temp/img_temp.jpg';
				$thumb_path		=	'images/temp/thumb_temp.jpg';
				
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
						
						mysql_query("UPDATE products SET name = '$name', description = '$desc', category = '$cat', price = '$price', date = '$date', thumb = '$dir_thumb', image = '$dir', stocks = '$stock' WHERE id = '$id'");						
						
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
						
						echo 'Edit Success<br />';
						
					}
				
				}
			}
		?>