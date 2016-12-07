<!--HTML Author: Alex Harris -->
<!--PHP Author: Morgan Baker -->
<!--Date: 10/27/2-16 -->
<!--Edited 12/4/2016 -->
<?php
session_start();
if ($_SESSION['loggedin'] !== TRUE) {
	header("Location: /index2.php");
	echo '<p>You must log in first<p>';
	exit();
	}
?>
<?php include 'includes.php'?>
<html>
<link rel="stylesheet" href="/CSS/w3.css">
<link rel="stylesheet" href="/CSS/TCw3Apple.css">
<header>
 <title>
  Add New Relation
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
<h1 style="text-align:center"> Enter Relationship Information </h1>
</div>
<div class="w3-padding-48">
</div>
<?php
if ($_SERVER[ 'REQUEST_METHOD' ] == 'POST') {
	$dbc = connect();
	$relation = validate($_POST['relation']);
	$client = validate($_POST['client']);
	if($client == $_GET['p']){
		echo 'wat';
	}
	else{
	$query = "insert into relations VALUES(".$_GET['p'].",$client,'$relation')";
	pg_query($dbc,$query);
	$relation = reverse($relation);
	$query = "insert into relations VALUES($client,".$_GET['p'].",'$relation')";
	pg_query($dbc,$query);
	}
	
}
function reverse($data){
	switch($data){
		case "Mother":
        return "Son";
        break;
		case "Father":
        return"Son";
        break;
		case "Husband":
		return"Wife";
        break;
		case "Wife":
        return"Husband";
		break;
		case "Brother":
        return"Brother";
		break;
		case "Sister":
        return"Brother";
		break;
		case "Son":
        return"Father";
		break;
		case "Daughter":
        return"Father";
		break;
		case "Uncle":
        return"Nephew";
		break;
		case "Aunt":
        return"Nephew";
		break;
		case "Niece":
        return"Uncle";
		break;
		case "Nephew":
        return"Uncle";
		break;
		case "Cousin":
        return"Cousin";
		break;
		case "Gaughter":
        return"Gfather";
		break;
		case "Gfather":
        return"Gaughter";
		break;
		case "Gmother":
        return"Gaughter";
		break;
		case "Gson":
        return"Gmother";
		break;
		default:
		return 'broke';
		break;
	}
}
?>
<div class="w3-row">
	<div class ="w3-container w3-quarter a3p5"> </div>
    <div class ="w3-white w3-grayscale-min w3-border-indigo w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-card-8 w3-container w3-half w3-center w3-col a12p5">
		<?php
        echo'<form action="/addRelation.php/?p='.$_GET['p'].'" method="POST">';
        $dbc = connect();
        $query = "SELECT fname,lname,id FROM clientlist
        where companyid ='".$_SESSION['company']."';";
        $results = pg_query($dbc,$query);
        echo 'Client B:<br>
        <select class="w3-input w3-light-gray" name="client">';
        while ($row = pg_fetch_array($results)) {
        echo'<option value="'.$row['id'].'">'.$row['fname'].' '.$row['lname'].'</option>'; // Format for adding options 
        }
        echo'</select><br>';
        ?>
		<select class="w3-input w3-light-gray" name="relation">
        <option value="Mother">Mother</option>
		<option value="Father"/>Father</option>
		<option value="Daughter"/>Daughter</option>
		<option value="Son"/>Son</option>
		<option value="Uncle"/>Uncle</option>
		<option value="Aunt"/>Aunt</option>
		<option value="Gmother"/>Grandfather</option>
		<option value="Gfather"/>Grandmother</option>
		<option value="Cousin"/>Cousin</option>
		<option value="Niece"/>Niece</option>
		<option value="Nephew"/>Nephew</option>
		<option value="Gaughter"/>Granddaughter</option>
		<option value="Gson"/>Grandson</option>
		<option value="Sister"/>Sister</option>
		<option value="Brother"/>Brother</option>
		<option value="Husband"/>Husband</option>
		<option value="Wife"/>Wife</option>
		</select><br>
        <div class="w3-padding-4"></div>
   <input class="w3-btn w3-indigo w3-grayscale-min w3-ripple w3-hover-blue" type="submit" value="Submit">
</form>
</div>
<div class="w3-container w3-quarter a3p5"> </div>
</div>
</body>
</html>