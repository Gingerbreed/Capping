<!--HTML Author: Alex Harris -->
<!--PHP Author: Morgan Baker -->
<!--Date: 10/27/2-16 -->
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
   Add a Life Coach
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

<div class="w3-panel w3-indigo w3-card-8 w3-grayscale-min">
<h1 style="text-align:center"> Enter Life Coach Information </h1>
</div>
<div class="w3-padding-24">
</div>
<?php

if ($_SERVER[ 'REQUEST_METHOD' ] == 'POST') {	
	$dbc = adminconnect();
	$firstname = validate($_POST['firstname']);
	$lastname = validate($_POST['lastname']);
	$address = validate($_POST['address']);
	$email = validate($_POST['email']);
	$company = validate($_SESSION['company']);
	$randomString = upload();
	
	if($randomString ==''){
	   $randomString = 'default-profile.png';
	   }
	$query ="insert into people(fname, lname, address, email, picture, companyid) values('$firstname', '$lastname', '$address', '$email','$randomString',$company );";
	pg_query($dbc,$query);
	$query ="SELECT id from people where fname= '$firstname' and lname='$lastname' and address = '$address' and picture = '$randomString';";
	$results = pg_query($dbc, $query);
	$me = pg_fetch_result($results, 0,0);
	$password = validate($_POST['password']);
	$username = validate($_POST['username']);
	$query = "insert into lifecoaches(personid,username,authority,password,passwordhash,enabled)
	VALUES ($me,'$username','Life Coach','$password',sha512('$password'),true)";
	pg_query($dbc,$query);
}
?>
<div class="w3-row">
   <div class ="w3-container w3-quarter w3-ap5hide"> </div>
   <div class ="w3-white w3-grayscale-min w3-border-indigo w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-card-8 w3-container w3-half w3-center w3-col a12p5">
   <form action="/addLifeCoach.php" method="POST" enctype = "multipart/form-data">
       First Name:<br>
      <input class="w3-input w3-light-gray" type="text" name="firstname"><br>
      Last Name:<br>
      <input class="w3-input w3-light-gray" type="text" name="lastname"><br>
      Home Address:<br>
      <input class="w3-input w3-light-gray" type="text" name="address"><br>
      Email Address:<br>
      <input class="w3-input w3-light-gray" type="text" name="email"><br>
      UserName:<br>
      <input class="w3-input w3-light-gray" type="text" name="username"><br>
      Password:<br>
      <input class="w3-input w3-light-gray" type="password" name="password"><br>
        Coach Picture:<br><br>
	  <input class="w3-input w3-light-gray" type = "file" name = "image" />
      <input class="w3-btn-block w3-indigo w3-grayscale-min w3-ripple w3-hover-blue" type="submit" value="Submit">
      
   </form>
   
</div>

</div>
</body>
</html>