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
	$EmailToAdd = $_POST['email'];
	$Account_ID = $_SESSION['Account_ID'];
	$create_datetime = date("Y-m-d H:i:s");

	$sanitized_email = filter_var($EmailToAdd, FILTER_SANITIZE_EMAIL);
	$validate_email = filter_var($sanitized_email, FILTER_VALIDATE_EMAIL);

	$query    = "SELECT * FROM `Account` WHERE Primary_Email='$sanitized_email'";
	$result = mysqli_query($con, $query);
	$rows = mysqli_num_rows($result);

	if ($validate_email and $rows == 0) {
		// email is the primary key so I don't need to check if it's a duplicate.
		$query = "INSERT into `EmailAddresses` VALUES ('$sanitized_email', $Account_ID, '$create_datetime', NULL)";
		$result = mysqli_query($con, $query);

		if ($result) {
			echo "<div class='form'>
		  <h3>Success! $sanitized_email was added to your account.</h3><br/>";
		} else {
			echo "<div class='form'>
		  <h3>$EmailToAdd is already used.</h3><br/>";
		}
	} elseif ($sanitized_email == $User_Primary_Email) {
		echo "<div class='form'>
		<h3>$EmailToAdd is your primary email.</h3><br/>";
	} elseif ($rows > 0) {
		echo "<div class='form'>
		<h3>$EmailToAdd is already used.</h3><br/>";
	} else {
		echo "<div class='form'>
		<h3>$EmailToAdd is not a valid email. Please try again.</h3><br/>";
	}
	goManage(NULL);
	?>
	</div>
</body>

</html>