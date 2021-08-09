<?php
	session_start();
	$loggedOn = isset($_SESSION['userid']);
	if ($loggedOn) {
		$UserID = $_SESSION['userid'];
		$SessionType = $_SESSION['sessiontype'];
	}
	
	if (empty($_POST['email']) || empty($_POST['fname']) || empty($_POST['lname']) || empty($_POST['phonenumber'])) {
		$_SESSION['sessionmessage'] = "Please fill in all required fields";
		header("Location: ../contactpage.php");
		die();
	}
	
	// http://api.clickatell.com/http/sendmsg?to=61422554103&msg=ticketmessage - HTTP SMS, Just without API key
	
	$email = htmlspecialchars(nl2br(strip_tags($_POST['email'])));
	$firstname = htmlspecialchars(nl2br(strip_tags($_POST['fname'])));
	$lastname = htmlspecialchars(nl2br(strip_tags($_POST['lname'])));
	$phonenumber = htmlspecialchars(nl2br(strip_tags($_POST['phonenumber'])));
	$subject = htmlspecialchars(nl2br(strip_tags($_POST['subject'])));
	$message = htmlspecialchars(nl2br(strip_tags($_POST['message'])));
	
	$to = "$email";
	if (empty($_POST['subject'])) {
		$subject = "Contact form email";
	}
	if (empty($_POST['message'])) {
		$message = "$firstname has decided to send you an email";
	}
	
	$message = "
	<html>
	<head>
		<title>$subject</title>
	</head>
	<body>
		<h1>$subject</h1>
		<p>First Name: $firstname</p>
		<p>Last Name: $lastname</p>
		<p>Phone Number: $phonenumber</p>
		<br>
		<p>$message</p>
	</body>
	</html>
	";
	
	$headers = "MIME-Version: 1.0 \r\n";
	$headers .= "Content-type:text/html;charset=UTF-8 \r\n";
	$headers .= 'From: contact@joshuaassessment4.altervista.org \r\n';
	if ($loggedOn) {
		require '../dbConnection.php';
		$sql = "SELECT email FROM customers WHERE CustomerID = $UserID";
		$result = mysqli_query($conn, $sql) or die("Database Error - ".mysqli_error($conn));
		$resultlist = mysqli_fetch_all($result);
		$UserEmail = $resultlist[0][0];
		if ($UserEmail != $email) {
			$headers .= "Cc: $UserEmail \r\n";
		}
	}
	$success = mail($to,$subject,$message,$headers);
	
	if ($success == False) {
		$_SESSION['sessionmessage'] = "Send was unsuccessful, please try again.";
		header("Location: ../contactpage.php");
		die();
	} else {
		$_SESSION['sessionmessage'] = "Email successfully sent.";
		header("Location: ../contactpage.php");
		die();
	}
?>