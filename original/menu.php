<?php  

echo '<div id="cssmenu" class="add-bottom">
		  <ul>
		     <li><a href="/"><span class="glyph">&#x0021;</span>Home</a></li>
		     <li class="has-sub"><a><span class="glyph">&#xe015;</span>Products</a>
		        <ul>
		           <li><a href="#1">Accessories</a></li>
		           <li><a href="#2">Bags</a></li>
		           <li><a href="#3">Blouse</a></li>
		           <li><a href="#4">Dress</a></li>
		           <li><a href="#5">Jackets</a></li>
		           <li><a href="#6">Pants</a></li>
		           <li><a href="#7">Skirts</a></li>
		           <li><a href="#8">Underwear</a></li>
		        </ul>
		     </li>';
		    
		     	if (loggedin()) {
		     		echo '<li class="has-sub"><a><span class="glyph">&#xe15f;</span>'.$_SESSION['username'].'</a>';
		     		echo '<ul><li><a href="logout.php">Logout</a></li></ul></li>';
		     	} else {
		     		echo '<li><a href="login.php"><span class="glyph">&#xe15f;</span>Login / Register</a></li>';
		     	}
		     
		    include 'cart.php';
echo '		  </ul>
		</div>';

?>