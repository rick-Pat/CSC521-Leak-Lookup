<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Login | Leak Lookup</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <?php
    include("auth_main.php");

    // When form submitted, check and create user session.
    if (isset($_POST['username'])) {
        $username = stripslashes($_REQUEST['username']);    // removes backslashes
        $username = mysqli_real_escape_string($con, $username);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con, $password);

        // check if all fields are filled (even though the form has them as required)
        if ($username == NULL or $password == NULL) {
            echo "<div class='form'>
			  <h3>Please fill all fields.</h3><br/>
			  <a href='login.php'>Click here to try again.</a>
			  </div>";
            exit;
        }

        // check if exists in the database
        $query    = "SELECT * FROM `Account` WHERE Username='$username'
                     AND Password='$password'";
        $result = mysqli_query($con, $query) or die();
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $Account_ID = $row["Account_ID"];
        $rows = mysqli_num_rows($result);
        if ($rows > 0) {
            $_SESSION['Account_ID'] = $Account_ID;
            header("Location: dashboard.php");
            exit;
        } else {
            echo "<div class='form'>
                  <h3>Incorrect Username/password.</h3><br/>
                  <a href='login.php'>Click here to try again.</a>
                  </div>";
            exit;
        }
    }
    ?>
    <form class="form" method="post" name="login">
        <h1 class="login-title">Login</h1>
        <input type="text" class="login-input" name="username" placeholder="Username" required autofocus="true" />
        <input type="password" class="login-input" name="password" placeholder="Password" required />
        <input type="submit" value="Login" name="submit" class="login-button" />
        <br><br>
        Don't have an account? <a href='registration.php'>Click here to make one</a>
    </form>
</body>

</html>