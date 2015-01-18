<html>
    <head>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

        <script>
            $(document).ready(function () {
                $("#PassPolicy").click(function () {
                    alert("Password must be at least 4 characters. \n\
No more than 8 characters. \n\
Must include at least one upper case letter, one lower case letter.\n\
At least one numeric digit");
                });
            });
        </script>
    </head>

    <?php
    $pagename = "Register";
    session_start();
    require("includes/config.php");
//$db = mysql_connect($dbhost, $dbuser, $dbpassword);
//mysql_select_db($dbdatabase, $db);
    if (isset($_POST["submit"])) {
        if ($_POST["password1"] == $_POST["password2"]) {
            $checksql = "SELECT * FROM users WHERE username = '" . $_POST["username"] . "';";
            $checkresult = mysqli_query($dbc, $checksql);
            $checknumrows = mysqli_num_rows($checkresult);
            if ($checknumrows == 1) {
                header("Location: " . $config_basedir . "/register.php?error=taken");
            } else {
                for ($i = 0; $i < 16; $i++) {
                    //$randomstring .= chr(mt_rand(32,126));
                   $randomstring .= chr(mt_rand(32, 126));
                }
                $verifyurl = "$config_basedir/verify.php";
                $verifystring = urlencode($randomstring);
                $verifyemail = urlencode($_POST['email']);
                $validusername = $_POST['username'];
                $errors = array(); // Initialize an error array.
                // Check for a username:
                if (empty($_POST['username'])) {
                    $errors[] = 'You forgot to enter your username.';
                } else {
                    $un = mysqli_real_escape_string($dbc, trim($_POST['username']));
                }

                // Check for an email address:
                if (empty($_POST['email'])) {
                    $errors[] = 'You forgot to enter your email address.';
                } else {
                    $e = mysqli_real_escape_string($dbc, trim($_POST['email']));
                    // $e = $_POST['email'];
                }


                // Check for a password and match against the confirmed password:
                if (!empty($_POST['password1'])) {
                    if ($_POST['password1'] != $_POST['password2']) {
                        $errors[] = 'Your password did not match the confirmed password.';
                    } else {
                        $pa = mysqli_real_escape_string($dbc, trim($_POST['password1']));
                    }

                    if (preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{4,8}$/', $pa)) {
                        $p = $pa;
                    } else {
                        $errors[] = 'You password doesnt meet the password policy.';
                        //nopolicy
                        header("Location: " . $config_basedir . "/register.php?error=nopolicy");
                    }
                } else {
                    $errors[] = 'You forgot to enter your password.';
                }

                if (empty($errors)) { // If everything's OK.
//if ($_POST['username'] && $_POST['password1'] && $_POST['password2'] && $_POST['email']) {
                    $sql = "INSERT INTO users(username, password, email, verifystring, active, registration_date) VALUES( '$un'  ,  SHA1('$p')  ,  '$e'  , '" . addslashes($randomstring) . "', 0, NOW());";
                   // insert the valus for the user
                    mysqli_query($dbc, $sql) or die(mysqli_error($dbc));

                    $mail_body = "Hi $validusername, Please click on the following link to verify your new account: $verifyurl?email=$verifyemail&verify=$verifystring";

                    $status = mail($_POST["email"], $config_forumsname . " User verification", $mail_body);

                    if (!$status) {
                        require("includes/header.php");
                        require ("includes/inner-top.php");
                        echo "Registration successful, but mail cannot be sent. <a href=\"$verifyurl?email=$verifyemail&verify=$verifystring\">Click here</a> to activate your account.";
                    } else {
                        require("includes/header.php");
                        require ("includes/inner-top.php");
                        echo "A link has been emailed to the address you entered below. Please follow the link in the email to validate your account.";
                    }
                } else {
                    require("includes/header.php");
                    require ("includes/inner-top.php");
                    echo "All fields are mandatory";
                }
            }
        } else {
            header("Location: " . $config_basedir . "/register.php?error=pass");
        }
    } else {
        require("includes/header.php");
        require ("includes/inner-top.php");
        if (isset($_GET['error'])) {
            switch ($_GET['error']) {
                case "pass":
                    echo "Passwords do not match!";
                    break;
                case "taken":
                    echo "Username taken, please use another.";
                    break;
                case "nopolicy":
                    echo "Password doesnt meet pasword policy";
                    break;
                case "no":
                    echo "Incorrect login details!";
                    break;
            }
        }
        ?>


        <form action="register.php" method="POST">
            <table>
                <tr>
                    <td>Username</td>
                    <td><input type="text" name="username" value="<?php if (isset($_POST['username'])) echo $_POST['username']; ?>"></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type="password" name="password1" value="<?php if (isset($_POST['password1'])) echo $_POST['password1']; ?>"></td>
                    <td> <p id="PassPolicy">Click here for Password policy</p> </td>
                </tr>
                <tr>
                    <td>Confirm password</td>
                    <td><input type="password" name="password2" value="<?php if (isset($_POST['password2'])) echo $_POST['password2']; ?>"></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><input type="text" name="email" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit"
                               name="submit" value="Register!"></td>
                </tr>



            </table>
            <p> NOTE: Please make sure your email is correct since you are supposed to get activation link. </p>
        </form>
    </html>

    <?php
}
require ("includes/inner-bottom.php");
require ("includes/footer.php");
?>
