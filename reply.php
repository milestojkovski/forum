
<?php
$pagename = "Reply";

session_start();
require("includes/config.php");
require("includes/functions.php");

if(isset($_POST['submit'])) {
 
$messagesql = "INSERT INTO messages(`date`, `user_id`, `topic_id`, `subject`, `body`, `img`) "
        . "VALUES(NOW(), '" . $_SESSION['USERID'] . "', '" . $_POST['id'] . "', '".  $_POST['subject'] . "','" . $_POST['body'] . "','".$_SESSION['USERIMG']."')";
                                                       
mysqli_query($dbc, $messagesql) or die(mysqli_error($dbc));
header("Location: " . $config_basedir . "/viewmessages.php?id=" . $_POST['id']);

}


require("includes/header.php");
require ("includes/inner-top.php");
?>
<html>
    <form action="reply.php" method="post">
 
<table>
<tr>
<td>Subject</td>
<td><input type="text" name="subject"></td>
</tr>

<tr>
<td>Body</td>
<td><textarea name="body" rows="10" cols="50"></textarea></td>
</tr>

<tr>
    <td><input type="hidden" name="id" value="<?php echo $_GET['id'];?>"></td>   
</tr>

<tr>
<td></td>
<td><input type="submit" name="submit" value="Post!"></td>
</tr>

</table>
</form>
</html>

<?php

require ("includes/inner-bottom.php");
require("includes/footer.php");
?>