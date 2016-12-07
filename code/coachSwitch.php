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
<?php include 'includes.php'?>
<html>
<link rel="stylesheet" href="/CSS/w3.css">
<link rel="stylesheet" href="/CSS/TCw3Apple.css">
<head>
 <title>
   Change Life Coach
 </title>
</head>
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

<div class="w3-panel w3-indigo w3-card-8 w3-grayscale-min">
<h1 style="text-align:center"> Enter Client Information </h1>
</div>
<div class="w3-padding-48">
</div>
<?php
if ($_SERVER[ 'REQUEST_METHOD' ] == 'POST') {
	$conn2 = "host=10.10.7.166 port=5432 dbname=Test user=morgan password=MorganBaker";
	$dbc = pg_connect($conn2);
	if(!$dbc){
		echo 'error! check connection string';
	}
	$coach =  validate($_POST['coach']);
	$client =  validate($_POST['client']);
	$query = "UPDATE clients SET coach ='".$coach."' WHERE person_id = '".$client."'";
	pg_query($dbc,$query);
	
}
?>
<div class="w3-row">
	<div class ="w3-container w3-quarter a3p5"> </div>
    <div class ="w3-white w3-grayscale-min w3-border-indigo w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-card-8 w3-container w3-half w3-center w3-col a12p5">

        <form action="coachSwitch.php" method="POST">
        <?php
        $conn_string = "host=10.10.7.166 port=5432 dbname=Test user=morgan password=MorganBaker";
        $db_conn = pg_connect($conn_string);
        if(!$db_conn){
            echo 'check connection :/';
        }
       $query = "SELECT fname, lname, id FROM clientlist
        where companyid =".$_SESSION['company']."";
        $results = pg_query($db_conn,$query);
        echo 'Client:<br>
		<select class="w3-input w3-light-gray" name = "client">';
        while ($row = pg_fetch_array($results)) {
        echo'<option value="'.$row['id'].'">'.$row[fname].' '.$row[lname].'</option>'; // Format for adding options 
        }
        echo'</select><br>';
        $query = "SELECT fname, lname, username FROM adminlist
        where companyid =".$_SESSION['company']."";
        $results = pg_query($db_conn,$query);
        echo 'Coach:<br>
		<select class="w3-input w3-light-gray" name = "coach">';
        while ($row = pg_fetch_array($results)) {
        echo'<option value="'.$row['username'].'">'.$row[fname].' '.$row[lname].'</option>'; // Format for adding options 
        }
        echo'</select><br>';
        ?>
        <div class="w3-padding-4"></div>
   <input class="w3-btn w3-indigo w3-grayscale-min w3-ripple w3-hover-blue" type="submit" value="Submit">
</form>
<?php echo'<a class="w3-btn-block w3-indigo w3-grayscale-min w3-center" href="https://10.10.7.165/adminlanding3.php/?p='.$_GET['p'].'">Back</a>';?>
</div>
<div class="w3-container w3-quarter a3p5"> </div>
</div>
</body>
</html>