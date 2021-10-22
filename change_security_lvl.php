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
    $new_security_level = $_POST["security_lvl"];
    $use_acc_id = $_POST["use_acc_id2"];

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
    $user_is_owner = $User_Security_Level == 4;
    $target_not_self = $target_account_id !== $User_Account_ID;
    $user_is_admin = $User_Security_Level > 1;

    if (($target_below_user or $user_is_owner) and $target_not_self and $user_is_admin) {
        $query = "UPDATE `Account` SET `Security_Level` = '$new_security_level' WHERE `Account`.`Account_ID` = $target_account_id";
        $result = $con->query($query);
        if ($result) {
            echo "<div class='form'>
            <h3>Sucess! Security level for $target_username changed from $target_security_level to $new_security_level.</h3><br/>
            <p class='link'><a href='dashboard.php'>Click here to continue</a></p>
            </div>";
        } else {
            echo "<div class='form'>
            <h3>ERROR $target_user | $new_security_level | $use_acc_id | $target_security_level</h3><br/>
            <p class='link'><a href='dashboard.php'>Click here to continue</a></p>
            </div>";
        }
    } else {
        echo "<div class='form'>
        <h3>There was an error with that action.</h3><br/>
        <p class='link'><a href='dashboard.php'>Click here to go back</a>.</p>
        </div>";
    }
    ?>
</body>

</html>