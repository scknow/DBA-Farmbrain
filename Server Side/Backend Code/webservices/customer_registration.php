<?php
include "dbcon.php";

$json = $_POST['cr'];
$json = stripslashes($json);
$cr_data = json_decode($json, true);

$sql = "INSERT INTO customer(businessname, businessownername, billtoaddress1, billtoaddress2, billtocity, billtostate, billtocountry, billtozip, billtophone, billtofax, billtoemail, billtocellphone, shiptoaddress1, shiptoaddress2, shiptocity, shiptostate, shiptocountry, shiptozip, shiptophone, shiptofax, shiptoemail, shiptocellphone, defaultnotification, DUNS, federalidnumber, website,daysofoperation,listofdocuments,businesspic,approved) VALUES ('".trim($cr_data['businessname'])."', '".trim($cr_data['businessownername'])."', '".trim($cr_data['billtoaddress1'])."', '".trim($cr_data['billtoaddress2'])."', '".trim($cr_data['billtocity'])."', '".trim($cr_data['billtostate'])."', '".trim($cr_data['billtocountry'])."', '".trim($cr_data['billtozip'])."', '$".trim($cr_data['billtophone'])."', '".trim($cr_data['billtofax'])."', '".trim($cr_data['billtoemail'])."', '".trim($cr_data['billtocellphone'])."', '".trim($cr_data['shiptoaddress1'])."', '".trim($cr_data['shiptoaddress2'])."', '".trim($cr_data['shiptocity'])."', '".trim($cr_data['shiptostate'])."', '".trim($cr_data['shiptocountry'])."', '".trim($cr_data['shiptozip'])."', '".trim($cr_data['shiptophone'])."', '".trim($cr_data['shiptofax'])."', '".trim($cr_data['shiptoemail'])."', '".trim($cr_data['shiptocellphone'])."', '".trim($cr_data['defaultnotification'])."', '".trim($cr_data['DUNS'])."', '".trim($cr_data['federalidnumber'])."', '".trim($cr_data['website'])."','ttttttt','a','a',0)";

mysql_query($sql);
$username=$cr_data['email'];
$firstname=$cr_data['fname'];
$lastname=$cr_data['lname'];
$password = substr(md5(uniqid(mt_rand(), true)), 0, 8);

$businessname=$cr_data['businessownername'];
$sql="SELECT MAX( customerid  ) FROM customer";
			$result=mysql_query($sql);
			$temp=mysql_fetch_array($result);
			$max_id = $temp['MAX( customerid  )'];
			$result = mysql_query($sql);
			
		$sql = "INSERT INTO user(username, password, firstname, lastname, customerid, active) VALUES ('$username', '$password', '$firstname', '$lastname', '$max_id', '1')";
		mysql_query($sql);
$subject="DBA user password";
$body="Username:".$username."<br>password:".$password;
$sql = "SELECT * FROM supplier";
			$result = mysql_query($sql);
			while($row=mysql_fetch_array($result)){
				$supplierid = $row['supplierid'];
				$sql1 = "INSERT INTO suppliercustomer(supplierid, customerid, customerbusinessname, salesuserid, salesfirstname, saleslastname, suppliersidecustomerid, minimumordervalue, ordertolerancevalue, approve) VALUES ('$supplierid', '$max_id', '$businessname', '', '', '', '', '0', '0', 0)"; 
				//echo $sql1;
				$result1 = mysql_query($sql1);
				echo mysql_error();
			}
			
	$data_string = "username=".$username."&password=".$password."&email_to=".$username."&subject=".$subject."&Cname=".$firstname." ".$lastname;
	$ch = curl_init('http://geri.in/farmly/PHPMailer-master/examples/customer_mail.php');                                                               
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
	//curl_setopt($ch, CURLOPT_HTTPHEADER,array("Content-Type : text","Content-lenght:".strlen($data_string)));  
	$result = curl_exec($ch);
	
	

echo $cr_data['businessownername'];

?>