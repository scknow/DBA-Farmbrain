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
	// $line_no=2;
	// $err = false;
	// while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
	// {
		
		// if ((trim($data[1])=="")||(trim($data[2])=="")||(trim($data[3])=="")||(trim($data[4])=="")||(trim($data[5])==""))//||(trim($data[6])==""))
		// {
			// $msg = "Some field is missing. Not uploading.<br> ";
			// $out .= $data[0] . ', ';
			// $out .= $data[1] . ', ';
			// $out .= $data[2] . ', ';
			// $out .= $data[3] . ', ';
			// $out .= $data[4] . ', ';
			// $out .= $data[5] . ', ';
			// $out .= $data[6] . ', ';
			// $out .= "Some field is missing at line - " . $line_no . ', ';
			// $out .= "\n";
			// $err = true;
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
				// $out .= "Error at row - ". $line_no;
				// $out .= "\n";
				// $err=true;
				// //break;
			// }else{
				// $userid = ltrim(substr(trim($data[0]),-6),'0'); //trim($data[0]);
				// $username = trim($data[1]);
				// // $password = trim($data[2]);
				// $password=generateRandomString();
				// $firstname = trim($data[2]);
				// $lastname = trim($data[3]);
				// $supplierid = trim($data[4]);
				// $active = 1; //trim($data[6]);
				// $defaultnotification = trim($data[5]);
				// $seid = trim($data[6]);
				// if($userid==''){
					// $userid=0;
				// }				
				// $sql = "select * from salesuser where userid=$userid";
				// $result = mysql_query($sql);
				// if(mysql_num_rows($result)>0){
					// $sql = "update salesuser set username=$username, firstname=$firstname, lastname=$lastname, supplierid=$supplierid, active=$active, defaultnotification=$defaultnotification, seid=$seid where userid=$userid";
					// $result = mysql_query($sql);
				// }else{
					// $sql = "INSERT INTO salesuser(username, password, firstname, lastname, supplierid, active, defaultnotification,seid) VALUES ('$username', '$password', '$firstname', '$lastname', '$supplierid', '$active', '$defaultnotification', '$seid')"; 
					// $result = mysql_query($sql);
					// echo mysql_error();		
					// $to=$username;
					// $subject="DBA sales user password";
					// $body="Username: ".$username."<br>password: ".$password;
					// $headers = 'From: dba.com' . "\r\n" .
						// 'Reply-To: info@dba.com' . "\r\n" .
						// 'X-Mailer: PHP/' . phpversion();
					// $headers.="MIME-Version: 1.0" . "\r\n";
					// $headers.="Content-type:text/html;charset=iso-8859-1" . "\r\n";
						
					// mail($to,$subject,$body,$headers);			
				// }
			// }
		// }
		// $line_no += 1;
	// }
	
	// if($err)
	// {
		// // echo "<script></script>";
		// echo "<script>window.open('download_errors.php?data=".urlencode($out)."&header=".urlencode($header)."','_self','height=250,width=250');document.getElementById('msg').innerText = 'Uploaded but with some errors';</script>";
	// }else{
		// echo "document.getElementById('msg').innerText = 'File Uploaded Successully';</script>";
	// }
	// echo $msg;
	// fclose($handle);
	//view upload form
// }else {

print "Upload new csv by browsing to file and clicking on Upload";

	print "<form enctype='multipart/form-data' action='create_sales_user.php' method='post'>";

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