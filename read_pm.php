<?php
session_start();
$pagename = "read pesonal message";
require("includes/config.php");
?>
<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<html>
    
    <head>       
        <!--this is the icon that appears in the tab. but it doesnt work properly on chrome-->
        <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
        <link rel="icon" href="images/favicon.ico" type="image/x-icon"> 
        
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <meta http-equiv="Content-Style-Type" content="text/css">
        <title>
        <?php
        echo $config_forumsname;
        ?>
        
        </title>
        <title>Discussion Forum</title>
        <link rel="stylesheet" href="css/style.css" type="text/css" />

    </head>
    <body>


<!-- this is the main table below the navigation-->
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
                                                echo "<td><a href='members.php' class='mainmenu'>List of Members</a></td>";
                                            }
                                            echo "<td><a href='addforum.php' class='mainmenu'>New Forum</a></td>";
                                            echo "<td><a href='newtopic.php' class='mainmenu'>New Topic</a></td>";
                                            echo "<td><a href='list_pm.php' class='mainmenu'>Personal Messages</a></td>";


                                            
                                        } else {
                                            echo "<td><a href='login.php' class='mainmenu'>Login</a></td>";
                                            echo "<td><a href='register.php' class='mainmenu'>Register</a></td>";
                                        }

                                        if (isset($_SESSION['USERNAME'])) {


                                            echo"<td>&nbsp;&nbsp;"
                                            . "&nbsp;"
                                            . "&nbsp;"
                                            . "&nbsp;"
                                            . "&nbsp;"
                                            . "&nbsp;</td>";
                                            echo "<td> <small>Currently logged in as:</small><a href=profile.php>{$_SESSION['USERNAME']}</a></td>";
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

                    
<!-- this is the table for add cat,new topic, members, personal message, new forum-->
<table class="forumline" width="100%" cellspacing="1" cellpadding="4" border="0">
	<tr>
		<th class="thHead" height="25"><b><?php echo $pagename; ?></b></th>
	</tr>
	<tr>
		<td class="row1"><table width="100%" cellspacing="0" cellpadding="1" border="0">
			<tr>
				<td align="center"> 
<html>
    <head>
        
        <title>Read a PM</title>
    </head>
    <body>
 
<?php
//We check if the user is logged
if(isset($_SESSION['USERNAME']))
{
//We check if the ID of the discussion is defined
if(isset($_GET['id']))
{
$id = intval($_GET['id']);
//We get the title and the narators of the discussion
$req1 = mysqli_query($dbc,'select title, user1, user2 from pm where id="'.$id.'" and id2="1"');
$dn1 = mysqli_fetch_array($req1);
//We check if the discussion exists
if(mysqli_num_rows($req1)==1)
{
//We check if the user have the right to read this discussion
if($dn1['user1']==$_SESSION['USERID'] or $dn1['user2']==$_SESSION['USERID'])
{
//The discussion will be placed in read messages
if($dn1['user1']==$_SESSION['USERID'])
{
	mysqli_query($dbc,'update pm set user1read="yes" where id="'.$id.'" and id2="1"');
	$user_partic = 2;
}
else
{
	mysqli_query($dbc,'update pm set user2read="yes" where id="'.$id.'" and id2="1"');
	$user_partic = 1;
}
//We get the list of the messages
$q="select pm.timestamp, pm.message, users.id as userid, users.username from pm, users where pm.id='".$id."' and users.id=pm.user1 order by pm.id2";

$req2 = mysqli_query($dbc,$q);
//We check if the form has been sent
if(isset($_POST['message']) and $_POST['message']!='')
{
	$message = $_POST['message'];
	//We remove slashes depending on the configuration
	if(get_magic_quotes_gpc())
	{
		$message = stripslashes($message);
	}
	//We protect the variables
	$message = mysql_real_escape_string(nl2br(htmlentities($message, ENT_QUOTES, 'UTF-8')));
	//We send the message and we change the status of the discussion to unread for the recipient
	if(mysqli_query($dbc,'insert into pm (id, id2, title, user1, user2, message, timestamp, user1read, user2read)values("'.$id.'", "'.(intval(mysqli_num_rows($req2))+1).'", "", "'.$_SESSION['USERID'].'", "", "'.$message.'", "'.time().'", "", "")') and mysqli_query($dbc,'update pm set user'.$user_partic.'read="yes" where id="'.$id.'" and id2="1"'))
	{
?>
<div class="message">Your message has successfully been sent.<br />
<a href="read_pm.php?id=<?php echo $id; ?>">Go to the discussion</a></div>
<?php
	}
	else
	{
?>
<div class="message">An error occurred while sending the message.<br />
<a href="read_pm.php?id=<?php echo $id; ?>">Go to the discussion</a></div>
<?php
	}
}
else
{
//We display the messages
?>

<h1><?php echo $dn1['title']; ?></h1>
<table class="messages_table">
	<tr>
    	<th>User</th>
        <th>Message</th>
        <th>Sent</th>
    </tr>
<?php
while($dn2 = mysqli_fetch_array($req2))
{
?>
	<tr>
    	<td class="author"><br /><?php echo $dn2['username']; ?></td>
        <td><?php echo"<div id=\"amanveke\"> " .$dn2['message']." </div>"; ?></td>
        <td class="date"><?php echo date('m/d/Y H:i:s' ,$dn2['timestamp']); ?></td>
       
    	
    </tr>
<?php
}
//We display the reply form
?>
</table><br />
<h2>Reply</h2>
<div class="center">
    <form action="read_pm.php?id=<?php echo $id; ?>" method="post">
    	<label for="message" class="center">Message</label><br />
        <textarea cols="40" rows="5" name="message" id="message"></textarea><br />
        <input type="submit" value="Send" />
    </form>
</div>

<?php
}
}
else
{
	echo '<div class="message">You dont have the rights to access this page.</div>';
}
}
else
{
	echo '<div class="message">This discussion does not exists.</div>';
}
}
else
{
	echo '<div class="message">The discussion ID is not defined.</div>';
}
}
else
{
	echo '<div class="message">You must be logged to access this page.</div>';
}
?>
    </body>
</html>
<?php
require ("includes/inner-bottom.php");
require("includes/footer.php");
?>
