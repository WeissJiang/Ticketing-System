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
    <title>Contact Page</title>
    <style>
        #head {
            text-align: center;
            margin-top: 160px;
            color:#FCF2EC;
        }
    </style>
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

<br></br></br></br></br><br></br>

<div id="head">
    <h2>Contact Form (Email Yourself)</h2>
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

<form name="contact" action="functions/ContactEmail.php" class="typeinbar" method="POST">
    <input type="text" name="email" placeholder="name@email.com" required>
    <input type="text" name="fname" placeholder="first name" required>
    <input type="text" name="lname" placeholder="last name" required>
    <input type="text" name="phonenumber" placeholder="phone number" required>
	<input type="text" name="subject" placeholder="subject">
	<input type="text" name="message" placeholder="message">

    <div style="padding-bottom:0px">
        <input type="submit" name="Submit" value="Email">
    </div>
</form>
</br></br></br>
<!-- ================================= Main Area Above ====================================== -->
<footer>
    <p>Copyright &copy; 2021, Louay Beltaief, Obie Burns, Buyoung Choi, Hui Jiang, Joshua Perry</p>
</footer>
  </body>
  </html>