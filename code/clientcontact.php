<?php
session_start();
if ($_SESSION['loggedin'] !== TRUE) {
	header("Location: index2.php");
	echo '<p>You must log in first<p>';
	exit();
	}
?>
<html>

<?php include 'includes.php';?>
<link rel="stylesheet" href="/CSS/TCw3.css">
<link rel="stylesheet" href="/CSS/TCw3Apple.css">
<link href="/CSS/responsive-calendar.css" rel="stylesheet">
<Head>
  <title> True Course </title>
</Head>
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
    <div class="w3-padding-24"></div>
    <div class="w3-container w3-white w3-col a12p5 l6">
        <div class="w3-container">
      <!-- Responsive calendar - START -->
    	<div class="responsive-calendar">
        <div class="controls">
            <a class="pull-left" data-go="prev"><div class="btn w3-btn w3-round-xxlarge w3-indigo w3-grayscale-min w3-hover-blue btn-primary">Prev</div></a>
			<h4 class="w3-xlarge w3-padding-xlarge"><span data-head-year></span> <span data-head-month></span></h4>
            <a class="pull-right" data-go="next"><div class="btn w3-btn w3-round-xxlarge w3-indigo w3-grayscale-min w3-hover-blue btn-primary">Next</div></a>
        </div><hr/>
        <div class="day-headers">
          <div class="day header">Mon</div>
          <div class="day header">Tue</div>
          <div class="day header">Wed</div>
          <div class="day header">Thu</div>
          <div class="day header">Fri</div>
          <div class="day header">Sat</div>
          <div class="day header">Sun</div>
        </div>
        <div class="days" data-group="days">
          
        </div>
      </div>
      <!-- Responsive calendar - END -->
    </div>
	<?php 
	if ($_SERVER[ 'REQUEST_METHOD' ] == 'GET') {
	$trim = trim($_SESSION['username']);
	$dbc = adminconnect();
	$query = "select count(*) from  clientcontacts where lifecoach ='$trim' and completed = false";
	$result = pg_query($dbc,$query);
	$count = pg_fetch_result($result,0,0);
	$query = "SELECT client,dateofcontact,notes FROM clientcontacts
		where lifecoach ='$trim'  and completed = false";
	$results = pg_query($dbc,$query);
	for($i=0;$i<$count;$i++){
		if(isset($_GET['con'.$i])){
		if($_GET['con'.$i]=='on'){
			$row = pg_fetch_array($results,$i);
			$query = "update clientcontacts set completed=true where lifecoach='$trim' and client='".$row['client']."' and dateofcontact='".$row['dateofcontact']."'";
			$result = pg_query($dbc,$query);
		}
		}
	}
	}
	if ($_SERVER[ 'REQUEST_METHOD' ] == 'POST') {
	$db_conn = adminconnect();
	$date =  validate($_POST['dateofcontact']);
	$client =  validate($_POST['client']);
	$notes = validate($_POST['notes']);
	$trim = trim($_SESSION['username']);
	$query = "insert into clientcontacts values($client,'$trim','$date','$notes ',false)";
	#echo $query;
	$result = pg_query($db_conn, $query);
	}
	?>
    <script src="../js/jquery.js"></script>
    <script src="../js/responsive-calendar.min.js"></script>
    <script src="../js/responsive-calendar.js"></script>
    <script type="text/javascript">
		var date = new Date();
		var month = date.getMonth()+1;
		var year = date.getFullYear();
		var datestring = (year+'-'+month);
		console.log(datestring);
      $(document).ready(function () {
        $(".responsive-calendar").responsiveCalendar({

          time: datestring,
          events: {
		  		  <?php 
		  $db_conn = adminconnect();
		  $trim = trim($_SESSION['username']);
		  $query =  "select dateofcontact from  clientcontacts where lifecoach ='$trim' and completed = false";
		  $results = pg_query($db_conn,$query);
		  while($row =  pg_fetch_array($results)){
			  $query= "select count(*) from  clientcontacts where dateofcontact='".$row['dateofcontact']."'and lifecoach ='$trim' and completed = false";
			  $result = pg_query($db_conn, $query);
				echo '"'.$row['dateofcontact'].'": {"number": '.pg_fetch_result($result, 0,0) .'},';
				
		  }
		  
		  #echo '"2016-12-03": {"number": 1},';
		  ?>
           }
        });
      });
    </script>
    </div>
    <div class="w3-row">
    <div class="w3-container w3-white w3-grayscale-min w3-border-indigo w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-center w3-col a12p5 l6 m12 s12">
    
	 Appointments
		<?php
		$conn_string = "host=10.10.7.166 port=5432 dbname=Test user=morgan password=MorganBaker";
		$db_conn = pg_connect($conn_string);
		if(!$db_conn){
			echo 'check connection :/';
		}
        
		$trimmed = trim($_SESSION['username']);
		$query = "SELECT fname, lname,completed, dateofcontact,notes FROM clientlist l, clientcontacts c 
		where l.id = c.client and c.lifecoach ='$trimmed'  and completed = false";
		$results = pg_query($db_conn,$query);
		echo'<form action="/clientcontact.php" method="GET">';
        echo'<table class="w3-table w3-striped">
        <tr>
        <th>Appt. Date</th>
        <th>Client Name</th>
        <th>Completed</th>
		<th>Notes</th>
        </tr>';
		$var = 0;
		while($row =  pg_fetch_array($results)){
		echo'<tr>
        <td>'.$row['dateofcontact'].'</td>
        <td>'.$row['fname'].' '.$row['lname'].'</td>
        <td><input type="checkbox" class="w3-checkbox" name= "con'.$var.'" /> </td>
		<td>'.$row['notes'].'</td>
        </tr>';
		$var = $var + 1;
		}
        echo'</table>';
        echo'<input class="w3-btn w3-indigo w3-grayscale-min w3-border w3-bottombar bw-border-gray w3-round-xlarge" type="submit" value="Update">';
		echo'</form>';
        ?>
	<div class="w3-row">
			New Appointment
    <form action="/clientcontact.php/" method="POST">
		<?php 
		$query = "SELECT fname, lname, id FROM clientlist
        where companyid ='".$_SESSION['company']."';";
        $results = pg_query($db_conn,$query);
        echo 'Client:<br>
		<select class="w3-input w3-light-gray" name = "client">';
        while ($row = pg_fetch_array($results)) {
        echo'<option value="'.$row['id'].'">'.$row['fname'].' '.$row['lname'].'</option>'; // Format for adding options 
        }
        echo'</select><br>'?>
		Date of Appointment:<br>
       <input class="w3-input w3-light-gray" type="date" name="dateofcontact"><br>
        Notes:<br>
	   <input class="w3-input w3-light-gray" type="text" name="notes"><br>
       
  

	<input class="w3-btn w3-indigo w3-grayscale-min w3-border w3-bottombar bw-border-gray w3-round-xlarge" type="submit" value="Submit">
    </form>
	</div>
    </div>    
    </div>
</body>
</html>