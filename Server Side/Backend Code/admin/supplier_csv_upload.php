<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Upload page</title>

</head>
<body>
<div id="container">
<div id="form">
<span id="msg"><span>
<?php
//Create connection
include "connection.php";

//Upload File
if (!isset($_POST['upload_csv'])) {
	// if (is_uploaded_file($_FILES['filename']['tmp_name'])) {
		// // echo "<h1>" . "File ". $_FILES['filename']['name'] ." uploaded successfully." . "</h1>";
	// }
	// // echo "HERE";die;
	// $emailval = '/([\w\-]+\@[\w\-]+\.[\w\-]+)/';
	// $mob='/^\d+$/';
	
	// $handle = fopen($_FILES['filename']['tmp_name'], "r");
	// $hdata = fgetcsv($handle, 1000, ",");
	// $header ="";
	// foreach($hdata as $h)
	// {
		// if(trim($h)!="")
			// $header .= trim($h) . ', ';
	// }
	// $header .= 'Error Description';
	// $status = "true";
	// $msg = "";
	// $out="";
	// $err = false;
	// $line_no=2;
	// while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
	// {
		// //echo $data[0];
		// if ((trim($data[1])=="")||(trim($data[2])=="")||(trim($data[3])=="")||(trim($data[5])=="")||(trim($data[6])=="")||(trim($data[7])=="")||(trim($data[8])=="")||(trim($data[9])=="")||(trim($data[11])=="")||(trim($data[12])=="")||(trim($data[13])=="")||(trim($data[14])=="")||(trim($data[15])=="")||(trim($data[16])=="")||(trim($data[17])=="")||(trim($data[18])=="")||(trim($data[19])=="")||(trim($data[21])=="")||(trim($data[22])=="")||(trim($data[23])=="")||(trim($data[25])=="")||(trim($data[26])==""))
		// {
			// $msg = "Some field is missing. Not uploading.<br> ";
			// $out .= $data[0] . ', ';
			// $out .= $data[1] . ', ';
			// $out .= $data[2] . ', ';
			// $out .= $data[3] . ', ';
			// // $out .= $data[4] . ', ';
			// $out .= $data[5] . ', ';
			// $out .= $data[6] . ', ';
			// $out .= $data[7] . ', ';
			// $out .= $data[8] . ', ';
			// $out .= $data[9] . ', ';
			// // $out .= $data[10] . ', ';
			// $out .= $data[11] . ', ';
			// $out .= $data[12] . ', ';
			// $out .= $data[13] . ', ';
			// $out .= $data[14] . ', ';
			// $out .= $data[15] . ', ';
			// $out .= $data[16] . ', ';
			// $out .= $data[17] . ', ';
			// $out .= $data[18] . ', ';
			// $out .= $data[19] . ', ';
			// // $out .= $data[20] . ', ';
			// $out .= $data[21] . ', ';
			// $out .= $data[22] . ', ';
			// $out .= $data[23] . ', ';
			// // $out .= $data[24] . ', ';
			// $out .= $data[25] . ', ';
			// $out .= $data[26] . ', ';
			// $out .= "Some field is missing at line - " . $line_no . ', ';
			// $out .= "\n";
			// $err=true;
		// }
		// else 
		// {
			// if (!filter_var(trim($data[11]), FILTER_VALIDATE_EMAIL))
			// {
				// foreach($data as $h)
				// {
					// //if(trim($h)!="")
					// $out .= trim($h) . ', ';
				// }
				// $msg="Check your email. Stopped uploading.<br> ";
				// $status = "false";
				// $out .= "Error at row - ". $line_no;
				// $out .= "\n";
				// $err=true;
				// //break;
			// }
			// else
			// {
				// $supplierid = ltrim(substr(trim($data[0]),-6),'0'); //trim($data[0]);
				// $businessname = trim($data[1]);
				// $businessownername = trim($data[2]);
				// $address1 = trim($data[3]);
				// $address2 = trim($data[4]);
				// $city = trim($data[5]);
				// $state = trim($data[6]);
				// $country = trim($data[7]);
				// $zip = trim($data[8]);
				// $phone = trim($data[9]);
				// $fax = trim($data[10]);
				// $email = trim($data[11]);
				// $cellphone = trim($data[12]);
				// $defaultnotification = trim($data[13]);
				// $DUNS = trim($data[14]);
				// $federalidnumber = trim($data[15]);
				// $hoursofoperation1 = trim($data[16]);
				// $hoursofoperation2 = trim($data[17]);
				// $daysofoperation = trim($data[18]);
				// $serviceradius	= trim($data[19]);
				// $website = trim($data[20]);
				// $businesspic = trim($data[21]);
				// $listofdocuments = trim($data[22]);
				// $suppliertype = trim($data[23]);
				// $approved = 1; //trim($data[24]);
				// $mov = trim($data[25]);
				// $otv = trim($data[26]);
				// $password=generateRandomString(); //random password
				
				// if($supplierid == ''){
					// $supplierid=0;
				// }
				// $sql = "select * from supplier where supplierid='".$supplierid."'";
				// $res = mysql_query($sql);
				// if(mysql_num_rows($res)>0){
					// // echo "HERE";die;
					// $sql = "UPDATE supplier SET businessname='$businessname', businessownername='$businessownername', address1='$address1', address2='$address2', city='$city', state='$state', country='$country', zip='$zip', phone='$phone', fax='$fax', email='$email', cellphone='$cellphone', defaultnotification='$defaultnotification', DUNS='$DUNS', federalidnumber='$federalidnumber', hoursofoperation1='$hoursofoperation1', hoursofoperation2='$hoursofoperation2', daysofoperation='$daysofoperation', serviceradius='$serviceradius', website='$website', suppliertype='$suppliertype', approved='$approved', mov='$mov', otv='$otv' WHERE supplierid='$supplierid'";
					// $result = mysql_query($sql);
					// $sql = "update suppliercustomer set supplierbusinessname='$businessname' where supplierid='$supplierid'";
					// $result = mysql_query($sql);
					// echo mysql_error();
				// }else{
				// // echo "HERE1";die;
					// $sql = "INSERT INTO supplier(businessname, businessownername, address1, address2, city, state, country, zip, phone, fax, email, cellphone, defaultnotification, DUNS, federalidnumber, hoursofoperation1, hoursofoperation2, daysofoperation, serviceradius, website, businesspic, listofdocuments, suppliertype, approved,mov,otv) VALUES ('$businessname', '$businessownername', '$address1', '$address2', '$city', '$state', '$country', '$zip', '$phone', '$fax', '$email', '$cellphone', '$defaultnotification', '$DUNS', '$federalidnumber', '$hoursofoperation1', '$hoursofoperation2', '$daysofoperation', '$serviceradius', '$website', '$businesspic', '$listofdocuments', '$suppliertype', '$approved','$mov','$otv')";
					// $result = mysql_query($sql);
					// echo mysql_error();
					
					// $sql = "INSERT INTO user(username, password, firstname, lastname, customerid, active, defaultnotification,ceid,phone)VALUES('$email', '$password', '$fname', '$lname', '$customerId', '1', '$defaultnotification','$ceid','$phone')";
					// mysql_query($sql);
					// echo mysql_error();
					
					// //Mailer function
					// $to=$email;
					// $subject="Welcome to DBA-Farmbrain";
					// $body="Username: ".$email."<br>password: ".$password;
					// $headers = 'From: dba.com' . "\r\n" .
						// 'Reply-To: info@dba.com' . "\r\n" .
						// 'X-Mailer: PHP/' . phpversion();
					// $headers.="MIME-Version: 1.0" . "\r\n";
					// $headers.="Content-type:text/html;charset=iso-8859-1" . "\r\n";
						
					// mail($to,$subject,$body,$headers);
					// //end mailer
					
					// $sql = "SELECT * FROM customer";
					// $result = mysql_query($sql);
					// while($row=mysql_fetch_array($result)){
						// $customerid = $row['customerid'];
						// $customerbusinessname = $row['businessname'];
						// $sql1 = "INSERT INTO suppliercustomer(supplierid, customerid, customerbusinessname, salesuserid, salesfirstname, saleslastname, suppliersidecustomerid, minimumordervalue, ordertolerancevalue, approve) VALUES ('$supplierid', '$customerid', '$customerbusinessname', '', '', '', '', '$mov', '$otv', 0)"; 
						// $result1 = mysql_query($sql1);
						// echo mysql_error();
					// }
				// }
			// }
		// }
		// $line_no += 1;
	// }
	// if($err)
	// {
		// echo "<script>window.open('download_errors.php?data=".urlencode($out)."&header=".urlencode($header)."','_self','height=250,width=250');document.getElementById('msg').innerText = 'Uploaded but with some errors';</script>";
	// }else{
		// echo "document.getElementById('msg').innerText = 'File Uploaded Successully';</script>";
	// }
	// echo $msg;
	// fclose($handle);
	//view upload form
// }else {

	print "Upload new csv by browsing to file and clicking on Upload";

	print "<form enctype='multipart/form-data' action='sup_reg.php' method='post'>";

	print "<label>File name to import:</label>";

	print "<input size='50' type='file' name='filename'>";
	print "<div class='close-up'> <input type='submit' name='upload_csv' value='Upload'>
	<a href='#' class='btn close-n'>Close</a>  </div>";

	print "</form>";



}

?>

<script>
$(".close-n").on("click", function(e){
						$("#upload_hover").css("display","none");
						$("#overlay").css("display","none");
						});
</script>

</div>
</div>
</body>
</html>