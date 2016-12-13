<?php
session_start();
if ($_SESSION['loggedin'] !== TRUE) {
	header("Location: index2.php");
	echo '<p>You must log in first<p>';
	exit();
	}
?>
<?php include 'includes.php';?>
<?php
   if ($_SERVER[ 'REQUEST_METHOD' ] == 'POST') {
		$dbc = adminconnect();
	$randomString = '';
	if(isset($_FILES['image'])){
	$trimmed = trim($_SESSION['username']);
	$query = "select id from adminlist where username = '$trimmed'";
	$result = pg_query($dbc,$query);
	$id = pg_fetch_result($result,0,0);
	$query = "select picture from people where id ='$id'";
	$result = pg_query($dbc, $query);
	$randomString = pg_fetch_result($result,0,0);
	if($randomString == 'default-profile.png'){
		$randomString = '';
	}
	else{
	if(unlink($randomString)){
		echo 'file deleted ';
	}}} 
	$randomString = upload();
	if($randomString ==''){
	   $randomString = 'default-profile.png';
	   }
	$update = "update people set picture = '$randomString' where id ='$id'";
	echo $update;
	$updateresults = pg_query($dbc,$update);
	if($updateresults){
		header("Location: lifecoachlanding3.php");
		exit();
	}
   }
?>
<html>


   <body>
      
      <form action = "/upload.form.php" method = "POST" enctype = "multipart/form-data">
         <input type = "file" name = "image" />
         <input type = "submit"/>		
      </form>
      
   </body>
</html>