<!--HTML Author: Alex Harris -->
<!--PHP Author: Morgan Baker -->
<!--Date: 10/27/2016 -->
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
<?php include 'includes.php';?>
<html>
<link rel="stylesheet" href="/CSS/w3.css">
<link rel="stylesheet" href="/CSS/TCw3Apple.css">
<header>
 <title>
   Reset Passwords
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
  <li><a href="#contact">settings</a></li>
  <li class="w3-right"><a href="logout.php">Logout</a></li>
</ul>
</div>
<?php
if ($_SERVER[ 'REQUEST_METHOD' ] == 'POST') {
	$conn2 = "host=10.10.7.166 port=5432 dbname=Test user=morgan password=MorganBaker";
	$dbc = pg_connect($conn2);
	if(!$dbc){
		echo 'error! check connection string';
	}
	$password = validate($_POST['password']);
	$confirm = validate($_POST['confirm']);
	$username = validate($_POST['username']);
		if($password == $confirm){
			$query = "UPDATE lifecoaches SET password ='$password', passwordhash=sha512('$password') WHERE username = '$username'";
			echo $query;
			pg_query($dbc,$query);
	}
	else{
		echo 'Your passwords didnt match dingus';
	}
}
?>
<div class="w3-panel w3-indigo w3-card-8 w3-grayscale-min">
<h1 style="text-align:center"> Enter Life Coach Information </h1>
</div>
<div class="w3-padding-24">
</div>
<div class="w3-row">
   <div class ="w3-container w3-quarter w3-ap5hide"> </div>
   <div class ="w3-white w3-grayscale-min w3-border-indigo w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-card-8 w3-container w3-half w3-center w3-col a12p5">
   <form action="passwordset.php" method="POST">
		Client:<br>
       <?php
	    $dbc = adminconnect();
		$query = "SELECT fname, lname, username FROM adminlist where companyid =".$_SESSION['company']."";
        $results = pg_query($dbc,$query);
        echo '<select class="w3-input w3-light-gray" name = "username">';
        while ($row = pg_fetch_array($results)) {
		$fname=$row[fname];
		$lname=$row[lname];
        echo'<option value="'.$row['username'].'">'.$fname.' '.$lname.'</option>'; // Format for adding options 
        }
        echo'</select><br>';?>
      Set Password:<br>
      <input class="w3-input w3-light-gray" type="password" name="password"><br>
	    <div class="w3-padding-8">
		</div>
      Confirm Passwords:<br>
      <input class="w3-input w3-light-gray" type="password" name="confirm"><br>
	  <div class="w3-padding-8"></div>
      <input class="w3-btn w3-indigo w3-grayscale-min w3-ripple w3-hover-blue" type="submit" value="Submit">
   </form>
   </div>
</div>
</body>
</html>