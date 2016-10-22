<?php
if (isset($_POST['username'], $_POST['password'])) {
	if (!empty($_POST['username']) && !empty($_POST['password'])) {
		require_once("./mysql_connect.php");
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$password = mysqli_real_escape_string($db, md5($_POST['password']));
		$query = "SELECT * FROM users WHERE username = \"". $username . "\" AND password = \"". $password. "\" AND (authorized = 0 OR authorized = 1 OR authorized = 2 OR authorized = 3 OR authorized = 10)";
		$result = $db->query($query);
		if ($result->num_rows) {
			$row = $result->fetch_assoc();
			if ($row['authorized'] == "0") {
				header('Location: ./index.php?error=not_authorized');
				exit;
			}
			session_start();
			$_SESSION['username'] = $username;
			$_SESSION['userid'] = $row['userid'];
			$_SESSION['authorized'] = $row['authorized'];
			$date = date("Y-m-d H:i:s");
			file_put_contents("/srv/ts-yt-dl/".$row['userid']."/user.log", "[$date]\tUser logged into account.\n", FILE_APPEND);
			header('Location: ./home.php');
		} else {
			header('Location: ./index.php?error=invalid_user');
		}
	} else {
		header('Location: ./index.php?error=empty_field');
	}
}
?>
