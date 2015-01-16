<?php
if (!isset($_SESSION)) {
    session_start();
}
/* session_start();
  $_SESSION = array();
  session_destroy(); */
require ("config.php");
//$db = mysql_connect($dbhost, $dbuser, $dbpassword);
//mysql_select_db($dbdatabase, $db);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <meta http-equiv="Content-Style-Type" content="text/css">
        <!--<title>
        <?php
        echo $config_forumsname;
        ?>
        
        </title>-->
        <title>Discussion Forum</title>
        <link rel="stylesheet" href="css/style.css" type="text/css" />

    </head>
    <body>

        <a name="top"></a>

        <table width="770" height="100%" cellpadding="0" cellspacing="0" border="0" align="center" bgcolor="ffffff">
            <tr valign="top">

                <td width="15" background="images/left.gif"></td>

                <td>
                    <table width="740" border="0" cellpadding="0" cellspacing="0" align="center">
                        <tr>
                            <td background="images/image_01.jpg" width="740" height="50"></td>
                        </tr>
                        <tr>
                            <td background="images/image_02.jpg" width="740" height="13"></td>
                        </tr>
                        <tr>
                            <td background="images/image_03.jpg" width="740" height="8"></td>
                        </tr>
                        <tr>
                            <td background="images/image_04.jpg" width="740" height="32" align="left" style="padding:0px 30px 0px 30px;">
                                <table cellpadding="0" cellspacing="0" border="0" id="menu">
                                    <tr>

                                        <td><a href="index.php" class="mainmenu">Home</a></td>
                                        <?php
                                        if (isset($_SESSION['USERNAME'])) {
                                            if (isset($_SESSION['ADMIN'])) {
                                                echo "<td><a href='addcat.php' class='mainmenu'>New Category</a></td>";
                                                echo "<td><a href='addforum.php' class='mainmenu'>New Forum</a></td>";
                                            }
                                            echo "<td><a href='newtopic.php' class='mainmenu'>New Topic</a></td>";
                                        } else {
                                            echo "<td><a href='login.php' class='mainmenu'>Login</a></td>";
                                            echo "<td><a href='register.php' class='mainmenu'>Register</a></td>";
                                        }

                                        if (isset($_SESSION['USERNAME'])) {


                                            echo"<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
                                            . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
                                            . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
                                            . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
                                            . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
                                            . "&nbsp;</td>";
                                            echo "<td> <small>Currently logged in as:</small><a href=profile.php> {$_SESSION['USERNAME']}</a></td>";
                                            echo "<td><a href='logout.php' class='mainmenu'>Logout</a></td>";
                                        }
                                        ?>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td background="images/image_05.jpg" width="740" height="10"></td>
                        </tr>
                    </table>
