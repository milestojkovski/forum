

<?php

# Script 17.x - mysqli_connect.php
// This file contains the database access information. 
// This file also establishes a connection to MySQL 
// and selects the database.
// Set the database access information as constants:
DEFINE('DB_USER', 'root');
DEFINE('DB_PASSWORD', '');
DEFINE('DB_HOST', 'localhost');
DEFINE('DB_NAME', 'testforum');

// Make the connection:
$dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die('Could not connect to MySQL: ' . mysqli_connect_error());

// Set the encoding...
mysqli_set_charset($dbc, 'utf8');

// Use this next option if your system doesn't support mysqli_set_charset().
//mysqli_query($dbc, 'SET NAMES utf8');

$config_forumsname = "Discussion Forum";
/*
  $config_admin = "Mile Stojkovski";
  $config_adminemail = "milestojkovski@gmail.com";
 * 
 */

$url_home = 'index.php';
$config_basedir = "http://127.0.0.1:8000/forums";
?>





