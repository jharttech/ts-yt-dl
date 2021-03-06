<!DOCTYPE html>
<html>
<head>
	<title>TimeShifter-YouTube-DownLoader</title>
	<link rel="stylesheet" type="text/css" href="./style/main.css">
	<link rel="stylesheet" href="./style/login.css">
</head>
<div id="banner">
	<h1>TS-YT-DL</h1>
</div>
<body>
	<div id="content">
	<?php
	session_start();
	if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
		header("Location: ./home.php");
	}
	require_once('./mysql_connect.php');
	$scan_users = "SELECT username as total FROM users";
	$result = $db->query($scan_users);
	if ($result->num_rows == 0) {
		header("Location: ./setup.php");
		exit();
	}
	echo "<h2 class=\"h2_title\">Sign in</h2>";
	if (isset($_GET['error'])) {
		if ($_GET['error'] == "invalid_user") {
			echo "<p class=\"error\">Invalid username and/or password.</p>";
		} elseif ($_GET['error'] == "nologin") {
			echo "<p class=\"error\">You are not logged in.</p>";
		} elseif ($_GET['error'] == "empty_field") {
			echo "<p class=\"error\">Plese enter a valid username and password.</p>";
		} elseif ($_GET['error'] == "not_authorized") {
			echo "<p class=\"error\">Your account is pending authorization.</p>";
		}
	}
	?>
	<div class="login_box">
			<form action="login.php" method="POST">
				<input class="login_input" type="text" name="username" placeholder="Username"/>
				<input class="login_input" type="password" name="password" placeholder="Password"/>
				<input class="login_submit" type="submit" value="Sign In">
			</form>
			<a class="forgot_password" href="./forgot_password.php">Forgot Password</a>
		</div>
	<h3 class="h3_title"><a href="./sign_up.php">Sign up</a></h3>
	</div>
</body>
<?php
include("footer.php");
?>
