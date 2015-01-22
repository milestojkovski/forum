<html>
<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel="stylesheet" href="css/forms.css" type="text/css">
</html>
<?php
session_start();
include("includes/config.php");
include("includes/functions.php");
$validtopic = $_GET['id'];
require("includes/header.php");
/* name of the topic and breadcrumb trail */
$topicsql = "SELECT topics.subject, topics.forum_id, forums.name FROM topics, forums WHERE topics.forum_id = forums.id AND topics.id = " . $validtopic . ";";
$topicresult = mysqli_query($dbc, $topicsql) or die(mysqli_error($dbc));
$topicrow = mysqli_fetch_array($topicresult, MYSQLI_ASSOC);
?>
<table width="100%" cellspacing="0" cellpadding="10" border="0" align="center">
    <tr>
        <td>
            <table width="100%" cellspacing="2" cellpadding="2" border="0">
                <tr>
                    <td align="left" valign="bottom" colspan="2">
                        <?php echo "<a class=\"maintitle\" href=\" " . " \">" . $topicrow['subject'] . "</a>"; ?>
                        <br />      
                        <?php echo "<small><a href='index.php'>" . $config_forumsname . " forums</a> -> <a href='viewforum.php?id=" . $topicrow['forum_id'] . "'>" . $topicrow['name'] . "</a></small>"; ?>
                    </td>
                </tr>
            </table>    

            <?php
// messages that are part of the query*/
            $threadsql = "SELECT messages.*, users.username FROM messages, users WHERE messages.user_id = users.id AND messages.topic_id = " . $validtopic . " ORDER BY messages.date;";
            $threadresult = mysqli_query($dbc, $threadsql) or die(mysqli_error($dbc));
            ;
            echo "<table class=\"forumline\" width=\"100%\" cellspacing=\"1\" cellpadding=\"3\" border=\"0\">
	<tr>
		<th class=\"thLeft\" width=\"150\" height=\"26\" nowrap=\"nowrap\">Author</th>
		<th class=\"thRight\" nowrap=\"nowrap\">Messags</th>
	</tr>";
            while ($threadrow = mysqli_fetch_array($threadresult, MYSQLI_ASSOC)) {
                echo "
	<tr>
		<td width=\"150\" align=\"left\" valign=\"top\" class=\"row1\"><span class=\"name\"><a name=\"2\"></a><b>$threadrow[username]</b></span><br /><span class=\"postdetails\">" . date("jS F Y g.iA", strtotime($threadrow['date'])) . "</span><br />
                        ";
                echo "<br>";
                $temp = $threadrow['user_id'];
                $us = $threadrow['username'];
                $q = "SELECT users.img FROM users WHERE users.username = '" . $us . "' ";
                $r = mysqli_query($dbc, $q);
                $row = mysqli_fetch_array($r, MYSQLI_ASSOC) or die(mysqli_error($dbc));
                echo "<img width='100' height='150' src='../uploads/" . $row['img'] . "' alt='Profile Pic'>";
                echo"
</td>
		<td class=\"row1\" width=\"100%\" height=\"28\" valign=\"top\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">	
                        <tr>                               
				<td width=\"100%\"><img src=\"images/icon_minipost.gif\" width=\"12\" height=\"9\" alt=\"Post\" title=\"Post\" border=\"0\" /><span class=\"postdetails\">Post subject: $threadrow[subject]</span></td>
				<td valign=\"top\" nowrap=\"nowrap\"></td>
			</tr>
			<tr>
				<td colspan=\"2\"><hr /></td>
			</tr>
			<tr>"; //closed echo
                if (isset($_SESSION['ADMIN'])) {
                    // original echo "<small><div style=\"float: right\">[<a href=\"delete.php?func=thread&id={$threadrow['id']}\".\"?forum={$validtopic}\">X</a>] </div></small>"; //deletes  (messages) replys 
                    echo "<small><div style=\"float: right\">[<a href=\"delete.php?func=msg&id={$threadrow['id']}\".\"?forum={$validtopic}\">X</a>] </div></small>"; //deletes  (messages)
                }
                echo"        
				<td>$threadrow[body]</td>
			</tr>
		</table></td>
	</tr>
	<tr>
		<td class=\"row1\" width=\"150\" align=\"left\" valign=\"middle\">&nbsp;</td>
		<td class=\"row1\" width=\"100%\" height=\"28\" valign=\"bottom\" nowrap=\"nowrap\"><div align=\"right\"><small>[<a href='reply.php?id=" . $validtopic . "'>reply</a>]</small></div></td>
	</tr>
	<tr>
		<td class=\"spaceRow\" colspan=\"2\" height=\"1\"><img src=\"images/spacer.gif\" alt=\"\" width=\"1\" height=\"1\" /></td>
	</tr>
";
            }
            echo "</table>"
            ?>
        </td>
    </tr>
</table>

<?php
require("includes/footer.php");
?>


