<?php
session_start();
$pagename = "List of members";
require("includes/config.php");
require("includes/header.php");
require ("includes/inner-top.php");



// This script retrieves all the records from the users table.
// This new version allows the results to be sorted in different ways.



// Number of records to show per page:
$display = 10;

// Determine how many pages there are...
if (isset($_GET['p']) && is_numeric($_GET['p'])) { // Already been determined.
	$pages = $_GET['p'];
} else { // Need to determine.
 	// Count the number of records:
	$q = "SELECT COUNT(id) FROM users";
	$r = @mysqli_query ($dbc, $q);
	$row = @mysqli_fetch_array ($r, MYSQLI_NUM);
	$records = $row[0];
	        echo"There are $row[0] users registered.";

	// Calculate the number of pages...
	if ($records > $display) { // More than 1 page.
		$pages = ceil ($records/$display);
	} else {
		$pages = 1;
	}
} // End of p IF.

// Determine where in the database to start returning results...
if (isset($_GET['s']) && is_numeric($_GET['s'])) {
	$start = $_GET['s'];
} else {
	$start = 0;
}

// Determine the sort...
// Default is by registration date.
$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'rd';
// Determine the sorting order:
switch ($sort) {
	
            case 'us':
		$order_by = 'username DESC';
		break;
	case 'em':
		$order_by = 'email ASC';
		break;
            
	case 'rd':
		$order_by = 'registration_date ASC';
		break;
	default:
		$order_by = 'registration_date ASC';
		$sort = 'rd';
		break;
}
	
// Define the query:
$q = "SELECT username, DATE_FORMAT(registration_date, '%M %d, %Y') AS dr, email, id, ban FROM users ORDER BY $order_by LIMIT $start, $display";		
$r = @mysqli_query ($dbc, $q); // Run the query.

// Table header:
echo '<table width=\"100%\" align="center" cellspacing="0" cellpadding="5" width="75%">
<tr>
	
	<td align="left"><b><a href="members.php?sort=us">Username</a></b></td>
	<td align="left"><b><a href="members.php?sort=em">Email</a></b></td>
	<td align="left"><b><a href="members.php?sort=rd">Date Registered</a></b></td>
        <td align="left"><b>Delete</b></td>
        

        
</tr>
';

// Fetch and print all the records....
$bg = '#eeeeee'; 
while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) { // to be done.
	$bg = ($bg=='#00CC00' ? '#fffff' : '#00CC00');
		echo '<tr bgcolor="' . $bg . '">
                    
		<td align="left">' . $row['username'] . '</td>
		<td align="left">' . $row['email'] . '</td>
		<td align="left">' . $row['dr'] . '</td>
		<td align="left"><a href="delete_member.php?id=' . $row['id'] . '">Delete</a></td>
                    ';
               if ($row['ban']==0){echo'<td align="left"><a href="ban_member.php?id=' . $row['id'] . '">Ban</a></td>';}
               if ($row['ban']==1){echo'<td align="left"><a href="unban_member.php?id=' . $row['id'] . '">Un Ban</a></td>';}
                echo'
                

</font>
		
	</tr>
	';
} // End of WHILE loop.

echo '</table>';


// Make the links to other pages, if necessary.
if ($pages > 1) {
	
	echo '<br /><p>';
	$current_page = ($start/$display) + 1;
	
	// If it's not the first page, make a Previous button:
	if ($current_page != 1) {
		echo '<a href="members.php?s=' . ($start - $display) . '&p=' . $pages . '&sort=' . $sort . '">Previous</a> ';
	}
	
	// Make all the numbered pages:
	for ($i = 1; $i <= $pages; $i++) {
		if ($i != $current_page) {
			echo '<a href="members.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort . '">' . $i . '</a> ';
		} else {
			echo $i . ' ';
		}
	} // End of FOR loop.
	
	// If it's not the last page, make a Next button:
	if ($current_page != $pages) {
		echo '<a href="members.php?s=' . ($start + $display) . '&p=' . $pages . '&sort=' . $sort . '">Next</a>';
	}
	
	echo '</p>'; // Close the paragraph.
	
} // End of links section.
	
require ("includes/inner-bottom.php");
require("includes/footer.php");
?>