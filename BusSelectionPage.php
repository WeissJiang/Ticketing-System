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
    <title>Bus Selection Page</title>
    <link rel="stylesheet" type="text/css" href="css/allpages.css">
</head>
    <style>
       body{
         padding:0;
         margin:0;
         background-color: #333333;
         display: flex;
         justify-content: center;
         align-items: center;
      }
      #head{
         margin-top: 80px;
      }
      .center{
          margin: 0 auto;
      }
      .button{
        border: none;
        color: white;
        padding: 15px 32px;
        text-align: center;
        width: 300px;
        height: 500px;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
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
<div id="head">
   <h2>Bus Selection Page</h2>
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

<div>
    <table class="center">
        <tr>
            <td><a href='searchresults.php?Bustype=Standard'><input class="button" type="image" src="images/Standard.jpeg"></a></td>
            <td><a href='searchresults.php?Bustype=Semi-Luxury'><input class="button" type="image" src="images/Semi-luxury.jpeg"></a></td>
            <td><a href='searchresults.php?Bustype=Luxury'><input class="button" type="image"  src="images/luxury.jpeg"></a></td>
        </tr>
    </table>
</div>
<br><br><br>
<!-- ================================= Main Area Above ====================================== -->
<footer style="right: 1px;">
    <p>Copyright &copy; 2021, Louay Beltaief, Obie Burns, Buyoung Choi, Hui Jiang, Joshua Perry</p>
</footer>
</body>
</html>