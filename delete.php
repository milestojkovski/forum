<?php
include("includes/config.php");
session_start();
/*$dbhost = "localhost";
$dbuser = "root";
$dbpassword = "";
$dbdatabase = "testforum";
$db = mysql_connect($dbhost, $dbuser, $dbpassword);
mysql_select_db($dbdatabase, $db);*/
if(!$_SESSION['ADMIN']) {
	die("Access denied.");
}
if(isset($_GET['id'])) {
	if(!is_numeric($_GET['id'])) {
        header("Location: " . $config_basedir);	
	}
	else {
		$validid = $_GET['id'];
                echo"$validid";
	}
}
else {
	//header("Location: " . $config_basedir);
}
switch($_GET['func']) {
	case "cat":// deletes category
		$delsql = "DELETE FROM categories WHERE id = " . $validid . ";";
		mysqli_query($dbc,$delsql);
		header("Location: " . $config_basedir);
	break;
        case "forum": // deleted forum 
		$delsql = "DELETE FROM forums WHERE id = " . $validid . ";";
		mysqli_query($dbc,$delsql);
		header("Location: " . $config_basedir);
	break;
        case "thread": // deletes topics indise forum 
		$delsql = "DELETE FROM topics WHERE id = " . $validid . ";";
		mysqli_query($dbc,$delsql);
		//header("Location: " . $config_basedir . "/viewforum.php?id=" . $_GET['id']);
                		//header("Location: " . $config_basedir . "/viewforum.php");
	break;
    
    case "msg":// delees message, replies
		$delsql = "DELETE FROM messages WHERE id = " . $validid . ";";
		mysqli_query($dbc,$delsql);
		header("Location: " . $config_basedir . "/viewmessages.php?id=". $_GET['id']);
    
    
	default:
		header("Location: " . $config_basedir);
	break;
}
?>