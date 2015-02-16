
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
	// /* if (is_uploaded_file($_FILES['filename']['tmp_name'])) {
		// echo "<h1>" . "File ". $_FILES['filename']['name'] ." uploaded successfully." . "</h1>";
	// } */

	// $emailval = '/([\w\-]+\@[\w\-]+\.[\w\-]+)/';
	// $mob='/^\d+$/';
	
	// //Import uploaded file to Database
	// $handle = fopen($_FILES['filename']['tmp_name'], "r");
	// $hdata = fgetcsv($handle, 1000, ",");
	// $header ="";
	// foreach($hdata as $h)
	// {
		// //if(trim($h)!="")
		// $header .= trim($h) . ', ';
	// }
	// $header .= 'Error Description';
	// $status = "true";
	// $msg = "";
	// $line_no=2;
	// while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
	// {	
		
		// if((trim($data[1])=="")||($data[2]=="")||($data[3]=="")||($data[4]==""))
		// {
			// foreach($data as $h)
			// {
				// //if(trim($h)!="")
					// $out .= trim($h) . ', ';
			// }
			// $msg = "Some important field is missing. Not uploading.<br> ";
			// $status = "false";
			// $out .= "Error at row - ". $line_no;
			// $out .= "\n";
		// }
		// else if (!ctype_digit(trim($data[5])) OR strlen(trim($data[5])) != 10)
		// {
			// foreach($data as $h)
			// {
				// //if(trim($h)!="")
					// $out .= trim($h) . ', ';
			// }
			// $msg.="Check your Mobile number. Not uploading.<br> ";
			// $status = "false";
			// $out .= "Error at row - ". $line_no;
			// $out .= "\n";
			// //break;
		// }
		// else
		// {
			// if (!filter_var(trim($data[1]), FILTER_VALIDATE_EMAIL))
			// {
				// foreach($data as $h)
				// {
					// //if(trim($h)!="")
						// $out .= trim($h) . ', ';
				// }
				// $msg="Check your email. Stopped uploading.<br> ";
				// $status = "false";
				// $out .= "Check your email. Error at row - ". $line_no;
				// $out .= "\n";
				// //break;
			// }
			// else
			// {
				// $user_id = ltrim(substr(trim($data[0]),-6),'0'); //trim($data[0]);
				// $username = trim($data[1]);
				// $fname = trim($data[2]);
				// $lname = trim($data[3]);
				// $customerId = trim($data[4]);
				// $phone = trim($data[5]);
				// $notifyId = trim($data[6]);
				// $defaultnotification = trim($data[7]);
				// $ceid = trim($data[8]);
				// $password=generateRandomString();
				
				// if(trim($data[0])=='')
				// {			
					// $sql = "INSERT INTO user(username, password, firstname, lastname, customerid, active, defaultnotification,ceid,phone)VALUES('$username', '$password', '$fname', '$lname', '$customerId', '1', '$defaultnotification','$ceid','$phone')";
				
					// mysql_query($sql);
					// echo mysql_error();
					
					// $to=$username;
					// $subject="Welcome to DBA-Farmbrain";
					// $body="Username: ".$username."<br>password: ".$password;
					// $headers = 'From: dba.com' . "\r\n" .
						// 'Reply-To: info@dba.com' . "\r\n" .
						// 'X-Mailer: PHP/' . phpversion();
					// $headers.="MIME-Version: 1.0" . "\r\n";
					// $headers.="Content-type:text/html;charset=iso-8859-1" . "\r\n";
						
					// mail($to,$subject,$body,$headers);
				// }
				// else
				// {
					// $sql = "UPDATE user SET username='$username', password='$password', firstname='$firstname', lastname='$lastname', customerid='$customerid', active='$active', defaultnotification='$defaultnotification' WHERE userid='$id' ";
					// mysql_query($sql);
				// }
				// $msg="Upload successfully";
			// }
		// }
		// $line_no++;
	// }
	// if($out!="")
	// {
		// // echo "<script></script>";
		// echo "<script>window.open('download_errors.php?data=".urlencode($out)."&header=".urlencode($header)."','_self','height=250,width=250');alert('Uploaded but with some errors');</script>";
	// }else{
			// echo "<script>alert('Uploaded Successfully');</script>";
	// }
	// echo $msg;
	// fclose($handle);
	// //view upload form
// }else {

print "Upload new csv by browsing to file and clicking on Upload";

	print "<form enctype='multipart/form-data' action='craete_user.php' method='post'>";

	print "<label>File name to import:</label>";

	print "<input size='50' type='file' name='filename'>";
	print "<div class='close-up'> <input type='submit' name='upload_csv' value='Upload'>
	<a href='#' class='btn close-n'>Close</a>  </div>";

	print "</form>";



}



function generateRandomString($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
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