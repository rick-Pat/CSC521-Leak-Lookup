<?php

function getSecurityText($lvl)
{
	if ($lvl == 0) {
		return "Disabled";
	} elseif ($lvl == 1) {
		return "User";
	} elseif ($lvl == 2) {
		return "Account Manager";
	} elseif ($lvl == 3) {
		return "Admin";
	} elseif ($lvl == 4) {
		return "System";
	}
}

function goHome($white)
{
	$text = 'Click here to go home';
	if ($white) {
		echo "<p class='link'><a href='dashboard.php'>$text</a></p>";
	} else {
		echo "<a href='dashboard.php'>$text</a>";
	}
}

function goManage($white)
{
	$text = 'Click here to go back';
	if ($white) {
		echo "<p class='link'><a href='manage.php'>$text</a></p>";
	} else {
		echo "<a href='manage.php'>$text</a>";
	}
}
