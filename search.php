<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Search Results | Leak Lookup</title>
    <link rel="stylesheet" href="style.css" />
</head>
<style>
    div {
        background-color: black;
        width: 600px;
        border: 1px solid green;
        margin-top: 15px;
        margin-left: auto;
        margin-right: auto;
        opacity: 0.9;
    }

    h1 {
        color: greenyellow;
        text-align: center;
        font-size: 20px;
        margin-top: 50px;
    }

    h2 {
        color: greenyellow;
        text-align: center;
        font-size: 20px;
        margin-top: 10px;
    }

    p {
        color: greenyellow;
        text-align: center;
        font-size: 18px;
    }
</style>

<?php
include("auth_main.php");
$EmailAddress = $_POST["email"];
$query = "SELECT * FROM `EmailAddresses` WHERE Email='$EmailAddress'";
$result = $con->query($query);
$target_data = mysqli_fetch_array($result, MYSQLI_ASSOC);
//$rows = mysqli_num_rows($result);
$EmailIsPrimary = $EmailAddress == $User_Primary_Email;
$EmailIsTheirs = $target_data["Account_ID"] == $Account_ID;

$dumps = array("habbo_dump", "linkedin");
?>

<body>
    <?= "<h1>Search results for $EmailAddress:</h1>" ?>
    <?
    if ($EmailIsTheirs or $EmailIsPrimary) {
        $count = 0;
        $domanin = "null";
        foreach ($dumps as $current) {
            $handle = fopen("$current.txt", "r");
            if ($handle) {
                while (($line = fgets($handle)) !== false) {
                    if ($current == "habbo_dump") {
                        list($UserID, $Password, $Birthday, $Email) = explode(",", $line);
                        $domain = "habbo.com (May 2012)";
                    } elseif ($current == "linkedin") {
                        list($Email, $PasswordHashSHA1) = explode(":", $line);
                        $domain = "linkedin.com (May 2016)";
                    }
                    $SameEmail = (strtolower(trim($EmailAddress)) == strtolower(trim($Email))) == 1;
                    if ($SameEmail) {
                        $count++;
                        echo "<div><h2>[$count] $domain</h2><p>";
                        if (strlen(trim($UserID)) > 0) {
                            echo "User: $UserID<br>";
                        }
                        if (strlen(trim($Birthday)) > 0) {
                            echo "Birthday: $Birthday<br>";
                        }
                        if (strlen(trim($Email)) > 0) {
                            echo "Email: $Email<br>";
                        }
                        if (strlen(trim($PasswordHashSHA1)) > 0) {
                            echo "Password Hash (SHA-1): $PasswordHashSHA1<br>";
                            $hash_type = "sha1";
                            $email = "";
                            $code = "";
                            $Password = file_get_contents("https://md5decrypt.net/en/Api/api.php?hash=" . trim($PasswordHashSHA1) . "&hash_type=" . $hash_type . "&email=" . $email . "&code=" . $code);
                        }
                        if (strlen(trim($Password)) > 0) {
                            echo "Password: $Password<br>";
                        }
                        echo "</p></div>";
                    }
                }
                fclose($handle);
            } else {
                echo "<div><p>There was an error loading the file.</p>";
            }
        }
        if ($count == 0) {
            echo "<div><p>No results found!</p>";
        }
    } else {
        echo "<div><p>There was an error authenticating your request.</p>";
    }
    goHome(true);
    ?>
    <br></div><br><br><br><br><br>
</body>

</html>