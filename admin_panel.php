<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<title>Admin Panel | Leak Lookup</title>
	<link rel="stylesheet" href="style.css" />
</head>

<?php
include("auth_main.php");
?>
<form class="form">
	<h1 class="login-title">Admin Panel</h1>
	<h3>Manage user accounts below your security level. You: <?= $User_Security_Level ?> (<?= getSecurityText($User_Security_Level) ?>)</h3>
</form>
<form class="form" action="change_security_lvl.php" method="post">
	<h1 class="login-title">Update Security Level</h1>
	<input type="text" class="login-input" name="target_user" placeholder="Username" required>
	<select security_lvl Name='security_lvl'>
		<?php
		for ($i = 0; $i < $User_Security_Level; $i++) {
			$text = getSecurityText($i);
			echo "<option value=$i>$i ($text)</option>";
		}
		?>
	</select>
	<br><br>
	<input type="checkbox" id="use_acc_id2" name="use_acc_id2" value="use_acc_id2">
	<label for="use_acc_id2">Use Account ID instead</label><br>
	<input type="submit" name="submit" value="Update" class="form-button">
</form>

<form class="form" action="change_account.php" method="post">
	<h1 class="login-title">Login</h1>
	Login to another user account for troubleshooting. <br><br>
	<input type="text" class="login-input" name="target_user" placeholder="Username" required>
	<input type="checkbox" id="use_acc_id" name="use_acc_id" value=true>
	<label for="use_acc_id">Use Account ID instead</label><br>
	<input type="submit" name="submit" value="Login" class="form-button">
</form>

<? goHome(true); ?>
<form class="form">
	<h1 class="login-title">100 newest accounts</h1>
	<?php
	$query = "SELECT T.AUTO_INCREMENT FROM information_schema.TABLES T WHERE T.TABLE_SCHEMA = 'leak' AND T.TABLE_NAME = 'Account'";
	$result = $con->query($query);
	$array = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$auto_incr = $array["AUTO_INCREMENT"] - 1;
	$stop = $auto_incr - 100;
	for ($i = $auto_incr; $i > $stop; $i--) {
		$query = "SELECT * FROM `Account` WHERE Account_ID=$i";
		$result = $con->query($query);
		$TargetArray = mysqli_fetch_array($result, MYSQLI_ASSOC);
		$user = $TargetArray["Username"];
		$SecLvl = getSecurityText($TargetArray["Security_Level"]);
		if ($TargetArray["Security_Level"] == NULL and $i > 0) {
			echo "$i - NULL/DELETED<br>";
		} elseif ($i > 0) {
			echo "$user - $i ($SecLvl)<br>";
		} else {
			break;
		}
	}
	?>
</form>

</html>