<?
include "config.php";
function get_customer_name($customer_id)
{
	$row=mysql_query("select * from customer where customerid='$customer_id'");
	$rows=mysql_fetch_array($row);
	return $rows['businessname'];
}
function get_max_id_table($tbl_name,$fldname)
{
	$sql="SELECT MAX($fldname) FROM $tbl_name";
	$result=mysql_query($sql);
	$temp=mysql_fetch_array($result);
	$max_id = $temp['MAX( id )'] +1;
}
function send_mail($user_email,$created_by)
{
	//define the receiver of the email
	$to = $email_to;
	//define the subject of the email
	$subject = 'New ticket has been created'; 
	//create a boundary string. It must be unique 
	//so we use the MD5 algorithm to generate a random hash
	$random_hash = md5(date('r', time())); 
	//define the headers we want passed. Note that they are separated with \r\n
	$headers = "From: no-reply@dba.co";
	//add boundary string and mime type specification
	$headers .= "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\""; 
	//define the body of the message.
	ob_start(); //Turn on output buffering
?>
--PHP-alt-<?php echo $random_hash; ?>  
Content-Type: text/plain; charset="iso-8859-1" 
Content-Transfer-Encoding: 7bit

--PHP-alt-<?php echo $random_hash; ?>  
Content-Type: text/html; charset="iso-8859-1" 
Content-Transfer-Encoding: 7bit

<br>
--PHP-alt-<?php echo $random_hash; ?>--
<?php
}
?>