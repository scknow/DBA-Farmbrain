<?php
//require_once('class.phpmailer.php');
require 'PHPMailerAutoload.php';
	global $error;
	$mail = new PHPMailer();  // create a new object
	$mail->IsSMTP(); // enable SMTP
	$mail->SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
	$mail->SMTPAuth = true;  // authentication enabled
	$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
	$mail->Host = 'smtp.gmail.com';
	$mail->Port = 465; 
	$mail->Username = 'yourfullgmailaddress';  
	$mail->Password = 'yourgmailpwd';           
	$mail->SetFrom('yourfullgmailaddress', 'your name');
	$mail->Subject = 'Mail Test';
	$mail->Body = 'Hello Friend';
	$mail->AddAddress('towhomtobesent@gmail.com');
	//$mail->AddAddress('towhomtobesent@gmail.com');//add another recipient
	if(!$mail->Send()) {
		echo $error = 'Mail error: '.$mail->ErrorInfo; 
		return false;
	} else {
		echo $error = 'Message sent!';
		return true;
	}
?>