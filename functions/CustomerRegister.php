<?php
	session_start();
	require '../dbConnection.php';
	
	if (empty($_POST['email']) || empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['address']) || empty($_POST['password']) || empty($_POST['confirm_password'])) {
		$_SESSION['sessionmessage'] = "Please fill in all required fields";
		header("Location: ../registrationpage.php");
		die();
	}
	
	$email = htmlspecialchars(nl2br(strip_tags($_POST['email'])));
	$firstname = htmlspecialchars(nl2br(strip_tags($_POST['firstname'])));
	$lastname = htmlspecialchars(nl2br(strip_tags($_POST['lastname'])));
	$address = htmlspecialchars(nl2br(strip_tags($_POST['address'])));
	$password = hash('crc32b', htmlspecialchars(nl2br(strip_tags($_POST['password']))));
	$title = htmlspecialchars(nl2br(strip_tags($_POST['title'])));
	$dateofbirth = htmlspecialchars(nl2br(strip_tags($_POST['dateofbirth'])));
	$phonenumber = htmlspecialchars(nl2br(strip_tags($_POST['phonenumber'])));
	
	if ($title == "none")  {
		$title = "NULL";
	} else {
		$title = "'$title'";
	}
	if (empty($dateofbirth)) {
		$dateofbirthI = "NULL";
	} else {
		$dateofbirthI = "STR_TO_DATE('$dateofbirth', '%Y-%m-%d')";
	}
	if (empty($phonenumber)) {
		$phonenumber = "NULL";
	} else {
		$phonenumber = "'$phonenumber'";
	}
	
	$sql = "SELECT customerid FROM customers WHERE email = '$email'";
    $result = mysqli_query($conn, $sql) or die("Database Error - ".mysqli_error($conn));
    $resultlist = mysqli_fetch_all($result);
	if (count($resultlist) != 0) {
		$_SESSION['sessionmessage'] = "Your email has already been taken. Please input a unique email.";
		header("Location: ../registrationpage.php");
		die();
	}
	
	$sql = "INSERT INTO customers (title, firstname, lastname, password, dateofbirth, address, email, phonenumber)
	VALUES ($title, '$firstname', '$lastname', '$password', $dateofbirthI, '$address', '$email', $phonenumber);";
	
	echo $sql . "<br>";
	
	mysqli_query($conn, $sql) or die("Database Error - ".mysqli_error($conn));
	
	$sql = "SELECT customerid FROM customers WHERE email = '$email';";
    $result = mysqli_query($conn, $sql) or die("Database Error - ".mysqli_error($conn));
    $resultlist = mysqli_fetch_all($result);
	
	if (count($resultlist) != 1) {
		echo "An error has occurred in the Database <br>";
		for ($i = 0; $i < count($resultlist); $i++) {
			$row = $resultlist[$i];
			echo "$row[0]";
		}
		die();
	}
	
	$_SESSION['userid'] = $resultlist[0][0];
	$_SESSION['sessiontype'] = "customer";
	$_SESSION['sessionmessage'] = "Thank You $firstname for registering with KTS";
	header("Location: ../homepage.php");
	die();
?>