<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<title>Registration | Leak Lookup</title>
	<link rel="stylesheet" href="style.css" />
</head>

<body>
	<?php
	include("auth_main.php");

	if (isset($_REQUEST['username'])) {
		$username = stripslashes($_REQUEST['username']);
		$username = mysqli_real_escape_string($con, $username);
		$email    = stripslashes($_REQUEST['email']);
		$email    = mysqli_real_escape_string($con, $email);
		$password = stripslashes($_REQUEST['password']);
		$password = mysqli_real_escape_string($con, $password);
		$create_datetime = date("Y-m-d H:i:s");

		// check if all fields are filled (even though the form marked them as required)
		if ($username == NULL or $email == NULL or $password == NULL) {
			echo "<div class='form'>
			  <h3>Please fill all fields.</h3><br/>
			  <a href='registration.php'>Click here to go back.</a>
			  </div>";
			exit;
		}

		// check if the username is in use
		$query    = "SELECT * FROM `Account` WHERE Username='$username'";
		$result = mysqli_query($con, $query) or die();
		$rows = mysqli_num_rows($result);
		if ($rows > 0) {
			echo "<div class='form'>
			  <h3>That username is in use. Please choose a different one.</h3><br/>
			  <a href='registration.php'>Click here to go back.</a>
			  </div>";
			exit;
		}

		$sanitized_email = filter_var($email, FILTER_SANITIZE_EMAIL);
		$validate_email = filter_var($sanitized_email, FILTER_VALIDATE_EMAIL);

		if ($validate_email) {
			// check if email is in-use
			$query = "SELECT * FROM `EmailAddresses` WHERE Email='$sanitized_email'";
			$result = mysqli_query($con, $query) or die();
			$rows = mysqli_num_rows($result);
			if ($rows > 0) {
				echo "<div class='form'>
			  <h3>$sanitized_email is in use. Please choose a different one.</h3><br/>
			  <a href='registration.php'>Click here to go back<./a>
			  </div>";
				exit;
			}
		} else {
			echo "<div class='form'>
			<h3>$sanitized_email is not a valid email. Please try again.</h3><br/>
			<a href='registration.php'>Click here to go back.</a>
			</div>";
			exit;
		}

		// insert into Account
		$query = "INSERT into `Account`
                     VALUES (NULL, '$username', '" . ($password) . "', '$sanitized_email', 1,'$create_datetime')";
		$result = mysqli_query($con, $query);
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		$insertion_rows = $con->affected_rows;

		// insert into EmailAddresses
		$query = "INSERT into `EmailAddresses` VALUES ('$sanitized_email', $New_ID, '$create_datetime', NULL)";
		$result = mysqli_query($con, $query);		

		// verify successful insertion
		//$query = "SELECT Email FROM EmailAddresses WHERE Email='$sanitized_email' AND EXISTS ( SELECT Primary_Email FROM Account WHERE Primary_Email='$sanitized_email')";
		$query = "SELECT * FROM Account WHERE Primary_Email='$sanitized_email'";
		$result = $con->query($query);
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		$rows = mysqli_num_rows($result);

		if ($rows > 0) {
			$Account_ID = $row["Account_ID"];
			$_SESSION['Account_ID'] = $Account_ID;
			echo "<div class='form'>
                  <h3>You are registered successfully. Welcome, $username!</h3><br/>
                  <a href='dashboard.php'>Click here to continue.</a>
                  </div>";
			exit;
		} else {
			echo "<div class='form'>
                  <h3>There was a problem creating your account.</h3><br/>
                  <a href='registration.php'>Click here to go back</a>
                  </div>";
			exit;
		}
	} else {
	?>
		<form class="form" action="" method="post">
			<h1 class="login-title">Registration</h1>
			<input type="text" class="login-input" name="username" placeholder="Username" required />
			<input type="email" class="login-input" name="email" placeholder="Email Address" required>
			<input type="password" class="login-input" name="password" placeholder="Password" required>
			<input type="submit" name="submit" value="Register" class="login-button"><br>
			Already have an account? <a href='login.php'>Click here to login</a>
		</form>
	<?php
	}
	?>
</body>

</html>