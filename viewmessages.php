<html><link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="css/forms.css" type="text/css"></html>

<?php
session_start();
include("includes/config.php");
include("includes/functions.php");
//require("css/forms.css");
//require("css/style.css");
//if(isset($_GET['id'])) {
//if(!is_numeric($_GET['id'])) {
//header("Location: " . $config_basedir);
//}
//else //{
$validtopic = $_GET['id'];
//echo "$validtopic";
//}
//}/
//else {
//header("Location: " . $config_basedir);
//}
require("includes/header.php");
/* name of the topic and breadcrumb trail */
$topicsql = "SELECT topics.subject, topics.forum_id, forums.name FROM topics, forums WHERE topics.forum_id = forums.id AND topics.id = " . $validtopic . ";";
//$topicresult = mysqli_query($dbc,$topicsql);
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

                //$us=$threadrow['username'];
                //echo"$us dsakdjasdlkasjdkasldja";

                echo "
    
	<tr>
		<td width=\"150\" align=\"left\" valign=\"top\" class=\"row1\"><span class=\"name\"><a name=\"2\"></a><b>$threadrow[username]</b></span><br /><span class=\"postdetails\">" . date("jS F Y g.iA", strtotime($threadrow['date'])) . "</span><br />
                        ";
//echo "this is the iuser id".$_SESSION['USERID'];
                echo "<br>";


                //$r = mysqli_query($dbc, $q)
                //or die("Error: ".mysqli_error($dbc));
                //$row = mysqli_fetch_array($r, MYSQLI_ASSOC) or die(mysqli_error($dbc));
                //echo "<img width='100' height='100' src='../uploads/".$row['img']."' alt='Profile Pic'>";
//$topicsql = "SELECT topics.subject, topics.forum_id, forums.name FROM topics, forums WHERE topics.forum_id = forums.id AND topics.id = " . $validtopic . ";";
                /*
                  $q = "SELECT img from messages where ";
                  $r = mysqli_query($dbc, $q);
                  $row = mysqli_fetch_array($r, MYSQLI_ASSOC) or die(mysqli_error($dbc));
                  echo "<img width='100' height='100' src='../uploads/".$row['img']."' alt='Profile Pic'>";
                 */
                $temp = $threadrow['user_id'];
//echo "the user who has posted id ".$temp;
//$t = "SELECT messages.*, users.username FROM messages, users WHERE messages.user_id = users.id AND messages.topic_id = " . $validtopic . " ORDER BY messages.date;";
//$q = "SELECT messages.img FROM messages, users WHERE messages.{$_SESSION['USERID']} = users.id";
//$q = "SELECT messages.img FROM messages, users WHERE users.id = '". $temp ."' ";
//$q = "SELECT users.img FROM users, messages WHERE users.id = '". $temp ."' "; // WOOOORKING QUERYYYY
                $us = $threadrow['username'];

                $q = "SELECT users.img FROM users WHERE users.username = '" . $us . "' ";


                $r = mysqli_query($dbc, $q);
                $row = mysqli_fetch_array($r, MYSQLI_ASSOC) or die(mysqli_error($dbc));
                echo "<img width='100' height='150' src='../uploads/" . $row['img'] . "' alt='Profile Pic'>";
//	<td width=\"100%\"><a href=\"viewtopic905b.html?p=2#2\"><img src=\"images/icon_minipost.gif\" width=\"12\" height=\"9\" alt=\"Post\" title=\"Post\" border=\"0\" /></a><span class=\"postdetails\">Post subject: $threadrow[subject]</span></td>

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
$display = 1;
if (isset($_GET['p']) && is_numeric($_GET['p'])) { // Already been determined.
    $pages = $_GET['p'];
} else {
    // Count the number of records:
    $no = $_GET['id']; //echo"$no";
    $q = "SELECT COUNT(topic_id) FROM messages where topic_id=$no";
    $r = mysqli_query($dbc, $q) or die(mysqli_error($dbc));
    $row = @mysqli_fetch_array($r, MYSQLI_NUM);
    $records = $row[0];
    echo"$row[0]";
    // Calculate the number of pages...
    if ($records > $display) { // More than 1 page.
        $pages = ceil($records / $display);
    } else {
        $pages = 1;
    }
}
if (isset($_GET['s']) && is_numeric($_GET['s'])) {
    $start = $_GET['s'];
} else {
    $start = 0;
}

if ($pages > 1) {

    echo '<br /><p>';
    $current_page = ($start / $display) + 1;

    // If it's not the first page, make a Previous button:
    if ($current_page != 1) {
        echo '<a href="viewmessages.php?s=' . ($start - $display) . '&p=' . $pages . '">Previous</a> ';
    }

    // Make all the numbered pages:
    for ($i = 1; $i <= $pages; $i++) {
        if ($i != $current_page) {
            echo '<a href="viewmessages.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '">' . $i . '</a> ';
        } else {
            echo $i . ' ';
        }
    } // End of FOR loop.
    // If it's not the last page, make a Next button:
    if ($current_page != $pages) {
        echo '<a href="viewmessages.php?s=' . ($start + $display) . '&p=' . $pages . '">Next</a>';
    }

    echo '</p>'; // Close the paragraph.
} // End of links section.
?>
<?php
require("includes/footer.php");
//if($_SESSION['ADMIN']) {
//echo "[<a href=\"delete.php?func=thread&id={$threadrow['id']}\".\"?forum={$validtopic}\">X</a>] - "; //deletes thredas (messages)
//	}
?>


