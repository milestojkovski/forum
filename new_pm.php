<?php
session_start();
$pagename = "new pesonal message";
require("includes/config.php");
require("includes/header.php");
require ("includes/inner-top.php");

?>
<html>
    <head>
        
        <title>New PM</title>
    </head>
    <body>
    	
<?php
//We check if the user is logged
if(isset($_SESSION['USERNAME']))
{
$form = true;
$otitle = '';
$orecip = '';
$omessage = '';
//We check if the form has been sent
if(isset($_POST['title'], $_POST['recip'], $_POST['message']))
{
	$otitle = $_POST['title'];
	$orecip = $_POST['recip'];
	$omessage = $_POST['message'];
	//We remove slashes depending on the configuration
	if(get_magic_quotes_gpc())
	{
		$otitle = stripslashes($otitle);
		$orecip = stripslashes($orecip);
		$omessage = stripslashes($omessage);
	}
	//We check if all the fields are filled
	if($_POST['title']!='' and $_POST['recip']!='' and $_POST['message']!='')
	{
		//We protect the variables
		$title = mysql_real_escape_string($otitle);
		$recip = mysql_real_escape_string($orecip);
		$message = mysql_real_escape_string(nl2br(htmlentities($omessage, ENT_QUOTES, 'UTF-8')));
		//We check if the recipient exists
		$dn1 = mysqli_fetch_array(mysqli_query($dbc,'select count(id) as recip, id as recipid, (select count(*) from pm) as npm from users where username="'.$recip.'"'));
		if($dn1['recip']==1)
		{
			//We check if the recipient is not the actual user
			if($dn1['recipid']!=$_SESSION['USERID'])
			{
				$id = $dn1['npm']+1;
				//We send the message
				if(mysqli_query($dbc,'insert into pm (id, id2, title, user1, user2, message, timestamp, user1read, user2read)values("'.$id.'", "1", "'.$title.'", "'.$_SESSION['USERID'].'", "'.$dn1['recipid'].'", "'.$message.'", "'.time().'", "yes", "no")'))
				{
?>
<div class="message">The message has successfully been sent.<br />
<a href="list_pm.php">List of my personal messages</a></div>
<?php
					$form = false;
				}
				else
				{
					//Otherwise, we say that an error occured
					$error = 'An error occurred while sending the message';
				}
			}
			else
			{
				//Otherwise, we say the user cannot send a message to himself
				$error = 'You cannot send a message to yourself.';
			}
		}
		else
		{
			//Otherwise, we say the recipient does not exists
			$error = 'The recipient does not exists.';
		}
	}
	else
	{
		//Otherwise, we say a field is empty
		$error = 'A field is empty. Please fill of the fields.';
	}
}
elseif(isset($_GET['recip']))
{
	//We get the username for the recipient if available
	$orecip = $_GET['recip'];
}
if($form)
{
//We display a message if necessary
if(isset($error))
{
	echo '<div class="message">'.$error.'</div>';
}
//We display the form
?><!--
<div class="content">
	<h1>New Personnal Message</h1>
    <form action="new_pm.php" method="post">
		Please fill the following form to send a personnal message.<br />
                <p  id="title">  Title  <input type="text" value="<?php echo htmlentities($otitle, ENT_QUOTES, 'UTF-8'); ?>" name="title" /></p>
                <p id="recip">  Recipient<span class="small">(Username)</span><input type="text" value="<?php echo htmlentities($orecip, ENT_QUOTES, 'UTF-8'); ?>"  name="recip" /></p>
                <div id="message">  Message<textarea cols="40" rows="5"  name="message"><?php echo htmlentities($omessage, ENT_QUOTES, 'UTF-8'); ?></textarea></div><br />
        <input type="submit" value="Send" />
    </form>
</div>-->

<table width="100%" cellspacing="0" cellpadding="10" border="0" align="center">
        <tr>
            <td align="center">
                 
                <form action="new_pm.php" method="post">
                    <h5>Please fill the following form to send a personal message.<br /></h5>
                    <table>
    
                        <tr>
                            <td>Title</td>
                            <td>
                               <input type="text" value="<?php echo htmlentities($otitle, ENT_QUOTES, 'UTF-8'); ?>" name="title" />
                            </td>
                        </tr>
    
                    <tr>
                        <td>Name (Username)</td>
                        <td>
                            <input type="text" value="<?php echo htmlentities($orecip, ENT_QUOTES, 'UTF-8'); ?>"  name="recip" />
                        </td>
                    </tr>
                    <tr>
                        <td>Message</td>
                        <td>
                            
                       <textarea cols="40" rows="5"  name="message"><?php echo htmlentities($omessage, ENT_QUOTES, 'UTF-8'); ?></textarea>

                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>        
                            <input type="submit" value="Send" />
                        </td>
                    </tr>
                </table>
            </form>
        </td>
    </tr>
</table>


<?php
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