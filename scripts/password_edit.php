<?php
include("./header.php");
require_once("./mysql_connect.php");
echo "<div id=\"content\">";
if (isset($_POST['old_password']) && isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
	if (!empty($_POST['old_password']) && !empty($_POST['new_password']) && !empty($_POST['confirm_password'])) {
		if (strtolower($_SESSION['username']) != "demo") {
			$old_password = md5($_POST['old_password']);
			$password_match = "SELECT password FROM users WHERE userid = $userid";
			$check_result = $db->query($password_match);
			$password = $check_result->fetch_assoc();
			$check_num = $check_result->num_rows;
			if ($password['password'] != $old_password) {
				echo "<p class=\"error\">The password you entered did match the existing one.</p>";
			} else {
				$new_password = md5($_POST['new_password']);
				$confirm_password = md5($_POST['confirm_password']);
				if ($new_password == $confirm_password) {
					$query_password = "UPDATE users SET password = \"$new_password\" WHERE userid = $userid";
					$result = $db->query($query_password);
					if ($result) {
						echo "<b>Password changed.</b>";
						header("Location: ./account.php?status=Password Changed");
					} else {
						echo "<b>Error occured, please try again.</b>";
					}
				} else {
					echo "<p class=\"error\">New passwords entered did not match.</p>";
				}
			}
		} else {
			echo "This account cannot be altered.";
		}
	} else {
		echo "<p class=\"error\">Empty passwords are not allowed.</p>";
	}
}
	if (strtolower($_SESSION['username']) != 'demo') {
		echo "<div class=\"user_info\">
							<h3 class=\"user_header\">Change password</h3>
							<form action=\"".$_SERVER['PHP_SELF']."\" method=\"POST\">
								Old Password:<input type=\"password\" name=\"old_password\"/><br />
								New Password:<input type=\"password\" name=\"new_password\"/><br />
								Confirm Password:<input type=\"password\" name=\"confirm_password\"/><br />
								<input type=\"submit\" value=\"Save Changes\"/>
								<h5 class=\"user_h5\"><a href=\"account.php\">Cancel</a></h5>
							</form>
						</div>
					</div>";
	} else {
		echo "This account cannot be altered.";
	}
include("footer.php");
?>
