<?php 
	session_start();
	$loggedOn = isset($_SESSION['userid']);
	if ($loggedOn) {
		$UserID = $_SESSION['userid'];
		$SessionType = $_SESSION['sessiontype'];
		$_SESSION['sessionmessage'] = "You already logged in";
		header("Location: homepage.php");
		die ();
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
    <title>Registration Page</title>
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
			else {echo '<li><a href="functions/logout.php">Log Out</a></li>';}?>
            <li><a href="searchpage.php">Search</a></li>      
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
    <h2>Registration Page</h2>
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

<br>
<form name="register" action="functions/CustomerRegister.php" class="typeinbar" method="POST">
    <input type="text" name="email" placeholder="name@email.com" required>
    <input type="text" name="firstname" placeholder="first name" required>
    <input type="text" name="lastname" placeholder="last name" required>
	<input type="text" name="address" placeholder="address" required>
    <input type="password" name="password" placeholder="password" id="password" required>
    <input type="password" name="confirm_password" placeholder="comfirm password" id="confirm_password" required>
	<select name="title" class="title">
		<option value="none" disabled selected>Title:</option>
		<option value="Mr">Mr</option>
		<option value="Mrs">Mrs</option>
		<option value="Miss">Miss</option>
	</select> <br>
	<label id="dateofbirthlabel">Date of Birth (Not required) </label> <br>
	<input type="date" name="dateofbirth" class="dob">
	<input type="text" name="phonenumber" placeholder="phone number">
	
    
    <!-- <script>
        var password = document.getElementById("password")
         , confirm_password = document.getElementById("confirm_password");

        function validatePassword(){
        if(password.value != confirm_password.value) {
            confirm_password.setCustomValidity("Passwords Don't Match");
         } else {
            confirm_password.setCustomValidity('');
            }
        }
        password.onchange = validatePassword;
        confirm_password.onkeyup = validatePassword;
    </script> -->
    </br>
    <div style="padding-bottom:0px">
        <input type="submit" name="Submit" value="Submit">
    </div>
</form>
</br></br></br>
<!-- ================================= Main Area Above ====================================== -->
<footer>
   <p>Copyright &copy; 2021, Louay Beltaief, Obie Burns, Buyoung Choi, Hui Jiang, Joshua Perry</p>
</footer>
</body>
</html>