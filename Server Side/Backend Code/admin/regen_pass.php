<?php
include "connection.php";
session_start();
define("TABLE_NAME", $_POST["type"]);
if($_POST['action'] == 'regen_pass' && isset($_POST['action'])){
	// echo "help";
	$id=$_POST['field_id'];
	$fname=$_POST['firstname'];
	$lname=$_POST['lastname'];
	$username = $_POST['username']; //'sandeepsnapower@gmail.com'; 
	$password = substr(md5(uniqid(mt_rand(), true)), 0, 8);
	$sql = "UPDATE ". TABLE_NAME ." SET password='$password' WHERE userid='$id' ";
	mysql_query($sql);
	echo mysql_error();
	
	$to=$username;
	$subject="Welcome to DBA-Farmbrain";
	if(TABLE_NAME == 'user'){
		$body = $fname." ".$lname."<br /><br />
			Welcome to Farmbrain (DBA).<br /><br />
			Please download the app by clicking this link.<br /><br />
			You have been registered as a Customer User for ". $fname ." ". $lname ."<br /><br />
			Your user credentials are - <br />".
			$username ."<br />".
			$password ."<br /><br />
			Please change this password once you login. <br /><br />
			Best,<br /><br />
			Farmbrain DBA <br />";
	}else if(TABLE_NAME == 'salesuser'){
		$body = $fname." ".$lname."<br /><br />
			Welcome to Farmbrain (DBA).<br /><br />
			Please download the webapp by clicking this link.<br /><br />
			You have been registered as a Supplier User for ". $fname ." ". $lname ."<br /><br />
			Your user credentials are - <br />".
			$username ."<br />".
			$password ."<br /><br />
			Please change this password once you login. <br /><br />
			Best,<br /><br />
			Farmbrain DBA <br />";
	}
	// $body="Username: ".$username."<br />password: ".$password;
	$headers = 'From: dba.com' . "\r\n" .
		'Reply-To: info@dba.com' . "\r\n" .
		'X-Mailer: PHP/' . phpversion();
	$headers.="MIME-Version: 1.0" . "\r\n";
	$headers.="Content-type:text/html;charset=iso-8859-1" . "\r\n";
		
	//mail($to,$subject,$body,$headers);
	curl_post($to,$subject,$body);
	echo 'success';
}
function curl_post($email_to,$subject,$message)
	{
	$data_string = "msg=".$message."&email_to=".$email_to."&subject=".$subject;
	$ch = curl_init('http://geri.in/farmly/PHPMailer-master/examples/dba_gmail.php');                                                               
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
	//curl_setopt($ch, CURLOPT_HTTPHEADER,array("Content-Type : text","Content-lenght:".strlen($data_string)));  
	$result = curl_exec($ch);
	}
	
?>