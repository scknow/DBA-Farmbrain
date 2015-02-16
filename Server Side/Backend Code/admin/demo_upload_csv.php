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
		// echo "<h1>" . "File ". $_FILES['filename']['name'] ." uploaded successfully." . "</h1>";
		// echo "<h2>Displaying contents:</h2>";
		// readfile($_FILES['filename']['tmp_name']);
	// }

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
	// $line_no = 2;
	// $out="";
	// while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
	// {
		// if ( (trim($data[1])=="")|| (trim($data[2])=="") || (trim($data[3])=="")|| (trim($data[4])=="")|| (trim($data[5])=="")|| (trim($data[6])=="")|| (trim($data[7])=="")|| (trim($data[12])=="") )
		// {
			// foreach($data as $h)
			// {
				// //if(trim($h)!="")
					// $out .= trim($h) . ', ';
			// }
			// $msg .= "Some important field is missing. Not uploading.<br> ";
			// $status = "false";
			// $out .= "Error at row - ". $line_no;
			// $out .= "\n";
		// }
		// else if (!ctype_digit(trim($data[8])) OR strlen(trim($data[8])) != 10)
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
			// if (!filter_var(trim($data[10]), FILTER_VALIDATE_EMAIL))
			// {
				// foreach($data as $h)
				// {
					// //if(trim($h)!="")
						// $out .= trim($h) . ', ';
				// }
				// $msg.="Check your email. Stopped uploading.<br> ";
				// $status = "false";
				// $out .= "Error at row - ". $line_no;
				// $out .= "\n";
				// //break;
			// }
			// else
			// {
				// if($data[0] != ''){
					// $manufid = ltrim(substr(trim($data[0]),-6),'0');
				// }else{
					// $manufid=0;
				// }
				// // echo $manufid;
				// $sql = "select * from manufacturer where manufid=$manufid";
				// $res = mysql_query($sql);
				// $manufname=$data[1];
				// $address1=$data[2];
				// $address2=$data[3];
				// $city=$data[4];
				// $state=$data[5];
				// $country=$data[6];
				// $zip=$data[7];
				// $phone=$data[8];
				// $fax=$data[9];
				// $email=$data[10];
				// $cellphone=$data[11];
				// $website=$data[12];
				// if(mysql_num_rows($res)>0){
				// // echo $manufname;
					// $import="UPDATE manufacturer SET manufname='$manufname', address1='$address1', address2='$address2', city='$city', state='$state', country='$country', zip='$zip', phone='$phone', fax='$fax', email='$email', cellphone='$cellphone', website='$website' WHERE manufid='$manufid' ";
					// mysql_query($import) or die(mysql_error());
				// }else{
					// $import = "INSERT into manufacturer(manufname, address1, address2, city, state, country, zip, phone, fax, email, cellphone, website) values('$data[1]','$data[2]','$data[3]','$data[4]','$data[5]','$data[6]','$data[7]','$data[8]','$data[9]','$data[10]','$data[11]','$data[12]')";
					// mysql_query($import) or die(mysql_error());
				// }
				// $msg="Upload successfully";
			// }
		// }
		// $line_no++;
	// }
	// /* if($status == "true")
	// {
		// $handle = fopen($_FILES['filename']['tmp_name'], "r");
		// fgetcsv($handle, 1000, ",");
		// while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
		// {
			// $import="INSERT into manufacturer(manufname, address1, address2, city, state, country, zip, phone, fax, email, cellphone, website) values('$data[0]','$data[1]','$data[2]','$data[3]','$data[4]','$data[5]','$data[6]','$data[7]','$data[8]','$data[9]','$data[10]','$data[11]')";
			
			// mysql_query($import) or die(mysql_error());
			// $msg="Upload successfully";
		// }
	// } */
	// if($out!="")
	// {
		// // echo "<script></script>";
		// echo "<script>window.open('download_errors.php?data=".urlencode($out)."&header=".urlencode($header)."','_self','height=250,width=250');document.getElementById('msg').innerText = 'Uploaded but with some errors';</script>";
	// }
	// echo $msg;
	// fclose($handle);

	// //print "Import done";

	// //view upload form
// }else {

	print "Upload new csv by browsing to file and clicking on Upload";

	print "<form enctype='multipart/form-data' action='manufact.php' method='post'>";

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