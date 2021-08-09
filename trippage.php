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
    <title>Trip Page</title>
    <link rel="stylesheet" type="text/css" href="css/allpages.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
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
</br></br></br></br></br>

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

<div id="head"><div>
    <img class="tripimage" alt="Bus Travel" src="images/bustravel.jpg">
    <a href='searchpage.php'><h2 class="tripsideright">BUY NOW</h2></a>
</div>

<div class="tripmain" style="overflow: auto;">
    <h1>Katima Transport Services</h1><br>
    <p>KTS is a coach and bus service that operates internationally as well as locally, here in Australia. We offer a wide range of trips to choose from, and our buses are top of the line.</p><br><br>
	<p><a style="color: #00CCCC;" href="BusSelectionPage.php">Visit The Bus Selection Page</a></p><br>
	<p><a style="color: #00CCCC;" href="contactpage.php">Visit The Contact Email Page</a></p>
</div>

<footer style="margin: 0; bottom: -5%;">
   <p>Copyright &copy; 2021, Louay Beltaief, Obie Burns, Buyoung Choi, Hui Jiang, Joshua Perry</p>
</footer>
<!-- ================================= Main Area Above ====================================== -->
</body>
</html>