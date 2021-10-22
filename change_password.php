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
    $old_password = $_POST["old_password"];
    $new_password = $_POST["new_password"];
    $new_password_again = $_POST["new_password_again"];
    $Account_ID = $_SESSION["Account_ID"];
    $create_datetime = date("Y-m-d H:i:s");

    $confirm_old_password = $old_password == $row["Password"];
    $confirm_new_password = $new_password == $new_password_again;

    if ($confirm_old_password and $confirm_new_password) {
        $query = "UPDATE `Account` SET `Password` = '$new_password' WHERE `Account`.`Account_ID` = $Account_ID";
        $result = mysqli_query($con, $query);
        if ($result) {
            echo "<div class='form'>
		  <h3>Sucess! Your password was changed.</h3><br/>
		  <p class='link'><a href='dashboard.php'>Click here to go back</a>.</p>
		  </div>";
        } else {
            echo "<div class='form'>
		  <h3>There was an error changing your password..</h3><br/>
		  <p class='link'><a href='manage.php'>Click here to go back</a>.</p>
		  </div>";
        }
    } else {
        echo "<div class='form'>
        <h3>Password check failed. Please try again.</h3><br/>
        <p class='link'><a href='manage.php'>Click here to go back</a>.</p>
        </div>";
    }
    ?>
</body>

</html>