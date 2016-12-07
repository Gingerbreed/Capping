<?php
session_start();
if ($_SESSION['loggedin'] !== TRUE) {
   header("Location: index2.php");
   echo '<p>You must log in first<p>';
   exit();
}
?>
<?php include 'includes.php' ;?>
<html>
<link rel="stylesheet" href="/CSS/TCw3.css">
<link rel="stylesheet" href="/CSS/TCw3Apple.css">
		<!--	<style>
				h1{font-family: times;}
				 html, body {height: 100%;
							 margin: 0;}
				#wrapper { min-height: auto;
						   margin:auto;	}
						   body {margin: 0;}
				#top{height:100%;
				     overflow:hidded;}

ul.topnav {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #333;
}

ul.topnav li {float: left;}

ul.topnav li a {
    display: block;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

ul.topnav li a:hover:not(.active) {background-color: #111;}

ul.topnav li a.active {background-color: #4CAF50;}

ul.topnav li.right {float: right;}

@media screen and (max-width: 600px){
    ul.topnav li.right, 
    ul.topnav li {float: none;}
}
				
			</style> -->
 <Head>
  <title> True Course </title>
 </Head>
 <body class="w3-light-gray" onresize="onResize()">
 <div class="w3-top w3-ap5xlarge">
 <ul class="w3-navbar w3-black"><!--class="topnav"-->
  <li><a class="" href="/index2.php">Home</a></li>
        <li><a href="/clientcontact.php">Messages<span class="w3-badge w3-blue w3-right">  <?php $dbconn = adminconnect(); 
		$trim = trim($_SESSION['username']);
		echo notify($dbconn, $trim);
		?></span> </a></li>
  <li class="w3-right"><a href="/logout.php">Logout</a></li>
</ul>
</div>
 <div class="w3-indigo w3-grayscale-min w3-container w3-card-4 w3-center TC-pad-top l m s ap5 w3-xlarge w3-ap5super">
 <?php

  echo'<div> Welcome back, '.$_SESSION['coachname'].'</div>';
  ?>
 </div>
 <div id="wrapper" class="w3-row w3-light-gray w3-ap5jumbo">
	<div id="top" class=" w3-container w3-card-16 w3-center w3-light-gray w3-col l3 m6 s12 a12p5 a12p6 a12p6P TC-full l s a5 a6 a6P" >
    <div class="w3-padding-16"></div>
	<?php
	$db_conn = connect();
	$trim = trim($_SESSION['username']);
	$query="select picture from people p, lifecoaches l where l.personid=p.id and username ='$trim'";
	$result = pg_query($db_conn, $query);
	echo'<img class="w3-circle w3-card-8" src="images/'.pg_fetch_result($result,0,0).'" style="width:75%" alt="[Picture of Client 1]">'?>
	<br>
	<p><?php
		echo $_SESSION['coachname'];
		?></p>
		<p><div><a class="w3-btn-block w3-grayscale-min w3-round-xlarge w3-indigo w3-border-gray w3-bottombar" href="clientcontact.php"> Messages<span class="w3-badge w3-blue w3-right"> <?php $dbconn = adminconnect(); 
		$trim = trim($_SESSION['username']);
		echo notify($dbconn, $trim);
		?></span></div></a></p>
		<p><a class="w3-btn-block w3-grayscale-min w3-round-xlarge w3-indigo w3-border-gray w3-bottombar" href="logout.php"> Logout </a></p>
	</div>
	<div id="row" class="w3-light-gray w3-container w3-rest">
	<div class="w3-panel w3-indigo w3-grayscale-min">
	<p>Clients</p>
	</div>
		<div  class="w3-row w3-center">
	<?php
	$db_conn = connect();
	$query = "select fname,lname,id, picture from clientlist where companyid ='".$_SESSION['company']."';";
	$results = pg_query($db_conn, $query);
	while ($row = pg_fetch_array($results)) {
	echo'<a href="clientview2.php/?p='.$row['id']. '">
			<div class="w3-indigo w3-grayscale-min w3-container w3-card-4 w3-hover-blue w3-col l3 m6 s12 a12p5 a12p6 a12p6P w3-border w3-round-xlarge CLIENTLIST">
            <div class="w3-padding-4"></div>
			
			<img class="w3-circle"src="images/'.$row['picture'].'" style="width:75%" alt="[images/'.$row['picture'].']">
			<p>'.$row['fname'].' '.$row['lname'].'</p>
			</div>';

}
?>			
			</div>
			
		</div>
 </div>
 <script>
 var test = document.getElementsByClassName("CLIENTLIST");

function getMaxOfArray(numArray) {
  return Math.max.apply(null, numArray);
}

var arr = [0];
for (i = 0; i < test.length; i++) { 
	console.log(test[i].clientHeight);
	arr.push(test[i].clientHeight);
}

console.log("loopend")
max = getMaxOfArray(arr);
console.log(max);

for (i = 0; i < test.length; i++) { 
	test[i].style.height = max;
}
function onResize(){
	var arr2 = [0];

	for (i = 0; i < test.length; i++) { 
		test[i].style.height = "auto";
		console.log(test[i].clientHeight);
		arr2.push(test[i].clientHeight);
	}
	
	max = getMaxOfArray(arr2);
	console.log(max);
	
	for (i = 0; i < test.length; i++) { 
		test[i].style.height = max;
	}
	
	console.log("it works");
}
 </script>
 </body>
</html>
