<?php //custom functions go here
 

function NumberOfForumsOpened()  
  
{  
 $dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die('Could not connect to MySQL: ' . mysqli_connect_error());

$s="select count(opener) from forums where opener={$_SESSION['USERID']}" or die (myqli_error($dbc));
$q=mysqli_query($dbc, $s);
$r=  mysqli_fetch_array($q);
echo"<b> {$_SESSION['USERNAME']}, you have opened $r[0] forum(s) so far</b>";
  
}
?>