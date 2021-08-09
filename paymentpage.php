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
	if (empty($_GET['TicketID'])) {
		$_SESSION['sessionmessage'] = "Please Select a Ticket first.";
		header("Location: searchpage.php");
		die ();
	}
	
	require 'dbConnection.php';
	
	$ticketID = htmlspecialchars(nl2br(strip_tags($_GET["TicketID"])));
	$sql = "SELECT * FROM tickets WHERE TicketID = $ticketID";
	$result = mysqli_query($conn, $sql) or die("Database Error - ".mysqli_error($conn));
	$ticket = mysqli_fetch_all($result);
	
	if (count($ticket) != 1) {
		$_SESSION['sessionmessage'] = "Your ticket was not found";
		header("Location: searchpage.php");
		die();
	}
	
	$ticket = $ticket[0];
	if (isset($ticket[4]) && !($loggedOn)) {
		$_SESSION['sessionmessage'] = "You must register to buy special discounted tickets";
		header("Location: searchpage.php");
		die();
	}
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Payment Page</title>
    <link rel="stylesheet" type="text/css" href="css/allpages.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
	<script src="functions/formvalidation.js" defer></script>
</head>
<body>

    <nav>
        <input id="nav-toggle" type="checkbox">
        <div class="logo"><img src="images/KTSicon.jpg" alt="KTS" width= "145px" height="70px"></div>
        <div class="systemname"><p><b>K T S  E  -  T i c k e t i n g   S y s t e m</b></p></div>
        <ul class="links">
            <li><a href="trippage.php">About</a></li>
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

<br></br></br></br></br><br></br>

<div id="head">
    <h2>Payment options page</h2>
</div>

<?php
	echo '<div id="SessionMessage"';
	if ($SessionMessage == "") {
		echo " style='display:none;' ";
	}
	echo '>
    <span class="fas fa-exclamation-circle"></span>
    <span class="error">'.$SessionMessage.'</span>
    <div class="close-btn">
      <span class="fas fa-times"></span>
    </div>
	</div>';
?>

<form name="payment" action="functions/PurchaseTicket.php" class="typeinbar" method="POST">
    <input name="CardNumber" type="text" placeholder="Card Number" required="">
    <input name="CardName" type="text" placeholder="Name on Card" required="">
	<label id="dateofbirthlabel">Expiration Date: </label> <br>
    <input name="Expiration" type="date" class="dob" placeholder="Expiration Date" required="">
    <input name="CCV" type="text" placeholder="CCV" required="">
    <input name="Postcode" type="text" placeholder="Postcode" required="">
	<select name="PreferredSeat" class="title">
		<option value="none" selected>Preferred Seat Position (Optional):</option>
		<option value="Front">Front</option>
		<option value="Back">Back</option>
		<option value="Middle">Middle</option>
	</select> <br>
	<select name="PreferredSeatSide" class="title">
		<option value="none" selected>Preferred Seat Window Side (Optional):</option>
		<option value="Left Window">Left Window</option>
		<option value="Right Window">Right Window</option>
	</select> <br>
	
	<div class="searching-form" style="width: 100%; margin: 0 auto;">
		<div class="input-type">
				<label>Adults</label>
				<input type="number" name="Adults" class="form-control" value="1">
			</div>
			<div class="input-type">
				<label>Children</label>
				<input type="number" name="Children" class="form-control" value="0">
			</div>
			<div class="input-type">
				<label>Infants</label>
				<input type="number" name="Infants" class="form-control" value="0">
			</div>
	</div>
	
	<?php
		echo '<input type="hidden" name="TicketID" value="'.$ticketID.'">';
		if ($loggedOn) {
			echo '<input type="hidden" name="Loggedon" value="true">';
		} else {
			echo '<h2>Contact Details</h2> <p>(Required as you are not Registered)</p><br>';
			echo '<input type="hidden" name="Loggedon" value="false">';
			echo '
			<input type="text" name="email" placeholder="name@email.com" required>
			<input type="text" name="firstname" placeholder="first name" required>
			<input type="text" name="lastname" placeholder="last name" required>
			<input type="text" name="address" placeholder="address" required>
			<input type="text" name="country" placeholder="country" required>
			<input type="password" name="password" placeholder="password" id="password" required>
			<input type="hidden" name="confirm_password" placeholder="comfirm password" id="confirm_password" required>
			<select name="title" class="title">
				<option value="none" disabled selected>Title:</option>
				<option value="Mr">Mr</option>
				<option value="Mrs">Mrs</option>
				<option value="Miss">Miss</option>
			</select> <br>
			<input type="hidden" name="dateofbirth" class="dob">
			<input type="hidden" name="phonenumber" placeholder="phone number">';
		}
	?>


    <div style="padding-bottom:0px">
        <input type="submit" name="Submit" value="Finalise">
    </div>
</form>
</br></br></br>
<!-- ================================= Main Area Above ====================================== -->
  <footer>
   <p>Copyright &copy; 2021, Louay Beltaief, Obie Burns, Buyoung Choi, Hui Jiang, Joshua Perry</p>
  </footer>
  </body>
  </html>