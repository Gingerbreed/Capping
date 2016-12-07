<html>
<body>
 <?php
session_start();
if ($_SESSION['loggedin'] !== TRUE) {
   header("Location: index2.php");
   echo '<p>You must log in first<p>';
   exit();
}
?>

<?php
$conn_string = "host=10.10.7.166 port=5432 dbname=Test user=morgan password=MorganBaker";
				$db_conn = pg_connect($conn_string);
				if(!$db_conn){
					echo 'check connection :/';
				}
	if($_GET['m']=='w' && $_SERVER[ 'REQUEST_METHOD' ] == 'POST'){
		$name = $_POST['name'];
		$position = $_POST['position'];
		$address = $_POST['address'];
		$income = $_POST['income'];
		$current = $_POST['current'];
		$query = "insert into workplaces(client_id, workname, income,pos,address, currentjob)
				  values (".$_GET['p'].",'$name',$income,'$position','$address',$current)";
		echo $query;
		 pg_query($db_conn, $query);
	}
	
	if($_GET['m']=='a' && $_SERVER[ 'REQUEST_METHOD' ] == 'POST'){
		$school = $_POST['schoolname'];
		$degree = $_POST['degree'];
		$query = "insert into academics(client_id, schoolname, degreetype)
				  values (".$_GET['p'].",'$school','$degree')";
		echo $query;
		pg_query($db_conn, $query);
	}
	if($_GET['m']=='l' && $_SERVER[ 'REQUEST_METHOD' ] == 'POST'){
		$event = $_POST['event'];
		$notes = $_POST['notes'];
		$query = "insert into lifeevents(client_id,eventtype, notes)
				  values (".$_GET['p'].",
				  '$event','$notes')";
		echo $query;
		pg_query($db_conn, $query);
	}
?>
<link rel="stylesheet" href="/CSS/TCw3.css">
<link rel="stylesheet" href="/CSS/TCw3Apple.css">
 
 <body class="w3-light-gray">
 <div class="w3-top">
 <ul class="w3-navbar w3-black"><!--class="topnav"-->
  <li><a class="" href="/index2.php">Home</a></li>
  <li><a href="#news">Messages<span class="w3-badge w3-blue w3-right"> 1 <?php ?></span> </a></li>
  <li><a href="#contact">settings</a></li>
  <li class="w3-right"><a href="/logout.php">Logout</a></li>
</ul>
</div>

<div class="w3-panel w3-indigo w3-card-8 w3-grayscale-min">
<h1 style="text-align:center"> Add a New Record</h1>
</div>

 <div class="w3-container w3-light-gray w3-padding-48">
 <div class="w3-row">
   	<div class=" w3-gray w3-grayscale-min w3-col l12 m12 s12 a12p5 a12p6 a12p6P w3-center">

<?php
echo"
<form action = '/newRecord.php/?p=".$_GET['p']."&m=".$_GET['m']."' method='POST'>";
echo"<table class='w3-table w3-striped'>";
	if($_GET['m']=='w'){

	echo"		<tr>
				<td>Workplace Name:</td><td><input class='w3-input' type= 'text' name ='name'>  </td>
			</tr>
			<tr>
				<td>Work Address: </td><td> <input class='w3-input' type= 'text' name ='address'></td>
			</tr>
			<tr>
				<td>Position: </td><td> <input  class='w3-input' type= 'text' name = 'position' </td>
			</tr>
			<tr>
				<td>Income: </td><td> <input  class='w3-input' type = 'text' name = 'income'</td>
			</tr>
			<tr>
				<td>Current Job: </td> <td> <input type = 'radio' name = 'current' value = 'TRUE'>Yes
				 <input type = 'radio' name = 'current' value = 'FALSE'>No</td>				
			</tr>";
	}
	if($_GET['m']=='a'){

	echo"		<tr>
				<td>School Name: </td><td> <input type = 'text' name ='schoolname'></td>
			</tr>
			<tr>
				<td>Degree Type: </td><td> <input type = 'text' name ='degree'></td>
			</tr>";
	}
	if($_GET['m']=='l'){
	echo"		<tr>
				<td>Event Type:</td><br>
				<td>";
				$conn_string = "host=10.10.7.166 port=5432 dbname=Test user=morgan password=MorganBaker";
				$db_conn = pg_connect($conn_string);
				if(!$db_conn){
					echo 'check connection :/';
				}
				$query = "select * from eventtypes";
				$result = pg_query($db_conn, $query);
				
				echo"<input name='event' list='types'>
				<datalist id='types'>";
				while ($row = pg_fetch_array($result)) {
				echo'<option value="'.$row['name'].'"/>'; // Format for adding options 
				}
				echo"</datalist><br>
				</td>
			</tr>
			<tr>
				<td>Notes</td><td><input type = 'text' name ='notes'></td>
			</tr>";
	}
	echo" <tr> <td> <input type='submit'  value='submit' </td> <td></td>";
	echo"	</table>";
	?>
		</form>
	<?php echo'<a class="w3-btn-block w3-indigo w3-center" href="https://10.10.7.165/clientview2.php/?p='.$_GET['p'].'">Back</a>';?>
</div>
</div>
</div>
</div>

</body>
</html>