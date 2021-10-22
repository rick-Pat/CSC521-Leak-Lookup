<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Home | Leak Lookup</title>
	<link rel="stylesheet" href="style.css" />
</head>
?????
<?php
include("auth_main.php");
?>

<body>
	<form class="form" action="search.php" method="post">
		<h1 class="login-title">Home</h1>
		<h3>Choose an email to search:</h3>
		<select email Name='email'>
			<?php
			echo "<option value='$User_Primary_Email'>$User_Primary_Email (Primary)</option>";
			$query = "SELECT * FROM `EmailAddresses` WHERE Account_ID='$User_Account_ID'";
			$result = mysqli_query($con, $query);
			if ($result) {
				while ($row = $result->fetch_assoc()) {
					$email = $row['Email'];
					echo "<option value='$email'>$email</option>";
				}
			}
			?>
			<input type="submit" name="submit" value="Search" class="form-button">
	</form>
	<form class="form">
	<h1 class="login-title">Useful Links</h1>
		<a href='manage.php'>Add or remove an email</a><br><br>
		<a href='manage.php'>Change password</a><br><br>
		<a href='manage.php'>Change username</a><br><br>
	</form>
</body>

</html>