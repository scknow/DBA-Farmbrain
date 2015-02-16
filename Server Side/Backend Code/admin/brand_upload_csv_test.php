<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Upload page</title>
<style type="text/css">
body {
	background: #E3F4FC;
	font: normal 14px/30px Helvetica, Arial, sans-serif;
	color: #2b2b2b;
}
a {
	color:#898989;
	font-size:14px;
	font-weight:bold;
	text-decoration:none;
}
a:hover {
	color:#CC0033;
}

h1 {
	font: bold 14px Helvetica, Arial, sans-serif;
	color: #CC0033;
}
h2 {
	font: bold 14px Helvetica, Arial, sans-serif;
	color: #898989;
}
#container {
	background: #CCC;
	margin: 100px auto;
	width: 945px;
}
#form 			{padding: 20px 150px;}
#form input     {margin-bottom: 20px;}
</style>
</head>
<body>
<div id="container">
<div id="form">

<?php
//Create connection
include "connection.php";

//Upload File
if (isset($_POST['submit'])) {
	if (is_uploaded_file($_FILES['filename']['tmp_name'])) {
		echo "<h1>" . "File ". $_FILES['filename']['name'] ." uploaded successfully." . "</h1>";
		/* echo "<h2>Displaying contents:</h2>";
		readfile($_FILES['filename']['tmp_name']); */
	}

	$emailval = '/([\w\-]+\@[\w\-]+\.[\w\-]+)/';
	$mob='/^\d+$/';
	
	//Import uploaded file to Database
	$handle = fopen($_FILES['filename']['tmp_name'], "r");
	fgetcsv($handle, 1000, ",");
	$status = "true";
	$msg = "";
	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
	{
		//$phone = $data[2];
		// echo trim($data[0])." ".trim($data[1]);
		if ( (trim($data[0])=="") || (trim($data[1])=="") )
		{
			$msg .= "Some field is missing. Not uploading.<br> ";
		}
		else
		{
			$mname = trim($data[0]);
			$sql = "SELECT manufid FROM manufacturer WHERE manufname = '$mname' LIMIT 1";
			$result = mysql_query($sql);
			if(mysql_num_rows($result)!=0)
			{
				$row = mysql_fetch_array($result);
				$manufacturerid = $row['manufid'];
				$import = "INSERT into brand(manufid, brandname) values('$manufacturerid','$data[1]')";
				
				mysql_query($import) or die(mysql_error());
				$msg.="Upload successfully";
			}
		}
	}
	/* if($status == "true")
	{
		$handle = fopen($_FILES['filename']['tmp_name'], "r");
		fgetcsv($handle, 1000, ",");
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
		{
			$import="INSERT into manufacturer(manufname, address1, address2, city, state, country, zip, phone, fax, email, cellphone, website) values('$data[0]','$data[1]','$data[2]','$data[3]','$data[4]','$data[5]','$data[6]','$data[7]','$data[8]','$data[9]','$data[10]','$data[11]')";
			
			mysql_query($import) or die(mysql_error());
			$msg="Upload successfully";
		}
	} */
	echo $msg;
	fclose($handle);

	//print "Import done";

	//view upload form
}/* else {

	print "Upload new csv by browsing to file and clicking on Upload<br />\n";

	print "<form enctype='multipart/form-data' action='brand_upload_csv.php' method='post'>";

	print "File name to import:<br />\n";

	print "<input size='50' type='file' name='filename'><br />\n";

	print "<input type='submit' name='submit' value='Upload'></form>";

} */

?>

</div>
</div>
</body>
</html>