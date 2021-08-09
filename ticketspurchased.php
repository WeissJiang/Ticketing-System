<?php
	session_start();
	$loggedOn = isset($_SESSION['userid']);
	if ($loggedOn) {
		$UserID = $_SESSION['userid'];
		$SessionType = $_SESSION['sessiontype'];
	}
	if (isset($_SESSION['sessionmessage'])) {
		$SessionMessage = $_SESSION['sessionmessage'];
		unset($_SESSION['sessionmessage']);
	} else {
		$SessionMessage = "";
	}
	
	require 'dbConnection.php';
	
	if (!$loggedOn && empty($_SESSION['Unregisteredpayment'])) {
		$_SESSION['sessionmessage'] = "You have not purchased a ticket yet";
		header("Location: homepage.php");
		die ();
	} else if (!$loggedOn) {
		$Upay = $_SESSION['Unregisteredpayment'];
		$customer = $_SESSION['non-customer'];
	} else {
		$sql = "SELECT * FROM customers WHERE CustomerID = '$UserID'";
		$result = mysqli_query($conn, $sql) or die("Database Error - ".mysqli_error($conn));
		$customer = mysqli_fetch_all($result)[0];
	}
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>View Tickets Page</title>
    <link rel="stylesheet" type="text/css" href="css/allpages.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <script src="https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
</head>
<body>
    <nav>
        <input id="nav-toggle" type="checkbox">
        <div class="logo"><img src="images/KTSicon.jpg" alt="KTS" width= "145px" height="70px"></div>
        <div class="systemname"><p><b>K T S  E  -  T i c k e t i n g   S y s t e m</b></p></div>

        <ul class="links">
            <li><a href="homepage.php">Home</a></li>
            <?php if (!$loggedOn) {echo '<li><a href="loginpage.php">Login</a></li>';
			echo '<li><a href="registrationpage.php">Register</a></li>';}
			else {echo '<li><a href="functions/logout.php">Log Out</a></li>';
			echo '<li><a href="ticketspurchased.php">Your Tickets</a></li>';}?>
            <li><a href="searchpage.php">Search</a></li>    
        </ul>
        <label for="nav-toggle" class="icon-burger">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </label>
    </nav>
<!-- =================================== Main Area ========================================== -->
<main>
</br></br></br><br>
<div id="head2">
   <h2>Your Purchased Tickets</h2>
</div>

<?php
	echo '<div id="SessionMessage" style="top: 250px;';
	if ($SessionMessage == "") {
		echo " display:none;";
	}
	echo '">
    <span class="fas fa-exclamation-circle"></span>
    <span class="error">'.$SessionMessage.'</span>
    <div class="close-btn">
      <span class="fas fa-times"></span>
    </div>
	</div>';
?>

<script>
    function generatePDF(Sheet){
        let element = document.getElementsByClassName("paymentprint")[Sheet];

        html2pdf()
        .from(element)
        .save('KTS E-Ticket for ' + 
		<?php
			if ($loggedOn) {
				echo "'" . $customer[2] . " " . $customer[3] . "'";
			} else {
				echo "'" . $customer[1] . " " . $customer[2] . "'";
			}
		?>);
    }

    function printPay(Sheet){
		for (i = 0; i < document.getElementsByClassName("paymentprint").length; i++) {
			document.getElementsByClassName("paymentprint")[i].removeAttribute("id");
		}
		document.getElementsByClassName("paymentprint")[Sheet].id = 'print-container';
        window.print();
    }
</script>

<?php
	if ($loggedOn) {
		$PaySQL = "SELECT * FROM payments WHERE CustomerID = $UserID";
	} else {
		if (empty($Upay)) {
			$_SESSION['sessionmessage'] = "You have not purchased a ticket yet";
			header("Location: homepage.php");
			die ();
		}
		$PaySQL = "SELECT * FROM payments WHERE PaymentID = $Upay";
	}
	
	$result = mysqli_query($conn, $PaySQL) or die("Database Error - ".mysqli_error($conn));
	$Paylist = mysqli_fetch_all($result);
	if (count($Paylist) > 0) {
		$ticketpurchases = array();
		for ($i = 0; $i < count($Paylist); $i++) {
			if (!in_array($Paylist[$i][2], $ticketpurchases)) {
				array_push($ticketpurchases, $Paylist[$i][2]);
			}
		}
	
			$TicketSQL = "SELECT * FROM tickets WHERE ";
			$TicketSQL = $TicketSQL . " (TicketID = $ticketpurchases[0] ";
		for ($i = 1; $i < count($ticketpurchases); $i++) {
			$TicketSQL = $TicketSQL . " OR TicketID = $ticketpurchases[$i]";
		}
		$TicketSQL = $TicketSQL . ")";
		$result = mysqli_query($conn, $TicketSQL) or die("Database Error - ".mysqli_error($conn));
		$Ticketlist = mysqli_fetch_all($result);
		
		$buses = array();
		$BusSQL = "SELECT * FROM buses WHERE ";
		$BusSQL = $BusSQL . " (BusNumber = ".$Ticketlist[0][1]." ";
		array_push($buses, $Ticketlist[0][1]);
		for ($i = 1; $i < count($Ticketlist); $i++) {
			if (!in_array($Ticketlist[$i][1], $buses)) {
				$BusSQL = $BusSQL . " OR BusNumber = ". $Ticketlist[$i][1] ."";
			}
		}
		$BusSQL = $BusSQL . ")";
		$result = mysqli_query($conn, $BusSQL) or die("Database Error - ".mysqli_error($conn));
		$Busresultlist = mysqli_fetch_all($result);
	}
	
	if (count($Paylist) < 1) {
		echo "<p class='result'>No Purchased Tickets Found. </p>";
	} else {
		
		$PaymentSheet = -1;
		for ($i = 0; $i < count($Busresultlist); $i++) {
			$Bus = $Busresultlist[$i];	
			for ($ii = 0; $ii < count($Ticketlist); $ii++) {
				$ticket = $Ticketlist[$ii];
				if ($Bus[0] == $ticket[1]) {
					for ($iii = 0; $iii < count($Paylist); $iii++) {
						$payment = $Paylist[$iii];
						if ($payment[2] == $ticket[0]) {
							$PaymentSheet++;
							echo '<div class="paymentprint">';
							echo '<table class="table2">';
							echo '<td colspan="3">';
							echo '<h3>KTS Payment Information and Tickets</h3> <br>';
							if ($loggedOn) {
								if (!is_null($customer[1])) {
									echo $customer[1] . " ";
								}
								echo $customer[2] . " " . $customer[3] . "<br>";
							} else {
								if (!is_null($customer[3])) {
									echo $customer[3] . " ";
								}
								echo $customer[1] . " " . $customer[2] . "<br>";
							}
							echo $Bus[2] . " to " . $Bus[3] . "<br>";
							$RouteSQL = "SELECT * FROM Routes WHERE busnumber = ".$Bus[0];
							$result = mysqli_query($conn, $RouteSQL) or die("Database Error - ".mysqli_error($conn));
							$Routelist = mysqli_fetch_all($result);
							if (count($Routelist) > 0) {
								echo "via";
							for ($ii = 0; $ii < count($Routelist); $ii++) {
								if (($ii + 1) == count($Routelist)) {
								echo " ".$Routelist[$ii][1];
								} else {
									echo " ".$Routelist[$ii][1].",";
								}
							}
							echo " <br>";
							}
							$DDate = explode("-", $Bus[1]);
							echo "Departing Date: " . $DDate[2] . "/" . $DDate[1] . "/" . $DDate[0] . "<br>";
							echo "Bus Summary: " . $Bus[4] . " " . $Bus[5] . "<br>";
							echo "</td>";
			
							echo "<tr>
							<td>Payment ID</td>
							<td>Bus Number</td>
							<td>Customer ID</td>
							</tr><tr>";
							echo '<td>' . $payment[0] . '</td>';
							echo '<td>' . $Bus[0] . '</td>';
							if ($loggedOn) {
								echo '<td>'.$UserID.'</td>';
							} else {
								echo '<td>N/A</td>';
							}
							echo "</tr>";
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
								echo "<tr>
								<td>- - - - - - - - - -</td>
								<td>- - - - - - - - - -</td>
								<td>- - - - - - - - - -</td>
								</tr>";
								echo "<tr>
								<td>Ticket Number</td>
								<td>Customer Type</td>
								<td>Ticket Cost</td>
								</tr><tr>";
								echo "<td>" . $TH[0] . "</td>";
								echo "<td>" . $TH[3] . "</td>";
								echo "<td> $" . round($ticketcost, 2) . "</td>";
								echo "</tr>";
							}
						echo "<tr>
						<td>- - - - - - - - - -</td>
						<td>- - - - - - - - - -</td>
						<td>- - - - - - - - - -</td>
						</tr>";
						echo "<tr>
						<td>Customer Email</td>
						<td>Total Amount of Tickets</td>
						<td>Total Cost</td>
						</tr><tr>";
						if ($loggedOn) {
							echo "<td>" . $customer[7] . "</td>";
						} else {
							echo "<td>" . $customer[0] . "</td>";
						}
						echo "<td>" . count($THresultlist) . "</td>";
						echo "<td> $" . round($totalcost, 2) . "</td>";
						echo "</tr>";
						echo "</table></div><br><br>";
						echo '<button class="printbutton" onclick="printPay('.$PaymentSheet.')">
							Print
						</button>
						<button class="downloadbutton" onclick="generatePDF('.$PaymentSheet.')">
							Download
						</button>
						<a href="functions/EmailTicket.php?TicketString=' . $Bus[0] . "," . $ticket[0] . "," . $payment[0] . '"><button class="downloadbutton"">
							Email
						</button></a>
						<a href="functions/RefundTicket.php?PaymentID=' . $payment[0] . '"><button class="downloadbutton"">
							Refund
						</button></a>';
						}
					}
				}
			}
		}
	}
?>

</div>
</main>
<!-- ================================= Main Area Above ====================================== -->
<footer>
   <p>Copyright &copy; 2021, Louay Beltaief, Obie Burns, Buyoung Choi, Hui Jiang, Joshua Perry</p>
</footer>
</body>
</html>