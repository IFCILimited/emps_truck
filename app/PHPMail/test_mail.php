<?php
//error_reporting(1);
require 'PHPMailerAutoload.php';

$mail = new PHPMailer();
$mail->IsSMTP();
$mail->CharSet = 'UTF-8';

$mail->Host       = "smtpsgwhyd.nic.in"; // SMTP server example
$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
      
$mail->SMTPAuth = true;                // Enable SMTP authentication
$mail->Username = 'pm-edrive@gov.in'; // SMTP username
$mail->Password = 'Y5#dN7@pT2';      // SMTP password
//$mail->SMTPSecure = 'tls';             // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;   

$mail->IsHTML(true);
    

$mail->Subject = "Test Mail";
$mail->From = "pm-edrive@gov.in";
$mail->AddAddress('sandhya.singh@ifciltd.com');

$mail->Body = "This is a test mail";
$mail->send();
 echo "Mail Sent";
$mail->clearAddresses();
?>
