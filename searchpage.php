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
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Search Page</title>
    <link rel="stylesheet" type="text/css" href="css/allpages.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
	<script src="functions/formvalidation.js" defer></script>
    <style>
        body{
            background-size: cover;
            background-position: center;
        }
    </style>
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
            <li><a href="#search">Search</a></li>      
        </ul>
        <label for="nav-toggle" class="icon-burger">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </label>
    </nav>
<!-- =================================== Main Area ========================================== -->
</br></br></br>
<div id="head">
    <h2>Search Page</h2>
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

<form class="searching-form-box" name="search" action="searchresults.php" method="POST">
    <div class="radio-btn">
        <input type="radio" class="btn" name="check" value="Return" checked="checked">
        <span>Return</span>
        <input type="radio" class="btn" name="check" value="One Way">
        <span>One Way</span>
    </div>
    <div class="searching-form">
        <input type="text" class="form-control" placeholder="Departure Location (Type In)" name="DepartureLocation">
        <input type="text" class="form-control" placeholder="Arrival Location (Type In)" name="ArrivalLocation">
		
		<select name="Bustype" class="title" style="width: 100%;">
			<option value="none" selected>Bus Comfort Type (Optional):</option>
			<option value="Standard">Standard</option>
			<option value="Semi-Luxury">Semi-Luxury</option>
			<option value="Luxury">Luxury</option>
		</select> <br>
		
		<select name="fleet" class="title" style="width: 100%;">
			<option value="none" selected>Bus Fleet (Optional):</option>
			<option value="SCANIA">SCANIA</option>
			<option value="MAN">MAN</option>
			<option value="VOLVO">VOLVO</option>
		</select> <br>
		
		<select name="order" class="title" style="width: 100%;">
			<option value="none" selected>Sort Results By:</option>
			<option value="bustype">Bus Type</option>
			<option value="date">Departure Date</option>
			<option value="fleet">Fleet</option>
			<option value="price">Price (Ticket sorting Only)</option>
			<option value="discount">Discount (Tickets sorting Only)</option>
		</select> <br>
		
		<input type="number" class="form-control" placeholder="Maximum Price (Optional)" name="price"> <br> <br>

        <div class="input-data">
            <label>Departing</label>
            <input type="date" name="DepartDate" class="form-control select-date">
        </div>
        <div class="input-data">
            <label>Returning</label>
            <input type="date" name="ReturnDate" class="form-control select-date">
        </div>

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
            
        <!-- <div class="input-btn">
            <button type="button" class="payment-btn">Pay with Credit Card</button>
            <button type="button" class="payment-btn">Pay with Paypal</button>
        </div> -->
		<input class="payment-btn" type="submit" name="Submit" value="Search">
    </div>
</form>

<form action="searchresults.php" class="typeinbar">
    <input type="submit" value="View All Bus Tickets">
</form>

<!-- ================================= Main Area Above ====================================== -->
 <footer>
   <p>Copyright &copy; 2021, Louay Beltaief, Obie Burns, Buyoung Choi, Hui Jiang, Joshua Perry</p>
  </footer>
  </body>
  </html>