<?php 

session_start();
$errors = [];
$user_id = "";
// connect to database
$db = mysqli_connect('localhost', 'root', '', 'espace');

// LOG USER IN


/*
  Accept email of user whose password is to be reset
  Send email to user to reset their password
*/
if (isset($_POST['reset-password'])) {
  $email = mysqli_real_escape_string($db, $_POST['email']);

  // ensure that the user exists on our system
  $query = "SELECT email FROM espace WHERE email='$email'";
  $results = mysqli_query($db, $query);

  if (empty($email)) {
    array_push($errors, "Your email is required");

  }else if($results->num_rows<= 0) {
    
header("location: enter_email.php?notexist=1");
  }


  if (count($errors) == 0) {
  
require 'PHPMailerAutoload.php';

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';    // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'youemail';                 // SMTP username
$mail->Password = 'code of your email';                           // SMTP password
//$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 25;  
$mail->setFrom('youremail', 'Mailer');
$mail->addAddress( $email, 'Joe User');     // Add a recipient
//$mail->addAddress('ellen@example.com');               // Name is optional
//$mail->addReplyTo('info@example.com', 'Information');
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');
//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');   // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'reset password';
$link_address='localhost/Espace/new_pass.php?email='.$email;
$mail->Body    =  "Hi there, click on this <a href='$link_address'>Link</a>; to reset your password on our site";
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
$mail->send();
    header('location: pending.php?email=' . $email);  }
}

// ENTER A NEW PASSWORD


if (isset($_POST['new_password'])) {
 $new_pass =filter_input(INPUT_POST,'new_pass') ;
   $new_pass=md5($new_pass);
  $new_pass_c=filter_input(INPUT_POST,'new_pass_c') ;
 $new_pass_c=md5($new_pass_c);

$emaile=$_GET['email'];
  if(!empty($new_pass) and !empty($new_pass_c) and  $new_pass==$new_pass_c ){
  $host = "localhost";
  $dbusername = "root";
  $dbpassword = "";
  $dbname = "espace";
$conn = new mysqli ($host,$dbusername,$dbpassword,$dbname);

if (mysqli_connect_error()) {

  die('connect Error ('.mysqli_connect_errno().')'.mysqli_connect_error());
}
else {
  $sql = "UPDATE espace SET password='$new_pass',confirmps=' $new_pass_c' where email='$emaile'";
  if($conn->query($sql)){

header("location: espacetr.php?statu=1");
}
else {

header("location: new_pass.php?stat=1");
 }
 $conn->close();
 }  
 
} 
else{

header("location: new_pass.php?stat=0");
}
}














