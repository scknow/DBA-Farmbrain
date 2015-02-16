<?php
include "dbcon.php";
$cp = $_GET['cp'];
$sql = "SELECT * FROM user WHERE username='$cp'";
$result = mysql_query($sql);

if(mysql_num_rows($result)!=0)
{	
	$password =  substr(md5(uniqid(mt_rand(), true)), 0, 5);
	$row=mysql_fetch_array($result);
	$name_of_u=$row['firstname'] ." ".$row['lastname'];
	$body = $row['firstname']." ".$row['lastname']."<br /><br />Welcome to Farmbrain (DBA).<br /><br />
			Please download the webapp by clicking this link.<br /><br />You have been registered as a Supplier User for ".$row['firstname']." ".$row['lastname']."<br /><br />
			Your user credentials are - <br />".$username ."<br />".$password ."<br/><br />Please change this password once you login. <br /><br />Best,<br /><br />
			Farmbrain DBA <br />";
			
	curl_post($cp,$subject,$body,$cp,$password,$name_of_u);	
	$sql = "UPDATE user SET password='$password' WHERE username='$cp'";
	mysql_query($sql);
	echo mysql_error();
	echo 1;
}else
{
	echo 0;
}

function curl_post($email_to,$subject,$message,$uname,$pass,$name)
{
	$data_string = "msg=".$message."&email_to=".$email_to."&subject=".$subject."&username=".$uname."&password=".$pass."&name=".$name;
	$ch = curl_init('http://geri.in/farmly/PHPMailer-master/examples/supplier_user_mail.php');                                                               
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
	//curl_setopt($ch, CURLOPT_HTTPHEADER,array("Content-Type : text","Content-lenght:".strlen($data_string)));  
	$result = curl_exec($ch);
}
	
	
?>