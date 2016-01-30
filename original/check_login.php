<?php  

session_start(); // starting the session
// login check function
function loggedin() {
	if (isset($_SESSION['username']) || isset($_COOKIE['username'])) { // in this field we used Session username as our session cookies
		$loggedin = true; // set the session username
		return $loggedin;
	}
}

?>