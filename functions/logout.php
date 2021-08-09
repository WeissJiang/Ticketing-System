<?php
	session_start();
	session_unset();
	session_destroy();
	
	session_start();
	$_SESSION['sessionmessage'] = "Successfully Logged Out";
	header("Location: ../homepage.php");
	die();
?>