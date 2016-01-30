<?php  
//function to check if a product exists
function productExists($product_id) {
    //use sprintf to make sure that $product_id is inserted into the query as a number - to prevent SQL injection
    $sql = sprintf("SELECT * FROM products WHERE id = %d;", $product_id); 
    
    return mysql_num_rows(mysql_query($sql)) > 0;
}


//the product id from the URL 
$product_id = isset($_GET['id']) ? $_GET['id'] : "";
//the action from the URL 
$action = isset($_GET['action']) ? $_GET['action'] : "";

//if there is an product_id and that product_id doesn't exist display an error message
if($product_id && !productExists($product_id)) {
    die("Error. Product Doesn't Exist");
}

switch($action) { //decide what to do 

    case "add":
    	if (!isset($_SESSION['cart'][$product_id])) {
    		$_SESSION['cart'][$product_id] = 1;
    	}
        else $_SESSION['cart'][$product_id]++; //add one to the quantity of the product with id $product_id 
    break;

    case "remove":
        $_SESSION['cart'][$product_id]--; //remove one from the quantity of the product with id $product_id 
        if($_SESSION['cart'][$product_id] == 0) unset($_SESSION['cart'][$product_id]); //if the quantity is zero, remove it completely (using the 'unset' function) - otherwise is will show zero, then -1, -2 etc when the user keeps removing items. 
    break;

    case "empty":
        unset($_SESSION['cart']); //unset the whole cart, i.e. empty the cart. 
    break;

}


if (isset($_SESSION['cart'])) {
 	if($_SESSION['cart']) { //if the cart isn't empty
//show the cart

 	$cart = 0;
 	foreach ($_SESSION['cart'] as $product_id => $quantity) {
 		$cart = $cart + $quantity;
 	}
	echo '<li class="has-sub"><a><span class="glyph">&#x003c;</span>Cart ( '.$cart.' )</a>';
    echo '<ul>';

    //iterate through the cart, the $product_id is the key and $quantity is the value
    $total = 0;
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
            $total = $total + $line_cost; //add to the total cost

            //show this information in table cells
            //along with a 'remove' link next to the quantity - which links to this page, but with an action of remove, and the id of the current product
      		echo "<li><a>$name x $quantity = P$line_cost <a href=\"$_SERVER[PHP_SELF]?action=remove&id=$product_id\" style=\"display:inline;background:none;margin:0;padding:0;\">Remove</a></a></li>";
      		$cart = $cart + $quantity;
        }

    }

    //show the total
    echo "<li><a>Total: $total</a></li>";
	
	
	echo "<li><a href=\"checkout.php\">Checkout</a></li>";

    //show the empty cart link - which links to this page, but with an action of empty. A simple bit of javascript in the onlick event of the link asks the user for confirmation
	
    echo "<li><a href=\"$_SERVER[PHP_SELF]?action=empty\" onclick=\"return confirm('Are you sure?');\">Empty Cart</a></li>";
    echo "</ul></li>";

} else{
//otherwise tell the user they have no items in their cart
    echo '<li class="has-sub"><a><span class="glyph">&#x003c;</span>Cart (0)</a>';
    echo '<ul>';
    echo '	<li><a>No items in cart.</a></li>';
    echo '</ul>';
    echo "</li>";
}
 } else{
//otherwise tell the user they have no items in their cart
    echo '<li class="has-sub"><a><span class="glyph">&#x003c;</span>Cart (0)</a>';
    echo '<ul>';
    echo '	<li><a>No items in cart.</a></li>';
    echo '</ul>';
    echo "</li>";
}

?>