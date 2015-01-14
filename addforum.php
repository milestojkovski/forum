<?php
$pagename = "Add Forum";
session_start();
require("includes/config.php");
require("includes/functions.php");
$dbhost = "localhost";
$dbuser = "root";
$dbpassword = "";
$dbdatabase = "testforum";
$db = mysql_connect($dbhost, $dbuser, $dbpassword);
mysql_select_db($dbdatabase, $db);

if(isset($_SESSION['ADMIN']) == FALSE) {
	header("Location: " . $config_basedir . "/admin.php?ref=add");
}
if($_POST['submit']) {
	$topicsql = "INSERT INTO forums(cat_id, name, description) VALUES(". $_POST['cat'] . ", '" . $_POST['name'] . "', '" . $_POST['description'] . "');";
	mysql_query($topicsql);
	header("Location: " . $config_basedir);
}
else {
	require("includes/header.php");
	require ("includes/inner-top.php");
?>
<table width="100%" cellspacing="0" cellpadding="10" border="0" align="center">
  <tr>
    <td align="center">
         <!-- <form action="<?php echo pf_script_with_get($SCRIPT_NAME); ?>" method="post"> -->
        <form action="addforum.php" method="post">
            <table>
                <?php
                    if ($validforum == 0){
                    $forumssql = "SELECT * FROM categories ORDER BY name;";
                    $forumsresult = mysql_query($forumssql);
                ?>
                <tr>
                    <td>Category</td>
                    <td>
                    <select name="cat">
                    <?php
                        while($forumsrow = mysql_fetch_assoc($forumsresult)) {
                            echo "<option value='" . $forumsrow['id'] . "'>" . $forumsrow['name'] . "</option>";
                        }
                    ?>
                    </select>
                    </td>
                </tr>
                    <?php
                    }
                    ?>
                <tr>
                    <td>Name</td>
                    <td><input type="text" name="name"></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><textarea name="description" rows="10" cols="50"></textarea></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" name="submit" value="Add Forum!"></td>
                </tr>
          </table>
	  </form>
    </td>
  </tr>
</table>
<?php
}
require ("includes/inner-bottom.php");
require("includes/footer.php");
?>