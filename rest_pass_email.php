<?php
$pagename = "pasword resseting";
require("includes/config.php");
require("includes/header.php");
require ("includes/inner-top.php");
$veryfyemail = urldecode($_GET['email']);
$verifycode = urldecode($_GET['code']);
$sql = "UPDATE users SET rest_code=$verifycode WHERE email='" . $veryfyemail . "'";
$result = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $errors = array(); // Initialize an error array.
    // Check for a new password and match 
    // against the confirmed password:
    if (!empty($_POST['pass1'])) {
        if ($_POST['pass1'] != $_POST['pass2']) {
            $errors[] = 'Your new password did not match the confirmed password.';
        } else {
            $np = mysqli_real_escape_string($dbc, trim($_POST['pass1']));
        }
    } else {
        $errors[] = 'You forgot to enter your new password.';
    }
    if (empty($errors)) { // If everything's OK.
        // Check that they've entered the right email address/password combination:
        $q = "SELECT id FROM users WHERE (rest_code='$verifycode'  )";
        // /AND password=SHA1('$p')
        $r = @mysqli_query($dbc, $q) or die(mysqli_error($dbc));
        $num = @mysqli_num_rows($r);
        if ($num == 1) { // Match was made.
            // Get the user_id:
            $row = mysqli_fetch_array($r, MYSQLI_NUM);
            // Make the UPDATE query:
            $q = "UPDATE users SET password=SHA1('$np') WHERE rest_code='$verifycode'";
            $r = @mysqli_query($dbc, $q) or die(mysqli_error($dbc));
            if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.
                // Print a message.
                echo '<h1>Thank you!</h1>
				<p>Your password has been updated.</p><p><br /></p>';
            } else { // If it did not run OK.
                // Public message:
                echo '<h1>System Error</h1>
				<p class="error">Your password could not be changed due to a system error. We apologize for any inconvenience.</p>';

                // Debugging message:
                echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
            }
            mysqli_close($dbc); // Close the database connection.
            // Include the footer and quit the script (to not show the form).
            //include ('includes/footer.html'); 
            exit();
        } else { // Invalid email address/password combination.
            echo '<h1>Error!</h1>
			';
        }
    } else { // Report the errors.
        echo '<h1>Error!</h1>
		<p class="error">The following error(s) occurred:<br />';
        foreach ($errors as $msg) { // Print each error.
            echo " - $msg<br />\n";
        }
        echo '</p><p>Please try again.</p><p><br /></p>';
    } // End of if (empty($errors)) IF.
    mysqli_close($dbc); // Close the database connection.
} // End of the main Submit conditional.
?>
<h1>Change Your Password</h1>
<form action="" method="post">
    <p>New Password: <input type="password" name="pass1"  value="<?php if (isset($_POST['pass1'])) echo $_POST['pass1']; ?>"  /></p>
    <p>Confirm New Password: <input type="password" name="pass2"  value="<?php if (isset($_POST['pass2'])) echo $_POST['pass2']; ?>"  /></p>
    <p><input type="submit" name="submit" value="Change Password" /></p>
</form>
<?php
require ("includes/inner-bottom.php");
require("includes/footer.php");
?>