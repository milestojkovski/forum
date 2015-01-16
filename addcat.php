<?php
$pagename = "Add Category";
session_start();
require("includes/config.php");
require("includes/functions.php");

if (!isset($_SESSION['ADMIN'])) {
    //header("Location: " . $config_basedir . "/admin.php?ref=cat");.
    header("Location: " . $config_basedir);
} elseif (isset($_POST['submit'])) {
    //$db = mysql_connect($dbhost, $dbuser, $dbpassword);
    //mysql_select_db($dbdatabase, $db);
    $catsql = "INSERT INTO categories(name) VALUES('" . $_POST['cat'] . "');";
    mysqli_query($dbc, $catsql);
    header("Location: " . $config_basedir);
} else {
    require("includes/header.php");
    require ("includes/inner-top.php");
    ?>
    <table width="100%" cellspacing="0" cellpadding="10" border="0" align="center">
        <tr>
            <td align="center">
            <!--<form action="<?php echo pf_script_with_get($SCRIPT_NAME); ?>" method="post">-->
                <form action="addcat.php" method="post">
                    <table>
                        <tr>
                            <td>Category</td>
                            <td><input type="text" name="cat"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="submit" name="submit" value="Add Category!"></td>
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