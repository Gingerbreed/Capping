<html>
<link rel="stylesheet" href="/CSS/w3.css">
<link rel="stylesheet" href="/CSS/TCw3Apple.css">
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
		$dbc = adminconnect();
	$randomString = '';
	if(isset($_FILES['image'])){
	$query = 'select picture from people where id ='.$_GET['p'].'';
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
	   
	$telly = $_POST['str1'].$_POST['str2'].$_POST['str3'];
	#echo $telly;
	$update = "update clients set telephone = '$telly', favoritebook = '".$_POST['favoritebook']."', favoritefood = '".$_POST['favoritefood']."', preferredpractice = '".$_POST['hobby']."', whentocall = '".$_POST['call']."', whentovisit = '".$_POST['visit']."' where person_id = ".$_GET['p'];
	#echo $update;
	$updateresults = pg_query($dbc,$update);
	#echo $updateresults;
	$update = "update people set address = '".$_POST['address']."', email = '".$_POST['email']."', picture = '$randomString' where id ='".$_GET['p']."';";
	$updateresults = pg_query($dbc,$update);
#	echo $updateresults;
	}
 
 ?>
 <?php
	$db_conn = connect();
	$query = "SELECT fname, lname, address, email,favoritefood, favoritebook, telephone,whentocall,whentovisit, preferredpractice FROM clientlist c WHERE c.id = ".$_GET['p']." and c.companyid =".$_SESSION['company'].";";
#	echo $query ."<br>";
	$results = pg_query($db_conn,$query);
	$row = pg_fetch_array($results);
	?>
<body>
	<div class="w3-container w3-rest w3-gray w3-ul">
	<div class="w3-container w3-indigo w3-grayscale-min">
	
<?php
	if ($_SERVER[ 'REQUEST_METHOD' ] == 'POST') {
	echo "Client has been updated";
	}
	?>
	</div>
	<?php echo "<form action='?p=".$_GET['p']."' method='POST' enctype = 'multipart/form-data'>" ?>
		<table class="w3-table w3-striped">
			<tr>
				<td>Email: </td><td> <?php echo "<input type = 'text' name ='email' value='" .$row['email']. "'>"?></td>
			</tr>
			<tr>
				<td>Home Address: </td><td> <?php echo "<input type = 'text' name ='address' value='" .$row['address']. "'>"?></td>
			</tr>
			<tr>
				<td>Phone: </td><td> <?php echo "(<input type = 'text' maxlength=3 size=3 name ='str1' value='".substr($row['telephone'],0,3)."'>)-
					<input type = 'text' maxlength=3 size=3 name ='str2' value='".substr($row['telephone'],3,3)."'>-
					<input type = 'text' maxlength=4 size=4 name ='str3' value='".substr($row['telephone'],6)."'>"?></td>
			</tr>
			<tr>
				<td>Favorite Food: </td><td><?php echo "<input type = 'text' name ='favoritefood' value='" .$row['favoritefood']."'>"; ?></td>
			</tr>
			<tr>
				<td>Favorite Book: </td><td><?php echo "<input type = 'text' name ='favoritebook' value='".$row['favoritebook']."'>"; ?></td>
			</tr>
			<tr>
				<td>Prefered Hobby: </td><td><?php echo "<input type = 'text' name ='hobby' value='" .$row['preferredpractice']."'>"; ?></td>
			</tr>
			<tr>
				<td>When to Call: </td><td><?php echo "<input type = 'text' name ='call' value='" .$row['whentocall']."'>"; ?></td>
			</tr>
			<tr>
				<td>When to Visit: </td><td><?php echo "<input type = 'text' name ='visit' value='" .$row['whentovisit']."'>"; ?></td>
			</tr>
			<tr>
				<td>Image: </td><td><?php echo "<input type = 'file' name = 'image'/>"; ?></td>
			</tr>
		</table>
		<input class="w3-btn-block w3-indigo w3-grayscale-min w3-center" type = "submit" value = "Update"></input>
		</form>
		<?php echo'<a class="w3-btn-block w3-indigo w3-grayscale-min w3-center" href="https://10.10.7.165/clientview2.php/?p='.$_GET['p'].'">Back</a>';?>
	</div>


</body>
</html>