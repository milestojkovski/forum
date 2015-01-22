<?php
$pagename = "New Topic";
session_start();
require("includes/config.php");
require("includes/functions.php");
$forchecksql = "SELECT * FROM forums;";
$forcheckresult = mysqli_query($dbc, $forchecksql);
$forchecknumrows = mysqli_num_rows($forcheckresult);
if ($forchecknumrows == 0) {
    header("Location: " . $config_basedir);
}
if (isset($_GET['id']) == TRUE) {
    if (!is_numeric($_GET['id'])) {
        $error = 1;
    }
    if ($error == 1) {
        header("Location: " . $config_basedir);
    } else {
        $validforum = $_GET['id'];
    }
} else {
    $validforum = 0;
}
if (!isset($_SESSION['USERNAME'])) {
    header("Location: " . $config_basedir . "/login.php?ref=newpost&id=" . $validforum);
} else {
    if (isset($_POST['submit']) && isset($_SESSION['USERNAME'])) {
        if ($validforum == 0) {
            $topicsql = "INSERT INTO topics(date, user_id, forum_id, subject) VALUES(NOW(), " . $_SESSION['USERID'] . ", " . $_POST['forum'] . ", '" . $_POST['subject'] . "');";
        } else {
            $topicsql = "INSERT INTO topics(date, user_id, forum_id, subject) VALUES(NOW(), " . $_SESSION['USERID'] . ", " . $validforum . ", '" . $_POST['subject'] . "');";
        }
        mysqli_query($dbc, $topicsql) or die(mysqli_error($dbc));
        $topicid = mysqli_insert_id($dbc);
        $messagesql = "INSERT INTO messages(date, user_id, topic_id, subject, body) VALUES(NOW(), " . $_SESSION['USERID'] . ", " . mysqli_insert_id($dbc) . ", '" . $_POST['subject'] . "', '" . $_POST['body'] . "');";
        mysqli_query($dbc, $messagesql)or die(mysqli_error($dbc));
        header("Location: " . $config_basedir . "/viewmessages.php?id=" . $topicid);
    }
    require("includes/header.php");
    require ("includes/inner-top.php");
    if ($validforum != 0) {
        $namesql = "SELECT name FROM forums WHERE id = $validforum;";
        $nameresult = mysqli_query($dbc, $namesql) or die(mysqli_error($dbc));
        $namerow = mysqli_fetch_array($nameresult, MYSQLI_ASSOC);
        echo "<h2>Post new message to the " . $namerow['name'] . "forum</h2>";
        echo "<h2>Post a new message</h2>";
    }
    ?>
    <form action="newtopic.php"  method="post">
        <table>
    <?php
    if ($validforum == 0) {
        $forumssql = "SELECT * FROM forums ORDER BY name;";
        $forumsresult = mysqli_query($dbc, $forumssql) or die(mysqli_error($dbc));
        ?>
                <tr>
                    <td>Forum</td>
                    <td>
                        <select name="forum">
        <?php
        while ($forumsrow = mysqli_fetch_array($forumsresult, MYSQLI_ASSOC)) {
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
                <td>Subject</td>
                <td><input type="text" name="subject"></td>
            </tr>
            <tr>
                <td>Body</td>
                <td><textarea name="body" rows="10" cols="50"></textarea></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" name="submit" value="Post!"></td>
            </tr>
        </table>
    </form>
    <?php
}
require ("includes/inner-bottom.php");
require("includes/footer.php");
?>