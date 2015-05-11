<?php
require("sendgrid-php/sendgrid-php.php");
// Check for empty fields
if(empty($_POST['name'])  		||
   empty($_POST['email']) 		||
   empty($_POST['phone']) 		||
   empty($_POST['message'])	||
   !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
   {
	echo "No arguments Provided!";
	return false;
   }

$sendgrid_username = $_ENV['SENDGRID_USERNAME'];
$sendgrid_password = $_ENV['SENDGRID_PASSWORD'];
$to = $_ENV['TO']; 

$sendgrid = new SendGrid($sendgrid_username, $sendgrid_password, array("turn_off_ssl_verification" => true));
$email    = new SendGrid\Email();

$name = $_POST['name'];
$email_address = $_POST['email'];
$phone = $_POST['phone'];
$message = $_POST['message'];

$email_subject = "Website Contact Form:  $name";
$email_body = "You have received a new message from your website contact form.\n\n"."Here are the details:\n\nName: $name\n\nEmail: $email_address\n\nPhone: $phone\n\nMessage:\n$message";
$headers = "From: noreply@terocollege.com\n"; // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com.
$headers .= "Reply-To: $email_address";   

// Create the email and send the message
$email->addTo($to)->
       setFrom($to)->
       setSubject($email_subject)->
       setText($email_body)->
       addHeader($headers);


$response = $sendgrid->send($email);
return true;			
?>