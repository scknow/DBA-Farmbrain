<?php
/**
 * This example shows settings to use when sending via Google's Gmail servers.
 */

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Etc/UTC');

	$msg=$_REQUEST['msg'];
	$email_to=$_REQUEST['email_to'];
	$subject=$_REQUEST['subject'];
	$msg=$_REQUEST['msg'];
			
require '../PHPMailerAutoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer;

//Tell PHPMailer to use SMTP
$mail->isSMTP();

//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 2;

//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';

//Set the hostname of the mail server
$mail->Host = 'email-smtp.us-east-1.amazonaws.com';

//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$mail->Port = 587;

//Set the encryption system to use - ssl (deprecated) or tls
$mail->SMTPSecure = 'tls';

//Whether to use SMTP authentication
$mail->SMTPAuth = true;

//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = "AKIAI4L6OBHSOX3X2IKA";

//Password to use for SMTP authentication
$mail->Password = "ApxPmq1eDoCqbBPqWxzPlLWEh/8UvsUgbF13FI3s4Gi/";

//Set who the message is to be sent from
$mail->setFrom('info@farm.ly','farm.ly');

//Set an alternative reply-to address
$mail->addReplyTo('no-reply@farm.ly','no-reply@farm.ly');

//Set who the message is to be sent to
$email_address=explode(",",$email_to);

for($i=0;$i<sizeof($email_address);$i++)
{
	$mail->addAddress($email_address[$i], '');
}

//Set the subject line
$mail->Subject = $subject;

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->msgHTML($msg, dirname(__FILE__));

//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}
