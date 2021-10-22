<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<title>Account Management | Leak Lookup</title>
	<link rel="stylesheet" href="style.css" />
</head>

<body>
	<?php
	include("auth_main.php");
	$Username = $row["Username"];
	$query = "SELECT * FROM `EmailAddresses` WHERE Account_ID='$Account_ID'";
	$result = mysqli_query($con, $query);
	$NumEmails = mysqli_num_rows($result);
	?>
	<form class="form">
		<h1 class="login-title">Account Management</h1>
		<h3>Make changes to your account.</h3>
	</form>
	<form class="form" action="new_email.php" method="post">
		<h1 class="login-title">Add New Email Address</h1>
		<input type="email" class="login-input" name="email" placeholder="New Email Address" required>
		<input type="submit" name="submit" value="Add" class="form-button">
	</form>
	<form class="form" action="remove_email.php" method="post">
		<h1 class="login-title">Remove Email Address</h1>
		<?php
		if ($NumEmails > 0) {
			echo '<select email Name="email">';
			if ($result) {
				while ($row = $result->fetch_assoc()) {
					$email = $row['Email'];
					echo "<option value='$email'>$email</option>";
				}
				echo '<input type="submit" name="Email" value="Remove" class="form-button">';
			}
		} else {
			echo "<h3>You have no emails to remove.</h3>";
		}
		?>
	</form>
	<form class="form" action="change_username.php" method="post">
		<h1 class="login-title">Change Username</h1>
		<input type="text" class="login-input" name="username" placeholder="New Username" required />
		<input type="submit" name="submit" value="Change" class="form-button">
	</form>
	<form class="form" action="change_password.php" method="post">
		<h1 class="login-title">Change Password</h1>
		<input type="password" class="login-input" name="old_password" placeholder="Current Password" required>
		<input type="password" class="login-input" name="new_password" placeholder="New Password" required>
		<input type="password" class="login-input" name="new_password_again" placeholder="Confirm Password" required>
		<input type="submit" name="submit" value="Change" class="form-button">
	</form>
	<? goHome(true) ?>
	<br><br><br><br><br>
</body>

</html>