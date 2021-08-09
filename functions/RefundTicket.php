<?php
	session_start();
	require '../dbConnection.php';
	
	if (empty($_GET['PaymentID'])) {
		$_SESSION['sessionmessage'] = "Please select a ticket to email";
		header("Location: ../ticketspurchased.php");
		die();
	}
	
	$payment = htmlspecialchars(nl2br(strip_tags($_GET['PaymentID'])));
	
	$sql = "DELETE FROM TicketHandlings WHERE PaymentID = $payment";
	$result = mysqli_query($conn, $sql) or die("Database Error - ".mysqli_error($conn));
	
	$sql = "DELETE FROM payments WHERE PaymentID = $payment";
	$result = mysqli_query($conn, $sql) or die("Database Error - ".mysqli_error($conn));
	
	$_SESSION['sessionmessage'] = "Payment successfully refunded.";
	header("Location: ../ticketspurchased.php");
	die();
?>