<?php
session_start();
$pagename = "List of Forum that you have opened";
require("includes/config.php");
require("includes/header.php");
require ("includes/inner-top.php");

$s="SELECT forums.name, forums.id  FROM forums WHERE opener={$_SESSION['USERID']}";
$q=  mysqli_query($dbc, $s) or die (mysqli_error($dbc));

while ($row=  mysqli_fetch_array($q)){
 echo "<br> <a href='viewforum.php?id=" . $row['id'] . "'>" . $row['name'] . "</a></small><br><br>"; 

};

require ("includes/inner-bottom.php");
require("includes/footer.php");
?>