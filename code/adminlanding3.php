<!--HTML Author: Joseph Thompson (11/6/2016)-->
<?php
session_start();
if ($_SESSION['loggedin'] !== TRUE) {
   header("Location: index2.php");
   echo '<p>You must log in first<p>';
   exit();
}
if ($_SESSION['authority'] =='CompanyCIO' || $_SESSION['authority'] =='TrueCourse') {
   
}
else{
	header("location: lifecoachlanding3.php");
}
?>

<html>

 <?php include 'includes.php';?>
<link rel="stylesheet" href="/CSS/w3.css">
<header>
 <title>
   Admin Landing
 </title>
</header>
<body class="w3-light-gray">
 <div class="w3-top">
 <ul class="w3-navbar w3-black"><!--class="topnav"-->
  <li><a class="" href="/index2.php">Home</a></li>
        <li><a href="/clientcontact.php">Messages<span class="w3-badge w3-blue w3-right">  <?php $dbconn = adminconnect(); 
		$trim = trim($_SESSION['username']);
		echo notify($dbconn, $trim);
		?></span> </a></li>
  <li class="w3-right"><a href="logout.php">Logout</a></li>
</ul>
</div>
<br>
<div class="w3-panel w3-indigo w3-card-8 w3-grayscale-min">
<h1 style="text-align:center"> Admin Options </h1>
</div>
<br>
<div id="wrapper" class="w3-row w3-container w3-center">
	<p><a class="w3-btn w3-indigo w3-grayscale-min w3-border w3-bottombar w3-border-gray w3-round-xlarge" href="/lifecoachlanding3.php"> Life Coach Profile </a></p>
    <p><a class="w3-btn w3-indigo w3-grayscale-min w3-border w3-bottombar w3-border-gray w3-round-xlarge" href="/addClient.php"> Add Client </a></p>
   	<p><a class="w3-btn w3-indigo w3-grayscale-min w3-border w3-bottombar w3-border-gray w3-round-xlarge" href="/addLifeCoach.php"> Add Life Coach </a></p>
	<p><a class="w3-btn w3-indigo w3-grayscale-min w3-border w3-bottombar w3-border-gray w3-round-xlarge" href="/coachSwitch.php"> Change Client Coach </a></p>
    <p><a class="w3-btn w3-indigo w3-grayscale-min w3-border w3-bottombar w3-border-gray w3-round-xlarge" href="/passwordset.php"> Reset Passwords </a></p>

	
</div>
<br>
<div class="w3-contianer w3-border w3-border-indigo w3-grayscale-min w3-center">
</div>
</body>
</html>