<?php include 'db_config.php' ?>
<?php include 'check_login.php' ?>
<?php
	
	$id			=	$_GET['id'];
	$select		=	mysql_query("SELECT * FROM products WHERE id = '$id'");
	$fetch		=	mysql_fetch_array($select);
	
	echo '<div class="container">';
	echo '	<div class="two-thirds column">';
	echo '		<img src="' . $fetch['image'] . '" class="scale-with-grid">';
	echo '	</div>';
	echo '	<div class="one-third column">';
	echo '		<h5><a>' .  $fetch['name'] . '</a></h5>';
	echo '		<p>' .  $fetch['description'] . '</p>';
	echo '		<div class="product-footer">';
	echo '			<h5>P' . $fetch['price'] . '.00</h5>';
	if (!loggedin()) {
				echo " <a href=\"login.php?error=1\"><button><span class=\"glyph\">&#x003c;</span>Add to cart</button></a>";
			} else {
				echo " <a href=\"$_SERVER[PHP_SELF]?action=add&id=$fetch[id]\"><button><span class=\"glyph\">&#x003c;</span>Add to cart</button></a>";
			}
	echo '		</div>';
	echo '	</div>';
	echo '</div>';
	echo '<br />';
?>