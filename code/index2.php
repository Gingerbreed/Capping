<?php
session_start();
if($_SESSION['loggedin']){
	if($_SESSION['authority']=='CompanyCIO' || $_SESSION['authority']=='TrueCourse'){
		
		header("location: adminlanding3.php");
		
		die();
	}
	header("location: lifecoachlanding3.php");
		die();
}
?>
<html>
<link rel="stylesheet" href="/CSS/w3.css">
<link rel="stylesheet" href="/CSS/TCw3Apple.css">
<?php
if ($_SERVER[ 'REQUEST_METHOD' ] == 'POST') {
	$username = $_POST['username'];
	$password = $_POST['password'];
	$passwordhash = hash('sha512', $password);
	# echo '<p>'. $passwordhash .'</p>';
	$conn_string = "host=10.10.7.166 port=5432 dbname=Test user=morgan password=MorganBaker";
	$db_conn = pg_connect($conn_string);
	if(!$db_conn){
		echo 'check connection :/';
	}
	$query = "SELECT companyid, fname, authority, enabled, username FROM people p, lifecoaches l
	WHERE p.id = l.personid
	AND l.username ='$username' and l.passwordhash ='$passwordhash';";
	$result = pg_query($db_conn, $query);
	if(!$result){
		echo '<p> something went wrong </p>';
	}
	$row = pg_fetch_row($result);
	$count = pg_num_rows($result);
	if($count == 1 && pg_fetch_result($result,0,3)) {			
	$_SESSION['loggedin'] = true;
	$_SESSION['company'] = pg_fetch_result($result,0,0);
	$_SESSION['coachname'] = pg_fetch_result($result,0,1);
	$_SESSION['authority'] = pg_fetch_result($result,0,2);
	$_SESSION['username'] = pg_fetch_result($result, 0,4);
	if(pg_fetch_result($result,0,2)=='CompanyCIO' || pg_fetch_result($result,0,2)=='TrueCourse'){
		ob_start;
		header("location: adminlanding3.php");
		ob_clean;
		die();
	}
	ob_start;
	header("location: lifecoachlanding3.php");
	ob_clean;
	die();
	}
	else if ($count == 1){
		echo "Login is not available at this time, please contact an administrator if there has been a mistake";
	}
	else {
		echo "Your Login Name or Password is invalid";
	}
	}
?>
<head>
</head>

<body class="w3-light-gray">
<header class="w3-container w3-card-8 w3-black w3-xxlarge w3-center">
Welcome to True Course <br>
Life Coach
</header>
<div class="w3-padding-24">
</div>
<div class="w3-row">
	<div class ="w3-green w3-container w3-quarter a3p5"> </div>
	<div class ="w3-white w3-grayscale-min w3-border-indigo w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-card-8 w3-container w3-half w3-center a6p5">
		<form action ="index2.php" method="post">
			Username:<br>
			<input class="w3-input w3-light-gray" type="text" name="username"><br>
			Password:<br>
			<input class="w3-input w3-light-gray" type="password" name="password"><br>
			<div class="w3-padding-8">
			</div>
			<div class="w3-center">
				<input class="w3-btn w3-indigo w3-ripple w3-hover-blue" type="submit" value="Login">
			</div>
		</form>
	</div>
	<div class="w3-green w3-container w3-quarter a3p5"> </div>
</div>
</body>
</html>