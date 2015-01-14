<?php
include("includes/config.php");
include("includes/functions.php");
if(isset($_GET['id']) == TRUE) {
if(is_numeric($_GET['id']) == FALSE) {
	header("Location: " . $config_basedir);
	}
	$validforum = $_GET['id'];
       // echo"$validforum";
}
else {
header("Location: " . $config_basedir);
}

require("includes/header.php");
?>
<table width="100%" cellspacing="0" cellpadding="10" border="0" align="center">
	<tr>
		<td>


<!--<form method="post" action="http://phpbb.siteground.com/SiteGroundPHPbb6/viewforum.php?f=3&amp;start=0"> -->
<form>
  <table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
	  <td align="left" valign="bottom" colspan="2">
<?php
/*name of the current forum and breadcrumb*/
$forumsql = "SELECT * FROM forums WHERE id = " . $validforum . ";";
$forumresult = mysqli_query($dbc,$forumsql);
$forumrow = mysqli_fetch_array($forumresult, MYSQLI_ASSOC); 
                                                                                                                  //href=\" "/*. pf_script_with_get($SCRIPT_NAME)*/ ." \">". $top
echo "<span class=\"maintitle\"><a class=\"maintitle\" href='index.php'>Forums</a> &raquo; <a class=\"maintitle\" href=\" "/*. pf_script_with_get($SCRIPT_NAME) */." \">" . $forumrow['name'] . "</a></span>";
?>      
      </td>
	  <td align="right" valign="bottom" nowrap="nowrap"><span class="gensmall"><b></b></span></td>
	</tr>
	<tr>
	  <td align="left" valign="middle" width="50">&nbsp;</td>
	  <td align="left" valign="middle" class="nav" width="100%">&nbsp;</td>
	<!--  <td align="right" valign="bottom" class="nav" nowrap="nowrap"><span class="gensmall"><? echo "<a href='newtopic.php?id=" . $validforum . "'>Start new topic</a>"; ?></span></td>
	-->
        <td align="right" valign="bottom" class="nav" nowrap="nowrap"><span class="gensmall">  <a href='newtopic.php'>Start new topic</a> </span></td>
 </tr>
  </table>

  <table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline">
	<tr>
	  <th align="center" height="25" class="thCornerL" nowrap="nowrap">&nbsp;Topics&nbsp;</th>
	  <th width="50" align="center" class="thTop" nowrap="nowrap">&nbsp;Replies&nbsp;</th>
	  <th width="100" align="center" class="thTop" nowrap="nowrap">&nbsp;Author&nbsp;</th>
	  <th align="center" class="thCornerR" nowrap="nowrap">Date Posted</th>
	</tr>
	  
<!--// name of the current forum and breadcrumb*/ -->
<?php
$topicsql = "SELECT MAX( messages.date ) AS maxdate, topics.id AS topicid, topics.*, users.*
FROM messages, topics, users WHERE messages.topic_id = topics.id AND topics.user_id = users.id
AND topics.forum_id = " . $validforum . " GROUP BY messages.topic_id ORDER BY maxdate DESC;";

$topicresult = mysqli_query($dbc,$topicsql);
$topicnumrows = mysqli_num_rows($topicresult);

if($topicnumrows > 0) {
	while($topicrow = mysqli_fetch_array($topicresult)) {
            //while($topicrow = mysql_fetch_assoc($topicresult)) {
	$msgsql = "SELECT id FROM messages WHERE topic_id = " . $topicrow['topicid'];
	$msgresult = mysqli_query($dbc,$msgsql);
	$msgnumrows = mysqli_num_rows($msgresult);
        $NUMOFREPLIES=$msgnumrows-1; // so it doesnt mix the number of rows with number of reply. with #of rows it displays the post itself as reply. 

	echo "<tr>";
	echo "<td style=\"background: #EFEFEF\">";
           
	if (isset($_SESSION['ADMIN'])) {
 echo "[<a href=\"delete.php?func=thread&id={$topicrow['topicid']}\".\"?forum={$validforum}\">X</a>] - "; //deletes topic inside forum
	}

	echo "<strong><a style=\"text-decoration: none;\" href='viewmessages.php?id=" . $topicrow['topicid'] . "'>" . $topicrow['subject'] . "</a></strong></td>";
	echo "<td style=\"background: #DEE3E7\">" . $NUMOFREPLIES . "</td>";
	echo "<td style=\"background: #DEE3E7\">" . $topicrow['username'] . "</td>";
	echo "<td style=\"background: #DEE3E7\">" . date("D jS F Y g:iA", strtotime($topicrow['date'])) . "</td>"; // jS = rd 3rd. 2nd
	echo "</tr>";
}
}
?>	 	  
  </table>
</form>

        </td>
	</tr>
</table>

<?php
require("includes/footer.php");
?>