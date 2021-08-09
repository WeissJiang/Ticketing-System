<?php
  // Etablishing a connection to the database TicketingSystem
  $USER = "root";
  $PASSWORD = "pass";
  $DBNAME = "TicketingSystem";
  $conn = mysqli_connect("localhost", $USER, $PASSWORD, $DBNAME) or die("Database connection failed");
?>