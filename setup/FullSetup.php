<?php
	// Comment out this line if setup is needed, do NOT publish this document with this line uncommented
	// die ("The full setup page is only to be used by developers!");
	
	require '../dbConnection.php';
    
    $TableExists = mysqli_query($conn, 'select "news" from buses LIMIT 1');
    
    if ($TableExists == false) {
    	require 'TicketingSystemDBsetup.php';
    } else {
    	require 'TicketingSystemDBreset.php';
    }
    require 'newDataSetup.php';
?>