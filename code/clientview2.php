 <html>
 <head>
 </head>
 <?php
session_start();
if ($_SESSION['loggedin'] !== TRUE) {
   header("Location: /index2.php");
   echo '<p>You must log in first<p>';
   exit();
}
?>
<?php include 'includes.php';?>

 <?php
 if ($_SERVER[ 'REQUEST_METHOD' ] == 'POST') {
	 ob_start;
		header("location: /updateclient.php");
		ob_clean;
		die();
		//$conn2 = "host=10.10.7.166 port=5432 dbname=Test user=morgan password=MorganBaker";
		//$dbc = pg_connect($conn2);
		//if(!$dbc){
		//	echo 'error! check connection string';
		//}
	//$update = "update clients set telephone = '".$_POST['telephoneinput']."', favoritebook = '".$_POST['favoritebook']."', favoritefood = '".$_POST['favoritefood']."', preferredpractice = '".$_POST['hobby']."'  where pid = '".$_GET['p']."'; ";
	//$update .= "update people set address = '".$_POST['address']."' where id ='".$_GET['p']."';";
#	echo  $update. "<br>";
	//$updateresults = pg_query($dbc,$update);
#	echo $updateresults;
	}
 
 ?>


 <?php
	$db_conn = adminconnect();
	$query = "SELECT fname, lname, address, email, favoritefood, favoritebook, telephone, preferredpractice, picture FROM clientlist c WHERE c.id = ".$_GET['p']." and c.companyid =".$_SESSION['company'].";";
#	echo $query ."<br>";
	$results = pg_query($db_conn,$query);
	$row = pg_fetch_array($results);
	$query = "SELECT * from workplaces where client_id = ".$_GET['p']." and currentjob = 'true';";
#	echo $query;
	$results = pg_query($db_conn,$query);
	$row3 = pg_fetch_array($results);
	$query = "SELECT schoolname from academics where client_id = ".$_GET['p']."";
	$results = pg_query($db_conn,$query);
	$row2 = pg_fetch_array($results);
	$query = "Select DISTINCT dateofcontact
				From clientcontacts c
				Where c.client = ".$_GET['p']."
				and completed = true
				Order By dateofcontact DESC
";
	$results = pg_query($db_conn,$query);
	$row4 = pg_fetch_array($results);
	$query = "Select DISTINCT dateofcontact
				From clientcontacts c
				Where c.client = ".$_GET['p']."
				and completed = False
				Order By dateofcontact ASC";
	$results = pg_query($db_conn,$query);
	$row5 = pg_fetch_array($results);
	$query = "Select DISTINCT dateofcontact
				From clientcontacts c
				Where c.client = ".$_GET['p']."
				and completed = true
				Order By dateofcontact DESC";
	$results = pg_query($db_conn,$query);
	$row6 = pg_fetch_array($results);
	?>

 
 
 <link rel="stylesheet" href="/CSS/TCw3.css">
<link rel="stylesheet" href="/CSS/TCw3Apple.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

 
 <body class="w3-light-gray">
 <div class="w3-top">
 <ul class="w3-navbar w3-black"><!--class="topnav"-->
  <li><a class="" href="/index2.php">Home</a></li>
        <li><a href="/clientcontact.php">Messages<span class="w3-badge w3-blue w3-right">  <?php $dbconn = adminconnect(); 
		$trim = trim($_SESSION['username']);
		echo notify($dbconn, $trim);
		?></span> </a></li>
  <li class="w3-right"><a href="/logout.php">Logout</a></li>
</ul>
</div>
 <div class="w3-container w3-light-gray w3-padding-48">
 <div class="w3-row">
	<div class="w3-container w3-card-8 w3-indigo w3-grayscale-min w3-col l3 m4 s12 a12p5 a12p6 a12p6P w3-center">
	
	<div class="w3-container w3-padding-16 w3-indigo w3-center TC-ViewFull l s TC-full a5">
		<?php
		
		echo'<img class ="w3-circle" src="/images/'.$row['picture'].'" style="width:75%" alt="[images/'.$row['picture'].']"><br>';
		
		echo $row['fname'].' '.$row['lname'];		
		?>
	</div>
	</div>
	<div class="w3-container w3-rest w3-gray w3-ul">
	Info
	<div class="w3-container w3-indigo w3-grayscale-min">
	<?php
	if ($_SERVER[ 'REQUEST_METHOD' ] == 'POST') {
	echo "Client has been updated";
	}
	?>
	</div>
		<table class="w3-table w3-striped">
			<tr>
				<td>Last Appointment</td> <td> <?php if($row4['dateofcontact'] == null){echo'no appointment scheduled';}
					else{echo $row4['dateofcontact'];} ?> </td>
			<td></td><td></td></tr>
			<tr>
				<td> Next Appointment: </td><td> <?php if($row5['dateofcontact'] == null){echo'no appointment scheduled';}
					else{echo $row5['dateofcontact'];}?></td>
			<td></td><td></td></tr>
			<tr>
				<td>Last Contacted </td><td>  <?php if($row6['dateofcontact'] == null){echo'no appointment scheduled';}
					else{echo $row6['dateofcontact'];}?></td>
			<td></td><td></td></tr>
			<tr>
				<td>Home Address: </td><td> <?php echo $row['address']?></td>
			<td></td><td></td></tr>
			<tr>
				<td>Phone: </td><td> <?php $part = substr($row['telephone'],0,3); 
										   $part2 = substr($row['telephone'],3,3);
										   $part3 = substr($row['telephone'],6);echo '('.$part.')-'.$part2.'-'.$part3.''; ?></td>
			<td></td><td></td></tr>
			<tr>
				<td>Email: </td><td> <?php echo $row['email']?></td><td></td><td></td>
			</tr>
			<tr>
				<td>Work: </td><td> <?php 
				if ($row3['workname']!=null){
				echo $row3['workname'];}
				else{
				echo "Not Currently Employed";
				}
				echo'</td><td><a href = "/history.php/?p='.$_GET['p'].'&m=w">History</a>'
				?>
				
				</td><td><a href="https://10.10.7.165/newRecord.php/?p=<?php echo $_GET['p'].'&m=w'; ?>"> <i class="fa fa-plus-square"></i></a></td>
			</tr>
			<tr>
				<td>Academic: </td><td> <?php 
				if ($row2['schoolname']!=null){
				echo $row2['schoolname'];}
				else{
				echo "No academics";
				}
				echo'</td><td><a href = "/history.php/?p='.$_GET['p'].'&m=a">History</a>'
				?>
				</td><td><a href="https://10.10.7.165/newRecord.php/?p=<?php echo $_GET['p'].'&m=a'; ?>"> <i class="fa fa-plus-square"></i></a></td>
			</tr>
			<tr>
				<td>Favorite Food: </td><td><?php echo $row['favoritefood']; ?></td>
			<td></td><td></td></tr>
			<tr>
				<td>Favorite Book: </td><td><?php echo $row['favoritebook']; ?></td>
			<td></td><td></td></tr>
			<tr>
				<td>Prefered Hobby: </td><td><?php echo $row['preferredpractice']; ?></td>
			<td></td><td></td></tr>
		</table>
		<?php echo'<a class="w3-btn-block w3-indigo w3-grayscale-min w3-center" href="https://10.10.7.165/updateclient.php/?p='.$_GET['p'].'">Update</a>';?>
		
	</div>
	<div class="w3-padding-16"></div>
	<div class="w3-row">
    <div class ="w3-container w3-quarter w3-ap5hide"> </div>
    <div class ="w3-white w3-grayscale-min w3-border-indigo w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-card-8 w3-container w3-half w3-center w3-col a12p5">

	<?php 
	echo'<a class="w3-btn-block w3-gray w3-grayscale-min w3-left" href="https://10.10.7.165/addRelation.php/?p='.$_GET['p'].'">Add Relation</a>';?>
	
	<div class="w3-padding-16"></div>
	<div class="w3-col l12 w3-container w3-indigo w3-grayscale-min w3-border-white">
	Family <br>
	<?php 
	$dbc = adminconnect();
	$query = "SELECT fname, lname, clientb, relation, picture FROM relations r, clientlist l WHERE clienta = ".$_GET['p']." and r.clientb = l.id;";
	$results = pg_query($db_conn,$query);
	while ($row = pg_fetch_array($results)) {
	$relation = '';
	switch($row['relation']){
		case "Gmother":
        $relation = "Grandmother";
        break;
		case "Gfather":
        $relation = "Grandfather";
        break;
		case "Gaughter":
		$relation = "Granddaughter";
        break;
		case "Gson":
        $relation ="Grandson";
		break;
		default:
        $relation = $row['relation'] ;
		break;
	}
	echo '<a href="clientview2.php/?p='.$row['clientb']. '">';	
	echo $row['fname'].' '.$row['lname'].','.$relation.'</a> <img class ="w3-circle" src="/images/'.$row['picture'].'" style="width:75%" alt="[images/'.$row['picture'].']"><br>';
	}
	?>
	
	</div>
    <div class="w3-padding-16"></div>
	<div class="w3-col l12 w3-container w3-padding-24 w3-gray">
	Life Event
	<table class="w3-table w3-striped">
	<th>Event</th><th>Notes:</th>
	<?php		
	$dbc = adminconnect();
	$query = "SELECT client_id, eventtype, notes FROM lifeevents  WHERE client_id = ".$_GET['p'].";";
	$results = pg_query($db_conn,$query);
	if(pg_num_rows($results) == 0){
		echo "<tr> <td> there is no data </td><td> please add a life event </td></tr>";
	}
	while ($row = pg_fetch_array($results)){
	echo "<tr><td>".$row['eventtype']."</td><td>".$row['notes']."</td></tr>";
	}
 
 ?>
	</table>
	<?php echo '<a class="w3-btn-block w3-indigo w3-grayscale-min w3-center" href="https://10.10.7.165/newRecord.php/?p='.$_GET['p'].'&m=1">Add Life Event</a>';?>
	</div>
</div>	
</div>
</div>
</body>
</html>