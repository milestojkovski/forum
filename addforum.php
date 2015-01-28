<?php
$pagename = "Add Forum";
session_start();
include("includes/config.php");
require("includes/header.php");
require ("includes/inner-top.php");

if (isset($_SESSION['ADMIN'])OR $_SESSION['USERNAME']) {
  if (isset($_POST['submit'])) {
    $topicsql = "INSERT INTO forums(opener, cat_id, name, description) VALUES(" . $_SESSION['USERID'] . "," . $_POST['cat'] . ", '" . $_POST['name'] . "', '" . $_POST['description'] . "');";
    mysqli_query($dbc, $topicsql) or die(mysqli_error($dbc));
    header("Location: " . $config_basedir);
} }
    
    ?>
    <table width="100%" cellspacing="0" cellpadding="10" border="0" align="center">
        <tr>
            <td align="center">
                 
                <form action="addforum.php" method="post">
                    <table>
    <?php
    
    $forumssql = "SELECT * FROM categories ORDER BY name;";
    $forumsresult = mysqli_query($dbc, $forumssql) or die(mysqli_error($dbc));
    ;
    ?>
                        <tr>
                            <td>Category</td>
                            <td>
                                <select name="cat">
    <?php
    while ($forumsrow = mysqli_fetch_array($forumsresult, MYSQLI_ASSOC)) {
        echo "<option value='" . $forumsrow['id'] . "'>" . $forumsrow['name'] . "</option>";
    }
    ?>
                                </select>
                            </td>
                        </tr>
    <?php

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
require ("includes/inner-bottom.php");
require("includes/footer.php");
?>