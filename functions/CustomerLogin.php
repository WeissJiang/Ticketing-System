<?php
	session_start();
	require '../dbConnection.php';
	
	if (empty($_POST['email']) || empty($_POST['password'])) {
		$_SESSION['sessionmessage'] = "Please enter an Email Address and Password";
		header("Location: ../loginpage.php");
		die();
	}
	
	$email = htmlspecialchars(nl2br(strip_tags($_POST['email'])));
	$password = hash('crc32b', htmlspecialchars(nl2br(strip_tags($_POST['password']))));
	
	$sql = "SELECT customerid, firstname FROM customers WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $sql) or die("Database Error - ".mysqli_error($conn));
    $resultlist = mysqli_fetch_all($result);
	
	if (count($resultlist) != 1) {
		$_SESSION['sessionmessage'] = "Invaild Email or Password";
		header("Location: ../loginpage.php");
		die();
	}
	
	$_SESSION['userid'] = $resultlist[0][0];
	$_SESSION['sessiontype'] = "customer";
	$firstname = $resultlist[0][1];
	$_SESSION['sessionmessage'] = "Welcome $firstname";
	header("Location: ../homepage.php");
	die();
?>