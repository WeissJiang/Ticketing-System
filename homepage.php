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
    <title>Home Page</title>
    <link rel="stylesheet" type="text/css" href="css/allpages.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
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
<main>
</br></br></br><br>
   <div id="head2">
      <h2>Home Page</h2>
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

   <div class="homeslider">
      <div class="homeslides">
         <input type="radio" name="radio-button" id="radio1">
         <input type="radio" name="radio-button" id="radio2">
         <input type="radio" name="radio-button" id="radio3">
         <input type="radio" name="radio-button" id="radio4">
         <div class="homeslide first">
            <img src="images/canberra.jpg" alt="Canberra">
         </div>
         <div class="homeslide">
            <img src="images/sydney.jpg" alt="Sydney">
         </div>
         <div class="homeslide">
            <img src="images/melbourne.jpg" alt="Sydney">
         </div>
         <div class="homeslide">
            <img src="images/brisbane.jpg" alt="Sydney">
         </div>
      </div>
      <div class="scrollmanual">
         <label for="radio1" class="manualbutton"></label>
         <label for="radio2" class="manualbutton"></label>
         <label for="radio3" class="manualbutton"></label>
         <label for="radio4" class="manualbutton"></label>
      </div>
   </div>

   <a href='trippage.php' style="text-decoration:none"><div class="homebutton"><h2>View Trips</h2></div></a>
</main>
<!-- ================================= Main Area Above ====================================== -->
<footer>
   <p>Copyright &copy; 2021, Louay Beltaief, Obie Burns, Buyoung Choi, Hui Jiang, Joshua Perry</p>
</footer>
</body>
</html>