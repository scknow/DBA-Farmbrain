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
	$uname=$_REQUEST['username'];
	$password=$_REQUEST['password'];
	$name=$_REQUEST['name'];
	

	$msg='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>    <head>        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />        <title>DBA Farmbrain</title>     <style>	 *{margin:0px;}     *{padding:0px;}     body {margin: 0; padding: 0; min-width: 100%!important; font-family:calibri;font-size:14px;}     </style>		    </head>    <body>    <table style="width: 100%; float: left; background:#f3f3f3; box-shadow: 0 1px 2px rgb(160, 160, 160);">    	<tr>        	<td><img src="images/fb.png" style="padding: 12px6px; float: left; width: 80px;"/>            <h1 style="width: auto; float: left; padding-top: 31px; font-size: 30px; color:#707070;">DBA</h1>            </td>        </tr>    </table>               <table style="width: 48%; float: left;">		  <tr>			  <td><h3 style="font-size: 21px; padding: 20px 12px; color: #a1b226; text-shadow: 0 1px 2px rgb(233, 233, 233);">Congratulations, you`ve been added to the Dutch Bakers account!</h3>			  </td>		  </tr>                    <tr>           <td>          	<big style="font-size: 15px; padding: 0 10px 0; display: block; font-weight: 600;">'.$name.'</big>            <p style="padding: 10px;">We are contacting you to let you know that  you have been registered  as a user for the DBA account. <br /><br />You&#39;ve just become part of a ground-breaking new approach to expanding your business. You will enjoy greater opportunity to reach farm markets in new and more meaningful ways - not to mention better reporting, real-time order and delivery data, and improved efficiencies in your customer relationships.</p>	</td>          </tr>			 
		</table>               <table style="width: 49%; float: left; background: #F1F6CA; border: 1px solid silver; margin-top: 25px;">
        	<tr>	<td style="width: 100%;float: left;">    <b style="width: 50%; float: left; clear: both; padding: 10px 0 10px 5%;">Your Username:</b>          <p style="width: 40%; float: left; padding: 10px 0 10px 5%;">'.$uname.'</p>                <b style="width: 50%; float: left; clear: both; padding: 10px 0 10px 5%;">Your Password:</b>                <p style="width: 40%; float: left; padding: 10px 0 10px 5%;">'.$password.'</p></td> <td style="width: 100%; float: left;">
             <h3 style="padding: 10px 10px 4px; font-size: 12px; font-weight: bold; color: #555555;">Technical issues? We&#39;re here to help!</h3> </td><td style="width: 100%; float: left;"><h2 style="font-size: 14px; padding-left: 4%; padding-top: 6px; width: auto; float: left;">Contact us anytime.</h2><h4 style="font-size: 13px; padding: 6px 0 13px 4%; width: auto; float: left; color: #7C8A16;">(SKC support contact)</h4></td></tr></table><table style="width: 49%; float: left;">
        	<tr><td><a href="#" style="width: 75%;margin: 20px auto;display: block;background: #a1b226;padding: 10px 0;border-radius: 3px;color: white;text-decoration: none;text-align: center;">Set Up My Account</a></td></tr></table>
        <table style="width: 100%; float: left; margin: 20px 0 10px;"><tr><td style="text-align: center; font-size: 12px; font-weight: 700; color: rgb(33, 32, 32);">Legal / technical / contact info required?</td></tr>
        </table><table style="width: 100%; background: rgb(71, 71, 71);"><tr>
              <td style="padding: 10px; color: white; font-size: 11px;">The email address linked to your DBA account is <namename123@internets.com>. <u>Update your email preferences</u> or <u>unsubscribe</u>. Note that even if you unsubscribe, we will send certain account-related emails, such as purchase details or requests for password resets. Have questions? We&#39;re here to help! <u>Contact us anytime</u></td>
            </tr></table></body></html>';
			
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
$mail->setFrom('dba-admin@farmbrain.com','DBA');

//Set an alternative reply-to address
$mail->addReplyTo('dba-admin@farmbrain.com','dba-admin@farmbrain.com');

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
