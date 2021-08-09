<?php
	session_start();
	require '../dbConnection.php';
	
	$loggedOn = isset($_SESSION['userid']);
	if ($loggedOn) {
		$UserID = $_SESSION['userid'];
		$SessionType = $_SESSION['sessiontype'];
	} else {
		$UserID = 'NaN';
	}
	
	if (empty($_POST['TicketID']) || empty($_POST['CardNumber']) || empty($_POST['CardName']) || empty($_POST['Expiration']) || empty($_POST['CCV']) || empty($_POST['Postcode'])) {
		$_SESSION['sessionmessage'] = "Fields were found empty, please try again";
		header("Location: ../searchpage.php");
		die();
	}
	
	$TicketID = htmlspecialchars(nl2br(strip_tags($_POST['TicketID'])));
	$CardNumber = hash('crc32b', htmlspecialchars(nl2br(strip_tags($_POST['CardNumber']))));
	$CardName = htmlspecialchars(nl2br(strip_tags($_POST['CardName'])));
	$Expiration = htmlspecialchars(nl2br(strip_tags($_POST['Expiration'])));
	$CCV = hash('crc32b', htmlspecialchars(nl2br(strip_tags($_POST['CCV']))));
	$Postcode = htmlspecialchars(nl2br(strip_tags($_POST['Postcode'])));
	$PreferredSeat = htmlspecialchars(nl2br(strip_tags($_POST['PreferredSeat'])));
	$PreferredSeatSide = htmlspecialchars(nl2br(strip_tags($_POST['PreferredSeatSide'])));
	$Adults = (int) htmlspecialchars(nl2br(strip_tags($_POST['Adults'])));
	$Children = (int) htmlspecialchars(nl2br(strip_tags($_POST['Children'])));
	$Infants = (int) htmlspecialchars(nl2br(strip_tags($_POST['Infants'])));
	
	if ($PreferredSeat == "none")  {
		$PreferredSeat = "NULL";
	} else {
		$PreferredSeat = "'$PreferredSeat'";
	}
	
	if ($PreferredSeatSide == "none")  {
		$PreferredSeatSide = "NULL";
	} else {
		$PreferredSeatSide = "'$PreferredSeatSide'";
	}
	
	$sql = "
	SELECT * FROM TicketHandlings
	INNER JOIN payments ON TicketHandlings.PaymentID = payments.PaymentID
	WHERE payments.TicketID = $TicketID";
	$result = mysqli_query($conn, $sql) or die("Database Error - ".mysqli_error($conn));
	$resultlist = mysqli_fetch_all($result);
	$ticketpurchased = count($resultlist);
	
	$sql = "SELECT TicketAvailable FROM tickets WHERE ticketID = $TicketID";
	$result = mysqli_query($conn, $sql) or die("Database Error - ".mysqli_error($conn));
	$resultlist = mysqli_fetch_all($result);
	$TicketsAvaiable = (int) $resultlist[0][0];
	$TicketsLeft = $TicketsAvaiable - $ticketpurchased;
	
	if (($Adults + $Children + $Infants) > $TicketsLeft) {
		$_SESSION['sessionmessage'] = "You cannot purchase more tickets than was is avaiable ($TicketsLeft) ";
		header("Location: ../paymentpage.php?TicketID=$TicketID");
		die();
	}
	
	if ($loggedOn) {
		$sql = "SELECT CustomerID FROM customers WHERE CustomerID = '$UserID'";
		$result = mysqli_query($conn, $sql) or die("Database Error - ".mysqli_error($conn));
		$resultlist = mysqli_fetch_all($result);
		$CustomerID = $resultlist[0][0];
		
		$sql = "SELECT PaymentID FROM payments WHERE TicketID = '$TicketID' AND CustomerID = '$CustomerID'";
		$result = mysqli_query($conn, $sql) or die("Database Error - ".mysqli_error($conn));
		$resultlist = mysqli_fetch_all($result);
		if (count($resultlist) != 0) {
			$_SESSION['sessionmessage'] = "You have already made a purchase for this ticket, please cancel the first purchase before buying again.";
			header("Location: ../paymentpage.php?TicketID=$TicketID");
			die();
		}
		$sql = "INSERT INTO payments (CustomerID, TicketID, CardNumber, ExpiryDate, CCV)
		VALUES ($CustomerID, '$TicketID', '$CardNumber', STR_TO_DATE('$Expiration', '%Y-%m-%d'), '$CCV')";
	} else {
		$email = htmlspecialchars(nl2br(strip_tags($_POST['email'])));
		$sql = "SELECT customerid FROM customers WHERE email = '$email'";
		$result = mysqli_query($conn, $sql) or die("Database Error - ".mysqli_error($conn));
		$resultlist = mysqli_fetch_all($result);
		if (count($resultlist) != 0) {
			$_SESSION['sessionmessage'] = "Your email has already been taken by a customer. Please input an unique email.";
			header("Location: ../paymentpage.php?TicketID=$TicketID");
			die();
		}
		
		$sql = "INSERT INTO payments (TicketID, CardNumber, ExpiryDate, CCV)
		VALUES ('$TicketID', '$CardNumber', STR_TO_DATE('$Expiration', '%Y-%m-%d'), '$CCV')";
		$CustomerID = 'NaN';
	}
	
	$result = mysqli_query($conn, $sql) or die("Database Error - ".mysqli_error($conn));
	
	if ($loggedOn) {
		$sql = "SELECT PaymentID FROM payments WHERE TicketID = '$TicketID' AND CustomerID = '$CustomerID'";
		$result = mysqli_query($conn, $sql) or die("Database Error - ".mysqli_error($conn));
		$resultlist = mysqli_fetch_all($result);
		$paymentID = $resultlist[0][0];
	} else {
		$sql = "SELECT PaymentID FROM payments";
		$result = mysqli_query($conn, $sql) or die("Database Error - ".mysqli_error($conn));
		$resultlist = mysqli_fetch_all($result);
		$paymentID = $resultlist[count($resultlist) - 1][0];
	}
	
	for ($i = 0; $i < $Adults; $i++) {
		if ($loggedOn) {
			$sql = "INSERT INTO TicketHandlings (PaymentID, CustomerID, CustomerType, PreferredSeatPosition, PreferredSeatSidePosition)
			VALUES ($paymentID, '$CustomerID', 'Adult', $PreferredSeat, $PreferredSeatSide)";
		} else {
			$sql = "INSERT INTO TicketHandlings (PaymentID, CustomerType, PreferredSeatPosition, PreferredSeatSidePosition)
			VALUES ($paymentID, 'Adult', $PreferredSeat, $PreferredSeatSide)";
		}
	
		$result = mysqli_query($conn, $sql) or die("Database Error - ".mysqli_error($conn));
	}
	
	for ($i = 0; $i < $Children; $i++) {
		if ($loggedOn) {
			$sql = "INSERT INTO TicketHandlings (PaymentID, CustomerID, CustomerType, PreferredSeatPosition, PreferredSeatSidePosition)
			VALUES ($paymentID, '$CustomerID', 'Child', $PreferredSeat, $PreferredSeatSide)";
		} else {
			$sql = "INSERT INTO TicketHandlings (PaymentID, CustomerType, PreferredSeatPosition, PreferredSeatSidePosition)
			VALUES ($paymentID, 'Child', $PreferredSeat, $PreferredSeatSide)";
		}
	
		$result = mysqli_query($conn, $sql) or die("Database Error - ".mysqli_error($conn));
	}
	
	for ($i = 0; $i < $Infants; $i++) {
		if ($loggedOn) {
			$sql = "INSERT INTO TicketHandlings (PaymentID, CustomerID, CustomerType, PreferredSeatPosition, PreferredSeatSidePosition)
			VALUES ($paymentID, '$CustomerID', 'Infant', $PreferredSeat, $PreferredSeatSide)";
		} else {
			$sql = "INSERT INTO TicketHandlings (PaymentID, CustomerType, PreferredSeatPosition, PreferredSeatSidePosition)
			VALUES ($paymentID, 'Infant', $PreferredSeat, $PreferredSeatSide)";
		}
	
		$result = mysqli_query($conn, $sql) or die("Database Error - ".mysqli_error($conn));
	}
	
	if ($loggedOn) {
		$sql = "SELECT firstname FROM customers WHERE CustomerID = '$CustomerID'";
		$result = mysqli_query($conn, $sql) or die("Database Error - ".mysqli_error($conn));
		$resultlist = mysqli_fetch_all($result);
		$firstname = $resultlist[0][0];
		
		$_SESSION['sessionmessage'] = "Thank You $firstname, this has been a successful purchase with KTS";
		header("Location: ../ticketspurchased.php");
		die();
	} else {
		$firstname = htmlspecialchars(nl2br(strip_tags($_POST['firstname'])));
		$lastname = htmlspecialchars(nl2br(strip_tags($_POST['lastname'])));
		$title = htmlspecialchars(nl2br(strip_tags($_POST['title'])));
		$_SESSION['sessionmessage'] = "Thank You for purchasing with KTS to save these tickets please register an account.";
		$_SESSION['Unregisteredpayment'] = $paymentID;
		$nonCustomer = array($email, $firstname, $lastname);
		if (isset($title)) {
			array_push($nonCustomer, $title);
		}
		$_SESSION['non-customer'] = $nonCustomer;
		header("Location: ../ticketspurchased.php");
		die();
	}
?>