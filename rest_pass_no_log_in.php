<?php
$pagename = "pasword resseting";
require("includes/config.php");
require("includes/header.php");
require ("includes/inner-top.php");
error_reporting(0);
if ($_POST['submit'] == 'Send') {
//keep it inside
    $email = $_POST['email'];

    $query = mysqli_query($dbc, "select * from users where email='$email'")
            or die(mysqli_error($con));

    $numrows = mysqli_num_rows($query);

    if ($numrows == 1) {
        $code = rand(100, 999);

        $message = "Please follow the link for reseting your password: $config_basedir/rest_pass_email.php?email=$email&code=$code \n regards, Admin";
        mail($email, "Resetting your password", $message);
        echo '<br>Email sent please check your mail and follow the instructions<br>';
    } else {
        echo '<p class="error">No user exist with this email id</p>';
    }
}
?>
<form action="rest_pass_no_log_in.php" method="post">
    <br> Enter you email : <input type="text" name="email">
    <input type="submit" name="submit" value="Send">
</form>
<?php
require ("includes/inner-bottom.php");
require("includes/footer.php");
?>