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
	$EmailToRemove = $_POST["email"];
	$query = "DELETE FROM EmailAddresses WHERE EmailAddresses.Email = '$EmailToRemove'";
	$result = $con -> query($query); //mysqli_query($con, $query);
	$rows = $con -> affected_rows;
	if ($rows > 0) {
		echo "<div class='form'>
		  <h3>Success: $EmailToRemove was removed from your account.</h3>";
	} else {
		echo "<div class='form'>
		  <h3>There was an error removing $EmailToRemove from your account.</h3>";
	}
	goManage(NULL);
	?>
	</div>
</body>

</html>