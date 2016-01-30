<?php include 'db_config.php' ?>
<?php include 'check_login.php' ?>
<?php  
	if (isset($_GET['deleteid'])) {
		$id = $_GET['deleteid'];
		$sql = mysql_query("SELECT * FROM products WHERE id = $id");
		while ($row = mysql_fetch_array($sql)) {
			$thumb = $row['thumb'];
			$image = $row['image'];
		}

		# delete images
		unlink($thumb);
		unlink($image);

		# delete from db
		mysql_query("DELETE FROM products WHERE id = $id");

		echo "Deleted successfully.";
	} else {
		
		$id			=	$_GET['id'];
		$select		=	mysql_query("SELECT * FROM products WHERE id = '$id'");
		$fetch		=	mysql_fetch_array($select);

		echo '<div class="container">';
		echo '	<div class="sixteen columns">';
		echo '		<h3 class="add-bottom">Confirm</h3>';
		echo '		<p>Do you really want to delete product ID no.'.$id.' ?</p>';
		echo '		<p><a href="delete.php?deleteid='.$id.'"><button>Yes</button></a>';
		echo '		<button onclick="closeLightbox()">No</button></p>';
		echo '	</div>';
		echo '</div>';
	}

?>