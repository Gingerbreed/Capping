<!--
This file contains PHP helper functions.
-->
<?php
function logout(){
session_unset();
session_destroy();
ob_start();
header("location:home.php");
ob_end_flush(); 
die();
}
function connect(){
$conn_string = "host=10.10.7.166 port=5432 dbname=Test user=server password=server";
	$db_conn = pg_connect($conn_string);
	if(!$db_conn){
		echo 'check connection :/';
	}
return $db_conn;
}
function adminconnect(){
$conn_string = "host=10.10.7.166 port=5432 dbname=Test user=morgan password=MorganBaker";
	$db_conn = pg_connect($conn_string);
	if(!$db_conn){
		echo 'check connection :/';
	}

return $db_conn;
}
function notify($dbconn){
	$trim = trim($_SESSION['username']);
	$query = "select count(*) from clientcontacts where lifecoach = '".$trim."' and completed = false";
	$result = pg_query($dbconn, $query);
	return pg_fetch_result($result, 0,0);
}
function validate($data){
$data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
function validtrim($data){
$data = stripslashes($data);
  $data = htmlspecialchars($data);
  $data = trim($data);
  return $data;
}
function upload(){
	$randomString = '';
	if(isset($_FILES['image'])){
      $errors= array();
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		for ($i = 0; $i < 31; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
		}	
      $file_name = $randomString.".png";
	  $randomString = $file_name;
	  $file_size = $_FILES['image']['size'];
      $file_tmp = $_FILES['image']['tmp_name'];
      $file_type = $_FILES['image']['type'];
      $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
      
      $expensions= array("jpeg","jpg","png");
      
      if(in_array($file_ext,$expensions)=== false){
         $errors[]="extension not allowed, please choose a JPEG or PNG file.";
      }
      
      if($file_size > 2097152) {
         $errors[]='File size must be excately 2 MB';
      }
      
      if(empty($errors)==true) {
         move_uploaded_file($file_tmp,"images/".$file_name);
		 return $randomString;
      }else{
         echo($errors);
      }
   }
   return '';
}
?>