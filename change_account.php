<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Admin Panel | Leak Lookup</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>

    <?php
    include("auth_main.php");
    $target_user = $_POST["target_user"];
    $use_acc_id = $_POST["use_acc_id"];

    if ($use_acc_id) {
        $query = "SELECT * FROM `Account` WHERE Account_ID=$target_user";
    } else {
        $query = "SELECT * FROM `Account` WHERE `Username`='$target_user'";
    }

    $result = $con->query($query);
    $target_data = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $rows = mysqli_num_rows($result);

    $target_security_level = $target_data["Security_Level"];
    $target_username = $target_data["Username"];
    $target_account_id = $target_data["Account_ID"];

    $target_below_user = $target_security_level < $User_Security_Level;
    $target_not_self = $target_account_id !== $User_Account_ID;
    $user_is_admin = $User_Security_Level > 1;

    if ($target_below_user and $target_not_self and $user_is_admin) {
        $_SESSION['Account_ID'] = $target_account_id;
        echo "<div class='form'>
		  <h3>Sucess! You are now logged into $target_username (#$target_account_id)</h3><br/>
		  <a href='dashboard.php'>Click here to continue</a>
		  </div>";
    } else {
        echo "<div class='form'>
        <h3>There was an error with that action.</h3><br/>
        <a href='dashboard.php'>Click here to go back</a>.
        </div>";
    }
    ?>
</body>

</html>