<?php include 'db_config.php' ?>
<?php include 'check_login.php' ?>
<?php if (isset($_SESSION['username'])) {
	header("Location:/");
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
	<title>Y.R.Y.S. | Login / Register</title>
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
	<div class="container">
	
	<div id="header"></div>

	<?php include 'menu.php' ?>

	<?php
		$error = "";

		if (isset($_POST['login'])) {
			$username = addslashes(strip_tags($_POST['username']));
			$password = addslashes(strip_tags($_POST['password']));
			$login = mysql_query("SELECT * FROM users WHERE username = '$username'"); // filtering the database and compare if the username match the variable inputed in the username field.
			
				if (mysql_num_rows($login) != 0) {
					// code to login
					while ($row = mysql_fetch_assoc($login)) {
						$dbpassword = $row['password'];
						$password = md5($password);

						if ($password != $dbpassword) {
							$error = '<div id="error">Incorrect username or password</div>';
						}
						else {
							$_SESSION['username'] = $username;
							if ($username === "admin") {
								header("Location:/admin");
								exit();
							} else {
								header("Location:index.php");
								exit();
							}
						}
					}
				}
				else {
					$error = '<div id="error">That user does not exist!</div';
				}
		} 

		if (isset($_POST['register'])) {
			$username = addslashes(strip_tags($_POST['username']));
			$password = addslashes(strip_tags($_POST['password']));
			$confirm = addslashes(strip_tags($_POST['confirm']));
			$fname = addslashes(strip_tags($_POST['fname']));
			$lname = addslashes(strip_tags($_POST['lname']));
			$email = addslashes(strip_tags($_POST['email']));
			$date = date("Y-m-d");

			$errors = array();

			# check username & password length
			if (strlen($username) < 6 || strlen($password) < 6) {
				$errors[] = '<div id="error">Username or password too short (must be at least 6 characters).</div>';
			} else {
				$check = mysql_query("SELECT * FROM users WHERE username='$username'");
				if (mysql_num_rows($check) >= 1) {
					$errors[] = '<div id="error">Username already taken.</div>';
				}
			}

			# check confirm password
			if ($confirm === $password) {
				# encrypt password
				$password = md5($password);
			} else {
				$errors[] = '<div id="error">Passwords do not match.</div>';
			}

			if (!empty($errors)) {
				foreach ($errors as $error) {
					echo $error, '<br>';
				}
			}
			else {
				$register = mysql_query("INSERT INTO users VALUES('', '$username', '$password', '$fname', '$lname', '$email', '$date')");
				echo '<div id="good">You have been registered successfully!</div>';
			}

		}
	?>

	<?php  
		if (isset($_GET['error'])) {
			$error = "You need to sign in to continue";
			echo "<p> $error </p>";
		} else {
			echo "<p> $error </p>";
		}
	?>

	<div class="sixteen columns clearfix">
		<div class="eight columns alpha">
			<h3 class="add-bottom">Sign in</h3>
			<form action="" method="post" enctype="multipart/form-data">
				<input type="text" name="username" size="40" maxlength="16" placeholder="Username" autofocus required>
				<input type="password" name="password" size="40" maxlength="32" placeholder="Password" required>
				<input type="submit" value="Login" name="login">
			</form>
		</div>
		<div class="eight columns omega">
			<h3 class="add-bottom">New user?</h3>
			<form action="" method="post" enctype="multipart/form-data">
				<input type="text" name="fname" size="40" maxlength="32" placeholder="First Name" required>
				<input type="text" name="lname" size="40" maxlength="32" placeholder="Last Name" required>
				<input type="email" name="email" size="40" maxlength="32" placeholder="E-mail" required>
				<input type="text" name="username" size="40" maxlength="32" placeholder="Username" required>
				<input type="password" name="password" size="40" maxlength="32" placeholder="Password" required>
				<input type="password" name="confirm" size="40" maxlength="32" placeholder="Confirm Password" required>
				<input type="submit" value="Register" name="register">
			</form>
		</div>
	</div>

	<hr style="border:0px;" /><?php include 'footer.php' ?>

	</div>



</body>
</html>