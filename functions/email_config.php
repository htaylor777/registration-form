<?php
include 'phpmailer/class.phpmailer.php';
include 'phpmailer/class.phpmaileroauth.php';
include 'phpmailer/class.phpmaileroauthgoogle.php';
include 'phpmailer/class.pop3.php';
include 'phpmailer/class.smtp.php';
include 'phpmailer/PHPMailerAutoload.php';

// I had to turn on (Less Secure App Access) in my google gmail:
// https://myaccount.google.com/security
$mail = new PHPMailer(); // globalize $mail var in functions.php
$mail->isSMTP();
$mail->Host = "tls://smtp.gmail.com";
$mail->Port = 587;
$mail->SMTPDebug = 0;
//$mail->Debugoutput = 'html';
$mail->SMTPSecure = "tls";
$mail->SMTPAuth = true; // Enable SMTP authentication
$mail->FromName = '';
$mail->Username = ''; // SMTP username
$mail->Password = ''; // SMTP password
