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
    $OldUsername = $User_Username;
    $NewUsername = $_POST['username'];
    $Account_ID = $_SESSION['Account_ID'];
    $create_datetime = date("Y-m-d H:i:s");

    // check if the username is in use
    $query = "SELECT * FROM `Account` WHERE Username='$NewUsername'";
    $result  = mysqli_query($con, $query);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $rows = mysqli_num_rows($result);
    if ($rows == 0 or ($row["Account_ID"] == $Account_ID and $NewUsername !== $OldUsername)) {
        $query = "UPDATE `Account` SET `Username` = '$NewUsername' WHERE `Account`.`Account_ID` = $Account_ID";
        $result = mysqli_query($con, $query);
        if ($result) {
            echo "<div class='form'>
            <h3>Sucess: Your username has been changed FROM $OldUsername TO $NewUsername.</h3><br>";
        } else {
            echo "<div class='form'>
		  <h3>There was an error changing your username to \"$NewUsername\".</h3><br>";
        }
    } else {
        echo "<div class='form'>
        <h3>The username \"$NewUsername\" is taken. Please try another.</h3><br>";
    }
    goManage(NULL);
    ?>
    </div>
</body>

</html>