<?php
	// Comment out this line if setup is needed, do NOT publish this document with this line uncommented
	// die ("This setup page is only to be used by developers!");

	require '../dbConnection.php';
  
	// For SQL Command Line:
	// CREATE DATABASE TicketingSystem;
  
	$sql = "
	CREATE TABLE admins (
	adminID INT(7) AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(30) NOT NULL,
	password VARCHAR(30) NOT NULL
	)";
	mysqli_query($conn, $sql) or die("Database Error - ".mysqli_error($conn));
	
	$sql = "
	CREATE TABLE customers (
	CustomerID INT(7) AUTO_INCREMENT PRIMARY KEY,
	title ENUM('Mr', 'Mrs', 'Miss'),
	firstname VARCHAR(30) NOT NULL,
	lastname VARCHAR(30) NOT NULL,
	password VARCHAR(20) NOT NULL,
	dateofbirth DATE,
	address VARCHAR(120) NOT NULL,
	email VARCHAR(50) NOT NULL,
	PhoneNumber VARCHAR(12)
	)";
	mysqli_query($conn, $sql) or die("Database Error - ".mysqli_error($conn));
	
	$sql = "
	CREATE TABLE members (
	MembershipID INT(7) AUTO_INCREMENT PRIMARY KEY,
	password VARCHAR(30) NOT NULL,
	CustomerID INT(7) NOT NULL,
	FOREIGN KEY (CustomerID) REFERENCES customers(CustomerID)
	)";
	mysqli_query($conn, $sql) or die("Database Error - ".mysqli_error($conn));
	
	$sql = "
	CREATE TABLE Buses (
	BusNumber INT(7) AUTO_INCREMENT PRIMARY KEY,
	DepartureDate DATE NOT NULL,
	TravelOrigin VARCHAR(120) NOT NULL,
	TravelTerminal VARCHAR(120) NOT NULL,
	BusComfortType ENUM('Standard', 'Semi-Luxury', 'Luxury') NOT NULL,
	Fleet ENUM('SCANIA', 'MAN', 'VOLVO') NOT NULL
	)";
	mysqli_query($conn, $sql) or die("Database Error - ".mysqli_error($conn));
	
	$sql = "
	CREATE TABLE tickets (
	TicketID INT(7) AUTO_INCREMENT PRIMARY KEY,
	BusNumber INT(7) NOT NULL,
	Price DECIMAL(4,2) NOT NULL,
	TicketAvailable INT(3) NOT NULL,
	Discount DECIMAL(4,2),
	TripType BINARY,
	FOREIGN KEY (BusNumber) REFERENCES buses(BusNumber)
	)";
	mysqli_query($conn, $sql) or die("Database Error - ".mysqli_error($conn));
	
	$sql = "
	CREATE TABLE Routes (
	BusNumber INT(7) NOT NULL,
	TravelStop VARCHAR(120) NOT NULL
	)";
	mysqli_query($conn, $sql) or die("Database Error - ".mysqli_error($conn));
	
	$sql = "
	CREATE TABLE payments (
	PaymentID INT(7) AUTO_INCREMENT PRIMARY KEY,
	CustomerID INT(7),
	TicketID INT(7) NOT NULL,
	CardNumber VARCHAR(8) NOT NULL,
	ExpiryDate DATE NOT NULL,
	CCV VARCHAR(8) NOT NULL,
	FOREIGN KEY (CustomerID) REFERENCES customers(CustomerID),
	FOREIGN KEY (TicketID) REFERENCES tickets(TicketID)
	)";
	mysqli_query($conn, $sql) or die("Database Error - ".mysqli_error($conn));
	
	$sql = "
	CREATE TABLE TicketHandlings (
	TicketHandlingID INT(7) AUTO_INCREMENT PRIMARY KEY,
	PaymentID INT(7) NOT NULL,
	CustomerID INT(7),
	CustomerType ENUM('Adult', 'Child', 'Infant'),
	PreferredSeatPosition ENUM('Front', 'Back', 'Middle'),
	PreferredSeatSidePosition ENUM('Left Window', 'Right Window'),
	FOREIGN KEY (CustomerID) REFERENCES customers(CustomerID),
	FOREIGN KEY (PaymentID) REFERENCES payments(PaymentID)
	)";
	mysqli_query($conn, $sql) or die("Database Error - ".mysqli_error($conn));
	
	$sql = "
	CREATE TABLE PrintableTickets (
	TicketID INT(7) NOT NULL,
	Printer INT(7) NOT NULL,
	FOREIGN KEY (TicketID) REFERENCES tickets(TicketID)
	)";
	mysqli_query($conn, $sql) or die("Database Error - ".mysqli_error($conn));
	
	$sql = "
	CREATE TABLE MessageTickets (
	TicketID INT(7) NOT NULL,
	PhoneNumber VARCHAR(12) NOT NULL,
	FOREIGN KEY (TicketID) REFERENCES tickets(TicketID)
	)";
	mysqli_query($conn, $sql) or die("Database Error - ".mysqli_error($conn));
	
	$sql = "
	CREATE TABLE EmailTickets (
	TicketID INT(7) NOT NULL,
	email VARCHAR(50) NOT NULL,
	FOREIGN KEY (TicketID) REFERENCES tickets(TicketID)
	)";
	mysqli_query($conn, $sql) or die("Database Error - ".mysqli_error($conn));
	
	echo "<h3>Successfuly Created Database</h3>";

?>