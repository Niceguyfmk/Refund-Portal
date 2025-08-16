<?php
//get data from form  
$fname = $_POST['fname'];
$email= $_POST['email'];
$message= $_POST['message'];
$to = "usmanhafiz723@gmail.com";
$subject = "Mail From website";
$txt ="Fname = ". $fname . "\r\n Email =" . $email . "\r\n Message =" . $message;
$headers = "From: usmanhafiz723@gmail.com" . "\r\n";
if($email!=NULL){
    mail($to,$subject,$txt,$headers);
}
//redirect
header("Location:index.html");
?>