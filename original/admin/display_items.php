<?php
	echo '<div class="container">';
	echo '	<div class="two-thirds column">';
	echo '		<img src="' . $fetch['image'] . '" class="scale-with-grid" onclick="lightbox(' .  $fetch['id'] . ')">';
	echo '	</div>';
	echo '	<div class="one-third column">';
	echo '		<h5><a onclick="lightbox(' .  $fetch['id'] . ')">' .  $fetch['name'] . '</a></h5>';
	echo '		<p>' .  $fetch['description'] . '</p>';
	echo '		<div class="product-footer">';
	echo '			<h5>P' . $fetch['price'] . '.00</h5>';
	echo '			<button onclick="edit_lightbox('.$fetch['id'].')"><span class="glyph">&#xe194;</span>Edit</button>
					<button onclick="delete_lightbox('.$fetch['id'].')"><span class="glyph">&#xe20a;</span>Delete</button>';
	echo '		</div>';
	echo '	</div>';
	echo '</div>';
	echo '<br />';
	
	// if(mysql_num_rows(mysql_query("SELECT * FROM products WHERE category='$category'")) >= 4)
	$select = mysql_query("SELECT * FROM products WHERE category='$category' ORDER BY id desc LIMIT 1, 3") or die(mysql_error());
	
	while($fetch = mysql_fetch_array($select))
	{
		echo '<div class="one-third column">';
		echo '	<img src="' . $fetch['thumb'] . '" class="scale-with-grid" onclick="lightbox(' .  $fetch['id'] . ')">';
		echo '	<h5><a onclick="lightbox(' .  $fetch['id'] . ')">' . $fetch['name'] . '</a></h5>';
	
		if(strlen($fetch['description']) > 250)
		{
			$stringcut = substr($fetch['description'], 0, 250);
			$desc = substr($stringcut, 0, strrpos($stringcut, ' ')).'...'; 
		}
		
		echo '	<p>' . $desc . '</p>';
		echo '		<div class="product-footer">';
		echo '			<h5>P' . $fetch['price'] . '.00</h5>';
		echo '			<button onclick="edit_lightbox('.$fetch['id'].')"><span class="glyph">&#xe194;</span>Edit</button>
					<button onclick="delete_lightbox('.$fetch['id'].')"><span class="glyph">&#xe20a;</span>Delete</button>';
		echo '		</div>';
		echo '</div>';			
	}
	
	echo '<a class="view-more" href="">View more</a>';
	echo '<hr>';
?>