<?php
	session_start();
	require '../dbConnection.php';
	$loggedOn = isset($_SESSION['userid']);
	if ($loggedOn) {
		$UserID = $_SESSION['userid'];
		$SessionType = $_SESSION['sessiontype'];
		$sql = "SELECT * FROM customers WHERE CustomerID = '$UserID'";
		$result = mysqli_query($conn, $sql) or die("Database Error - ".mysqli_error($conn));
		$customer = mysqli_fetch_all($result)[0];
	} else if (!$loggedOn && empty($_SESSION['Unregisteredpayment'])) {
		$_SESSION['sessionmessage'] = "You have not purchased a ticket yet";
		header("Location: ../homepage.php");
		die ();
	} else {
		$customer = $_SESSION['non-customer'];
	}
	
	if (empty($_GET['TicketString'])) {
		$_SESSION['sessionmessage'] = "Please select a ticket to email";
		header("Location: ../ticketspurchased.php");
		die();
	}
	
	$ticketIDs = htmlspecialchars(nl2br(strip_tags($_GET['TicketString'])));
	$ticketIDs = explode(",", $ticketIDs);
	
	if (count($ticketIDs) != 3) {
		$_SESSION['sessionmessage'] = "An error had occurred, please try again";
		header("Location: ../ticketspurchased.php");
		die();
	}
	
	$sql = "SELECT * FROM buses WHERE BusNumber = $ticketIDs[0]";
	$result = mysqli_query($conn, $sql) or die("Database Error - ".mysqli_error($conn));
	$Bus = mysqli_fetch_all($result);
	$sql = "SELECT * FROM tickets WHERE TicketID = $ticketIDs[1]";
	$result = mysqli_query($conn, $sql) or die("Database Error - ".mysqli_error($conn));
	$ticket = mysqli_fetch_all($result);
	$sql = "SELECT * FROM payments WHERE PaymentID = $ticketIDs[2]";
	$result = mysqli_query($conn, $sql) or die("Database Error - ".mysqli_error($conn));
	$payment = mysqli_fetch_all($result);
	
	if (count($Bus) != 1 || count($ticket) != 1 || count($payment) != 1) {
		$_SESSION['sessionmessage'] = "Your purchase was not found";
		header("Location: ../ticketspurchased.php");
		die();
	}
	
	$Bus = $Bus[0];
	$ticket = $ticket[0];
	$payment = $payment[0];
	
	if ($loggedOn) {
		$to = $customer[7] . "";
	} else {
		$to = $customer[0] . "";
	}
	
	$subject = "KTS E-Ticket for ";
	if ($loggedOn) {
		$fullname = $customer[2] . " " . $customer[3];
	} else {
		$fullname =  $customer[1] . " " . $customer[2];
	}
	$subject .= $fullname;
	
	$message = '
	<html>
	<head>
		<title>'.$subject.'</title>
		<style>
		.table2{
			margin: 80px auto 0 auto;
			width: 80%;
			border: 1px solid black;
			color: black;
			background-color: white;
			opacity: 0.8;
		}

		.table2 th, td{
			padding: 12px;
			text-align: left;
			border: none;
		}
		</style>
	</head>
	<body>
		<div class="paymentprint">
		<table class="table2">
		<td colspan="3">
		<h3>KTS Payment Information and Tickets</h3> <br>';
		if (!is_null($customer[1]) && $loggedOn) {
			$message .= $customer[1] . " ";
		} else if (!is_null($customer[3]) && !$loggedOn) {
			$message .= $customer[3] . " ";
		}
		$message .= $fullname.'<br>
		'.$Bus[2].' to '.$Bus[3].'<br>';
	$RouteSQL = "SELECT * FROM Routes WHERE busnumber = ".$Bus[0];
	$result = mysqli_query($conn, $RouteSQL) or die("Database Error - ".mysqli_error($conn));
	$Routelist = mysqli_fetch_all($result);
	if (count($Routelist) > 0) {
		$message .= "via";
		for ($ii = 0; $ii < count($Routelist); $ii++) {
			if (($ii + 1) == count($Routelist)) {
				$message .= " ".$Routelist[$ii][1];
			} else {
				$message .= " ".$Routelist[$ii][1].",";
			}
		}
		$message .= " <br>";
	}
	$DDate = explode("-", $Bus[1]);
	$message .= "Departing Date: " . $DDate[2] . "/" . $DDate[1] . "/" . $DDate[0] . "<br>";
	$message .= "Bus Summary: " . $Bus[4] . " " . $Bus[5] . "<br>";
	$message .= "</td>";
	$message .= "<tr>
	<td>Payment ID</td>
	<td>Bus Number</td>
	<td>Customer ID</td>
	</tr><tr>";
	$message .= '<td>' . $payment[0] . '</td>';
	$message .= '<td>' . $Bus[0] . '</td>';
	if ($loggedOn) {
		$message .= '<td>'.$UserID.'</td>';
	} else {
		$message .= '<td>N/A</td>';
	}
	$message .= "</tr>";
	if (empty($ticket[4])) {
		$ticketdiscount = 1;
	} else {
		$ticketdiscount = (1 - $ticket[4]);
	}
	$THSQL = "SELECT * FROM TicketHandlings WHERE PaymentID = $payment[0]";
	$result = mysqli_query($conn, $THSQL) or die("Database Error - ".mysqli_error($conn));
	$THresultlist = mysqli_fetch_all($result);
	$totalcost = 0;
	for ($iiii = 0; $iiii < count($THresultlist); $iiii++) {
		$TH = $THresultlist[$iiii];
		if ($TH[3] == 'Infant') {
			$customertypediscount = 0.6;
		} else if ($TH[3] == 'Child') {
			$customertypediscount = 0.8;
		} else {
			$customertypediscount = 1;
		}
		$ticketcost = (($ticket[2] * $customertypediscount) * $ticketdiscount);
		$totalcost += $ticketcost;
		$message .= "<tr>
		<td>- - - - - - - - - -</td>
		<td>- - - - - - - - - -</td>
		<td>- - - - - - - - - -</td>
		</tr>";
		$message .= "<tr>
		<td>Ticket Number</td>
		<td>Customer Type</td>
		<td>Ticket Cost</td>
		</tr><tr>";
		$message .= "<td>" . $TH[0] . "</td>";
		$message .= "<td>" . $TH[3] . "</td>";
		$message .= "<td> $" . round($ticketcost, 2) . "</td>";
		$message .= "</tr>";
	}
	$message .= "<tr>
	<td>- - - - - - - - - -</td>
	<td>- - - - - - - - - -</td>
	<td>- - - - - - - - - -</td>
	</tr>";
	$message .= "<tr>
	<td>Customer Email</td>
	<td>Total Amount of Tickets</td>
	<td>Total Cost</td>
	</tr><tr>";
	if ($loggedOn) {
		$message .= "<td>" . $customer[7] . "</td>";
	} else {
		$message .= "<td>" . $customer[0] . "</td>";
	}
	$message .= "<td>" . count($THresultlist) . "</td>";
	$message .= "<td> $" . round($totalcost, 2) . "</td>";
	$message .= "</tr>";
	$message .= "</table></div>
	</body>
	</html>
	";
	
	//echo $message;
	
	$headers = "MIME-Version: 1.0 \r\n";
	$headers .= "Content-type:text/html;charset=UTF-8 \r\n";
	$headers .= 'From: KTSTickets@joshuaassessment4.altervista.org \r\n';
	
	$success = mail($to,$subject,$message,$headers);
	
	if ($success == False) {
		$_SESSION['sessionmessage'] = "Email was not successfully sent, please try again.";
		header("Location: ../ticketspurchased.php");
		die();
	} else {
		$_SESSION['sessionmessage'] = "Email successfully sent.";
		header("Location: ../ticketspurchased.php");
		die();
	}
?>