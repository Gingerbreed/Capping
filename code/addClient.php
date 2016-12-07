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
   Add a Client
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
<br>
<div class="w3-panel w3-indigo w3-card-8 w3-grayscale-min">
<h1 style="text-align:center"> Add a Client </h1>
</div>
<?php
if ($_SERVER[ 'REQUEST_METHOD' ] == 'POST') {
	$dbc = adminconnect();
	$fname = validate($_POST['firstname']);
	$lname = validate($_POST['lastname']);
	$address = validate($_POST['address']);
	$email = validate($_POST['email']);
	$company = validate($_SESSION['company']);
	$randomString = upload();
   if($randomString ==''){
	   $randomString = 'default-profile.png';
   }
	$query ="insert into people(fname, lname, address, email, picture, companyid) values('$fname', '$lname', '$address', '$email','$randomString',$company );";
	pg_query($dbc,$query);
	$query ="SELECT id from people where fname= '$fname' and lname='$lname' and address = '$address';";
	$results = pg_query($dbc, $query);
	$me = pg_fetch_result($results, 0,0);
	$call = validate($_POST['call']);
	$visit = validate($_POST['visit']);
	$telephone = validate($_POST['telephone']);
	$dob = validate($_POST['birth']);
	$coach = validate($_POST['coach']);
	$query = "insert into clients(person_id, telephone,dob,whentocall,whentovisit,coach)
	VALUES ($me,$telephone,'$dob','$call','$visit','$coach')";
	pg_query($dbc,$query);
}
?>
<div class="w3-row">
    <div class ="w3-container w3-quarter w3-ap5hide"> </div>
    <div class ="w3-white w3-grayscale-min w3-border-indigo w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-card-8 w3-container w3-half w3-center w3-col a12p5">
    <form action="addClient.php" method="POST" enctype = "multipart/form-data">
       First Name:<br>
       <input class="w3-input w3-light-gray" type="text" name="firstname"><br>
	   Last Name:<br>
       <input class="w3-input w3-light-gray" type="text" name="lastname"><br>
       Home Address:<br>
       <input class="w3-input w3-light-gray" type="text" name="address"><br>
       Email Address:<br>
       <input class="w3-input w3-light-gray" type="text" name="email"><br>
       When to Call:<br>
       <input class="w3-input w3-light-gray" type="text" name="call"><br>
       When to Visit:<br>
       <input class="w3-input w3-light-gray" type="text" name="visit"><br>
       Telephone:<br>
       <input class="w3-input w3-light-gray" type="text" name="telephone"><br>
       Date of Birth:<br>
       <input class="w3-input w3-light-gray" type="date" name="birth"><br>
    <?php
    $dbc = adminconnect();
	$query = "SELECT fname, lname, username FROM adminlist
	where companyid ='".$_SESSION['company']."';";
	$results = pg_query($dbc,$query);
	echo 'Coach:<br>
	<select class="w3-input w3-light-gray" name="coach">';
	while ($row = pg_fetch_array($results)) {
    echo'<option value="'.$row['username'].'">'.$row['fname'].' '.$row['lname'].'</option>'; // Format for adding options 
	}
	echo'</select><br>';
   ?>
     Client Picture:<br><br>
	  <input class="w3-input w3-light-gray" type = "file" name = "image" />
   <input class="w3-btn w3-indigo w3-grayscale-min w3-border w3-bottombar bw-border-gray w3-round-xlarge" type="submit" value="Submit">
</form>
</div>
<div class="w3-container w3-quarter w3-ap5hide"></div>
</div>
</div>
</body>
</html>