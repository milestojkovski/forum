<?php
$pagename = "Verification";
require("includes/config.php");
require("includes/header.php");
require ("includes/inner-top.php");
$verifystring = urldecode($_GET['verify']);
$verifyemail = urldecode($_GET['email']);
$sql = "SELECT id FROM users WHERE verifystring = '" . $verifystring . "' AND email = '" . $verifyemail . "';";
$result = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));
$numrows = mysqli_num_rows($result);
if ($numrows == 1) {
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
//$forumrow = mysqli_fetch_array($forumresult, MYSQLI_ASSOC); 
//
    $sql = "UPDATE users SET active = '1' WHERE id = " . $row['id'];
    $result = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));
    echo "Your account has now been verified. You can now <a href='login.php'>log in</a>";
} else {
    echo "This account could not be verified.";
}
require ("includes/inner-bottom.php");
require("includes/footer.php");
?>