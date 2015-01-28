<html>
    <head>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script>
            $(document).ready(function () {
                $("#PicPolicy").click(function () {
                    alert("3MB the most you can upload. \n\
supports: pjpeg,jpeg,JPG,X-PNG, PNG, png, x-png");
                });
            });
        </script>
        <script type="text/javascript" src="jquery.min.js"></script>
    </head>
<?php
session_start();
$pagename = "Personal profile";
require("includes/config.php");
require("includes/header.php");
require ("includes/inner-top.php");
require ("includes/functions.php");
if (isset($_POST['submit'])) {
    // Check for an uploaded file:
    if (isset($_FILES['upload'])) {
        // Validate the type. Should be JPEG or PNG.
        $allowed = array('image/pjpeg', 'image/jpeg', 'image/JPG', 'image/X-PNG', 'image/PNG', 'image/png', 'image/x-png');
        if (in_array($_FILES['upload']['type'], $allowed)) {
            $file_name = $_SESSION['USERNAME'];
            //echo"$file_name";// renaming the name so there is no file with same name in the databaseeee
            // Move the file over.
            if (move_uploaded_file($_FILES['upload']['tmp_name'], "../uploads/{$file_name}.jpg")) {
                $q = mysqli_query($dbc, "UPDATE users SET img = '" . $file_name . ".jpg" . "' WHERE username = '" . $_SESSION['USERNAME'] . "'"); // or die (mysqli_error_list($dbc));
                echo '<p><em>your profile pic has been changed!</em></p>';
            } // End of move... IF.
        } else { // Invalid type.
            echo '<p class="error">Please upload a JPEG or PNG image.</p>';
        }
    } // End of isset($_FILES['upload']) IF.
    // Check for an error:
    if ($_FILES['upload']['error'] > 0) {
        echo '<p class="error">The file could not be uploaded because: <strong>';

        // Print a message based upon the error.
        switch ($_FILES['upload']['error']) {
            case 1:
                print 'The file exceeds the upload_max_filesize setting in php.ini.';
                break;
            case 2:
                print 'The file exceeds the MAX_FILE_SIZE setting in the HTML form.';
                break;
            case 3:
                print 'The file was only partially uploaded.';
                break;
            case 4:
                print 'No file was uploaded.';
                break;
            case 6:
                print 'No temporary folder was available.';
                break;
            case 7:
                print 'Unable to write to the disk.';
                break;
            case 8:
                print 'File upload stopped.';
                break;
            default:
                print 'A system error occurred.';
                break;
        } // End of switch.

        print '</strong></p>';
    } // End of error IF.
    // Delete the file if it still exists:
    if (file_exists($_FILES['upload']['tmp_name']) && is_file($_FILES['upload']['tmp_name'])) {
        unlink($_FILES['upload']['tmp_name']);
    }
} // End of the submitted conditional.
?>
<html>
    <body>
<?php
$q = mysqli_query($dbc, "SELECT * FROM users WHERE id={$_SESSION['USERID']}");
while ($row = mysqli_fetch_assoc($q)) {
    echo "<br>";
    if ($row['img'] == NULL) {
        echo "<img width='100' height='100' src='../uploads/default.jpg' alt='Default Profile Pic'>";
    } else {
        echo "<img width='100' height='150' src='../uploads/" . $row['img'] . "' alt='Profile Pic'>";
    }echo "<br>";
    echo "Your Username is:<b> " . $row['username'] . "</b><br>";
    echo "Your Email is: <b>" . $row['email'] . "</b><br>";
    echo "User since: <b>" . $row['registration_date'] . "</b><br>";
    NumberOfForumsOpened(); // function that is in includes/functions.php that counts how many forums the user has opened.
?>
        <a href="ListOfForumsOpened.php">Click for list!</a>
    <?php
    echo "<br><br>";
}
?>
        <form action="" method="post" enctype="multipart/form-data">
            <table>                 
                <tr>
                    <td>Please chose/change your profile picture  <p id="PicPolicy"><small>Click here for picture policy</small></p></td>
                    <input type="hidden" name="MAX_FILE_SIZE" value="3145728" />
                    <!-- 3MB the most you can upload-->
            </tr>
                    <td><input type="file" name="upload"></td>
                    
            
            <tr>
                    <td> <input type="submit" name="submit" value="Submit!"></td>
                </tr>
                <tr>
                    <td>For new password
                        <a href="rest_pass.php">click here </a></td>
                </tr>
            </table>
        </form>
    </body>
</html>

<?php
require ("includes/inner-bottom.php");
require("includes/footer.php");
?>