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
		// /* echo "<h2>Displaying contents:</h2>";
		// readfile($_FILES['filename']['tmp_name']); */
	// }

	// $emailval = '/([\w\-]+\@[\w\-]+\.[\w\-]+)/';
	// $mob='/^\d+$/';
	
	// //Import uploaded file to Database
	// $handle = fopen($_FILES['filename']['tmp_name'], "r");
	// $hdata = fgetcsv($handle, 1000, ",");
	// $header ="";
	// foreach($hdata as $h)
	// {
		// if(trim($h)!="")
			// $header .= trim($h) . ', ';
	// }
	// $header .= 'Error Description';
	
	// $status = "false";
	// $msg = "";
	// $line_no = 2;
	// $out="";
	
	// while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
	// {
		// //$phone = $data[2];
		// // echo trim($data[0])." ".trim($data[1]);
		// if ( (trim($data[1])=="") || (trim($data[2])=="") )
		// {
			// $msg .= "Some field is missing. Not uploading.<br> ";
			// $out .= $data[0] . ', ';
			// $out .= $data[1] . ', ';
			// $out .= $data[2] . ', ';
			// $out .= "Some field is missing at line - " . $line_no . ', ';
			// $out .= "\n";
		// }
		// else
		// {
			// // $mname = ltrim(substr(trim($data[0]),-7),'0');
			// $brandid =  ltrim(substr(trim($data[0]),-6),'0');
			// $mname =trim($data[1]);
			// // echo $mname;
			// $sql = "SELECT manufid FROM manufacturer WHERE trim(manufname) = '$mname' LIMIT 1";
			// $result = mysql_query($sql);
			// if(mysql_num_rows($result)!=0)
			// {
				// $row = mysql_fetch_array($result);
				// $manufacturerid = $row['manufid'];
				// $sql = "SELECT * FROM brand WHERE brandid=$brandid";//manufid = '$manufacturerid' AND trim(brandname) = '$data[2]' LIMIT 1";
				// $result = mysql_query($sql);
				// // echo $sql;
				// if(mysql_num_rows($result)==0)
				// {
					// $import = "INSERT into brand(manufid, brandname) values('$manufacturerid','$data[2]')";
				
					// mysql_query($import) or die(mysql_error());
					// $msg="Upload successfully";
				// }
				// else
				// {
					
					// $import = "UPDATE brand SET brandname='$data[2]' WHERE brandid='$brandid' ";
					// // echo $import;
					// mysql_query($import);
					// // $out .= $data[0] . ', ';
					// // $out .= $data[1] . ', ';
					// // $out .= "Duplicate manufacture at line - " . $line_no . ', ';
					// // $out .= "\n";
				// }
			// }
			// else
			// {
				// $out .= $data[0] . ', ';
				// $out .= $data[1] . ', ';
				// $out .= $data[2] . ', ';
				// $out .= "No such manufacture at line - " . $line_no . ', ';
				// $out .= "\n";
			// }
		// }
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
	// if($out!=""){
		// // echo "<script></script>";
		// echo "<script>window.open('download_errors.php?data=".urlencode($out)."&header=".urlencode($header)."','_self','height=250,width=250');document.getElementById('msg').innerText = 'Uploaded but with some errors';</script>";
	// }
	// echo $msg;
	// fclose($handle);

	//print "Import done";

	//view upload form
// }
// else
// {

	print "Upload new csv by browsing to file and clicking on Upload";

	print "<form enctype='multipart/form-data' action='brand.php' method='post'>";

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