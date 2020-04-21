<?php

if (isset($_POST['register'])) {
$firstname = filter_input(INPUT_POST, 'firstname') ;
$lastname = filter_input(INPUT_POST, 'lastname') ;
$cne = filter_input(INPUT_POST, 'cne') ;
$email = filter_input(INPUT_POST, 'email') ;
$password = filter_input(INPUT_POST, 'password') ;
$password=md5($password);
$confirmps =filter_input(INPUT_POST, 'confirmps') ;
$confirmps =md5($confirmps );
if ($confirmps!=$password) {

header("location: forum.php?nonegal=0");

}else{
	if(!empty($firstname) and !empty($lastname) and !empty($cne) and !empty($email) and !empty($password) and !empty($confirmps)){
	$host = "localhost";
	$dbusername = "root";
	$dbpassword = "";
	$dbname = "espace";
$conn = new mysqli ($host,$dbusername,$dbpassword,$dbname);

if (mysqli_connect_error()) {

	die('connect Error ('.mysqli_connect_errno().')'.mysqli_connect_error());
}
else {
$sql="INSERT INTO espace values('','$firstname','$lastname','$cne','$email','$password','$confirmps')";
if($conn->query($sql)){
header("location: espacetr.php?status=1");
}
else {
header("location: forum	.php?status=0");
 }
 $conn->close();
 }  
 
} 
}

}



if (isset($_POST['login'])) {
$email =filter_input(INPUT_POST,'email') ;
$password=filter_input(INPUT_POST,'password') ;

	if(!empty($email) and !empty($password)){
	$host = "localhost";
	$dbusername = "root";
	$dbpassword = "";
	$dbname = "espace";
$conn = new mysqli ($host,$dbusername,$dbpassword,$dbname);

if (mysqli_connect_error()) {

	die('connect Error ('.mysqli_connect_errno().')'.mysqli_connect_error());
}
else {
$sql="SELECT email,password FROM espace where email='".$email."' and password='".md5($password)."'";
$result=$conn->query($sql);
if($result->num_rows==1){

header("location: espacetr.php?statu=0");
}
else {

header("location: forum.php?stat=0");
 }
 $conn->close();
 }  
 
} 
}
 ?>
<!-- https://www.youtube.com/watch?v=bWUSX8CzbRw



 
-->