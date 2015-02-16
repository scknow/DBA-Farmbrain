<?php
/**
 * This example shows settings to use when sending via Google's Gmail servers.
 */
	//SMTP needs accurate times, and the PHP time zone MUST be set
	//This should be done in your php.ini, but this is how to do it if you don't have access to that
	date_default_timezone_set('Etc/UTC');
	$address=$_REQUEST['address'];
	$email_to=$_REQUEST['email_to'];
	$subject=$_REQUEST['subject'];
	$odr_id=$_REQUEST['order_no'];
	$total_price=$_REQUEST['price'];
	$req_date=$_REQUEST['d_day'];
	$name=$_REQUEST['supplier_name'];
	$Cname=$_REQUEST['cust_name'];
	$Cid=$_REQUEST['cust_id'];	
	$line_item_detail=$_REQUEST['line_item'];	
	
	$msg='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>DBA Farmbrain</title><style>	*{margin:0px;} *{padding:0px;}     body {margin: 0; padding: 0; min-width: 100%!important; font-family:calibri; font-size:14px;}</style></head><body><table style="width: 100%; float: left; background: #f3f3f3; box-shadow: 0 1px 2px rgb(160, 160,160);"><tr><td><img src="images/fb.png" style="padding: 12px 6px; float: left; width: 80px;"/><h1 style="width: auto; float: left; padding-top: 31px; font-size: 30px; color: #707070;">DBA</h1></td></tr></table><table class="table-full" style="width: 100%; float: left; margin-top: 25px;"><tr><td><big style="font-size: 14px; padding: 0 0 0 10px;font-weight: bold; color: black; display: block;">'.$name.',</big><p style="padding: 10px;">We are contacting you to let you know that PO #'.$odr_id.' has been processed. The details are listed below for your convenience.</p></td></tr></table><table class="table-full" style="width: 94%;float: left;margin: 25px 3% 0;background: #F1F6CA;border: 1px solid silver;"><tr><td><h2 style="padding:10px; border-bottom: 1px solid silver;">'.$Cname.' & '.$cid.'</h2></td></tr><tr><td><h3 style="padding:10px;">Delivery location:</h3></td></tr><tr>'.$address.'</tr><tr><td style="width: 100%;float: left;"><b style="width: 50%; float: left; clear: both; padding-left:10px; font-weight: normal;">PO# '.$odr_id.'</b></td></tr><tr><td style="width: 100%;float: left;"><b style="width: 50%; float: left; clear: both; padding-left:10px; font-weight: normal;">PO amount $'.$total_price.'</b></td></tr><tr><td style="width: 100%;float: left; margin-bottom:10px;"><b style="width: 50%; float: left; clear: both; padding-left:10px; font-weight: normal;">Delivery date: '.$req_date.'</b></td></tr>'.$line_item_detail.'	
	<tr><td><p style="width:98%; float:left; margin-top:25px; padding-left:10px;">If you have any questions, please contact '.$Cname.' </p></td></tr><tr><td><p style="width:98%; float:left; margin-top:25px; padding-left:10px;">Delivery confirmation will be sent when the customer receives this order</p></td></tr><tr><td><img src="images/fb.png" style="float:left; width:50px; padding:12px 6px;" /></td></tr><tr><td><p style="padding:10px;">Technical issue? We`re here to help! <b>Contact us anytime.</b><a href="#">SKC Support contact</a></p></td></tr>></table><table style="width: 100%; float: left; margin: 20px 0 10px;"><tr><td style="text-align: center; font-size: 12px; font-weight: 700; color: rgb(33, 32, 32);">Legal / technical / contact info required?</td></tr></table><table style="width: 100%; background: rgb(71, 71, 71);"><tr><td style="padding: 10px; color: white; font-size: 11px;">The email address linked to your DBA account is '.$email_to.'.<u>Update your email preferences</u> or <u>unsubscribe</u>. Note that even if you unsubscribe, we will send certain account-related emails, such as purchase details or requests for password resets. Have questions? We`re here to help! <u>Contact us anytime</u></td></tr></table></body></html>';
			
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
