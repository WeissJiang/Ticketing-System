<?php
	// Comment out this line if setup is needed, do NOT publish this document with this line uncommented
	// die ("This reset page is only to be used by developers!");
	
	require '../dbConnection.php';
  
	mysqli_query($conn, 'DROP TABLE Routes') or die("Database Error - ".mysqli_error($conn));
	mysqli_query($conn, 'DROP TABLE PrintableTickets') or die("Database Error - ".mysqli_error($conn));
	mysqli_query($conn, 'DROP TABLE MessageTickets') or die("Database Error - ".mysqli_error($conn));
	mysqli_query($conn, 'DROP TABLE EmailTickets') or die("Database Error - ".mysqli_error($conn));
	mysqli_query($conn, 'DROP TABLE TicketHandlings') or die("Database Error - ".mysqli_error($conn));
	mysqli_query($conn, 'DROP TABLE payments') or die("Database Error - ".mysqli_error($conn));
	mysqli_query($conn, 'DROP TABLE tickets') or die("Database Error - ".mysqli_error($conn));
	mysqli_query($conn, 'DROP TABLE buses') or die("Database Error - ".mysqli_error($conn));
	mysqli_query($conn, 'DROP TABLE admins') or die("Database Error - ".mysqli_error($conn));
	mysqli_query($conn, 'DROP TABLE members') or die("Database Error - ".mysqli_error($conn));
	mysqli_query($conn, 'DROP TABLE customers') or die("Database Error - ".mysqli_error($conn));

	echo "<h3>Successfuly Deleted Database</h3>";
	
	require 'TicketingSystemDBsetup.php';
?>