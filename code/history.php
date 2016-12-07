 <html>
 <head>
 </head>
 <?php
session_start();
if ($_SESSION['loggedin'] !== TRUE) {
   header("Location: /index.php");
   echo '<p>You must log in first<p>';
   exit();
}
?>
<?php include 'includes.php' ?>
 <?php
		
		
	$conn_string = "host=10.10.7.166 port=5432 dbname=Test user=morgan password=MorganBaker";
	$db_conn = pg_connect($conn_string);
	if(!$db_conn){
		echo 'check connection :/';
	}
	if($_GET['m']== 'a'){
		$query = "SELECT schoolname, degreetype from academics where client_id = ".$_GET['p']."";
	}
	if($_GET['m']== 'w'){
	$query = "SELECT * from workplaces where client_id = ".$_GET['p']."";
	}
#	echo $query;
	$results = pg_query($db_conn,$query);
	
	?>

 
 
 <link rel="stylesheet" href="/CSS/TCw3.css">
<link rel="stylesheet" href="/CSS/TCw3Apple.css">
 
 <body class="w3-light-gray">
  <div class="w3-top w3-ap5xlarge">
 <ul class="w3-navbar w3-black"><!--class="topnav"-->
  <li><a class="" href="/index2.php">Home</a></li>
        <li><a href="/clientcontact.php">Messages<span class="w3-badge w3-blue w3-right">  <?php $dbconn = adminconnect(); 
		$trim = trim($_SESSION['username']);
		echo notify($dbconn, $trim);
		?></span> </a></li>
  <li><a href="#contact">settings</a></li>
  <li class="w3-right"><a href="/logout.php">Logout</a></li>
</ul>
</div>
<div class='w3-row'>
<div class='w3-container TC-Pad-Top l w3-gray'>
 		<table class="w3-table w3-striped">
		<?php
		if($_GET['m'] == a){
			echo "<th> School Name: </th> <th> Degree:</th>";
			while($row = pg_fetch_array($results)){
				echo "<tr><td>".$row['schoolname']."</td><td>".$row['degreetype']."</td></tr>";
			}
		}
		if($_GET['m'] == w){
		echo "<th> Name: </th><th> Position:</th><th>Address:</th><th>Income:</th>";
			while ($row = pg_fetch_array($results)){
				echo "<tr><td>".$row['workname']."</td><td>".$row['position']."</td><td>".$row['address']."</td><td>".$row['income']."</td></tr>";
			}
		}
				?>
				
		</table>
		</div>
</div>
</body>
</html>