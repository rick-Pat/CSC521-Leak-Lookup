<?php
// Enter your host name, database username, password, and database name.
// If you have not set database password on localhost then set empty.
$con = mysqli_connect("localhost", "leak", "leak@2021", "leak");
// Check connection
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

include("utilities.php");

$currFile =  basename($_SERVER["PHP_SELF"], '.php');

session_start();

// set up data
if (isset($_SESSION["Account_ID"])) {
	$Account_ID = $_SESSION['Account_ID'];
	$query = "SELECT * FROM `Account` WHERE Account_ID=$Account_ID";
	$result = mysqli_query($con, $query);
	$UserData = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$User_Security_Level = $UserData["Security_Level"];
	$User_Account_ID = $UserData["Account_ID"];
	$User_Username = $UserData["Username"];
	$User_Primary_Email = $UserData["Primary_Email"];
	$User_Password = $UserData["Password"];
	if ($User_Security_Level > 1) {
		$secText = " (".getSecurityText($User_Security_Level).")";
	} else {
		$secText = "";
	}
	echo "<h1 class='header-title'>Leak Lookup</h1>";
	echo "<h2 class='header-main'>$User_Username$secText <a href='logout.php'>[Logout]</a></h2>";
	echo "<h2 class='logout-button'><a href='dashboard.php'>[Home]</a>";
	echo " <a href='manage.php'>[Manage]</a>";
	if ($User_Security_Level > 1) {
		echo " <a href='admin_panel.php'>[Admin Panel]</a>";
	}
	echo "</h2>";
	if ($User_Security_Level <= 0) {
		if (session_destroy()) {
			header("Location: disabled.php");
			exit;
		}
	}
}



// redirect users

// visitor pages
$userRedirect = array("registration", "login", "disabled");

if (isset($_SESSION["Account_ID"])) {
	// if they're logged in and go to a visitor page, redirect to home
	foreach ($userRedirect as $redirectPage) {
		if ($currFile == $redirectPage) {
			header("Location: dashboard.php");
			break;
		}
	}
} else {
	$Redirect = true;
	// if they're logged out and go to a non-visitor page, redirect to login
	foreach ($userRedirect as $redirectPage) {
		if ($currFile == $redirectPage) {
			$Redirect = false;
			break;
		}
	}
	if ($Redirect) {
		header("Location: login.php");
	}
}

// redirect non-admins away from admin-only pages
$adminPages = array("admin_panel");

foreach ($adminPages as $redirectPage) {
	if ($User_Security_Level < 2 and $currFile == $redirectPage) {
		header("Location: dashboard.php");
		break;
	}
}
