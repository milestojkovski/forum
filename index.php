<script type="text/javascript" src="jquery-2.1.1.js" charset="utf-8"></script>
<div id="fb-root"></div>
<script>(function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id))
            return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
<?php
$config_forumsname = "Discussion Forum";
require("includes/header.php");
?>

<table>
    <tr>
        <td align="left" valign="middle" width="50">&nbsp;</td>
        <td align="left" valign="middle" class="nav" width="100%">&nbsp;</td>
        <td align="right" valign="bottom" class="nav" nowrap="nowrap"><span class="gensmall">
                <a href='newtopic.php'>Start new topic</a> </span></td>
    </tr>
</table>
<!-- this is the main table on index page where the categoris and forums are displayed-->
<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
    <tr>
        <th class="thCornerL" height="25" nowrap="nowrap">&nbsp;Forum&nbsp;</th>
        <th width="50" class="thTop" nowrap="nowrap">&nbsp;Topics&nbsp;</th>
    </tr>

    <?php
    require("includes/config.php");
    $q = "SELECT * FROM categories;";
    $r = mysqli_query($dbc, $q);


    echo mysql_error();

    while ($catrow = mysqli_fetch_array($r, MYSQLI_ASSOC)) {

        echo "
  <tr>
	<td class=\"catLeft\" colspan=\"2\" height=\"28\"><span class=\"cattitle\">";
        if (isset($_SESSION['ADMIN'])) { 
            echo "[<a href=\"delete.php?func=cat&id={$catrow['id']}\">X</a>] - "; // DELETED CATEGORY 
        }
        echo "<span class=\"cattitle\">$catrow[name]</span></span></td>
  </tr>";

        /* check if any category has forums */
        $forumsql = "SELECT * FROM forums WHERE cat_id = " . $catrow['id'] . ";";
        $forumresult = mysqli_query($dbc, $forumsql);
        $forumnumrows = mysqli_num_rows($forumresult);

        if ($forumnumrows == 0) {
            echo "<tr><td>No forums!</td></tr>";
        } else {

            while ($forumrow = mysqli_fetch_array($forumresult, MYSQLI_ASSOC)) {

                $topicsql = "SELECT id FROM topics WHERE forum_id = " . $forumrow['id'];
                $topicresult = mysqli_query($dbc, $topicsql);
                $topicnumrows = mysqli_num_rows($topicresult); // count the right number (the number of topic inside forum)

                echo "<tr>
	<td class=\"row1\" width=\"100%\" height=\"50\" style=\"padding-left: 10px;\">";
                if (isset($_SESSION['ADMIN'])) {

                    echo "<small>[<a href=\"delete.php?func=forum&id={$forumrow['id']}\">X</a>] - </small>"; // DELETES FORUM. (under category)
                }
                echo "<span class=\"forumlink\"><a class=\"forumlink\" href='viewforum.php?id=" . $forumrow['id'] . "'>" . $forumrow['name'] . "</a><br />
	  </span> <span class=\"genmed\">$forumrow[description]<br />
	  </span><span class=\"gensmall\">&nbsp; &nbsp;</span></td>
	<td class=\"row2\" align=\"center\" valign=\"middle\" height=\"50\"><span class=\"gensmall\">$topicnumrows</span></td>
  </tr>";
            }
        }
    }
    echo "</table>";
    require("includes/footer.php");
    ?>
