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
	// while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
	// {
		
		// if ((trim($data[1])=="")||(trim($data[2])=="")||(trim($data[3])=="")||(trim($data[4])=="")||(trim($data[5])=="")||(trim($data[6])=="")||(trim($data[7])==""))
		// {
			// $msg .= "Some field is missing. Not uploading.<br> ";
			// $out .= $data[0] . ', ';
			// $out .= $data[1] . ', ';
			// $out .= $data[2] . ', ';
			// $out .= $data[3] . ', ';
			// $out .= $data[4] . ', ';
			// $out .= $data[5] . ', ';
			// $out .= $data[6] . ', ';
			// $out .= $data[7] . ', ';
			// $out .= "Some field is missing at line - " . $line_no . ', ';
			// $out .= "\n";
		// }		
		// else
		// {
			// $cutomer_id = ltrim(substr(trim($data[0]),-6),'0'); //trim($data[0]);
			// $supplierid = ltrim(substr(trim($data[1]),-6),'0'); //trim($data[1]);
			// $business_name = trim($data[2]);
			// $customer_id = ltrim(substr(trim($data[3]),-6),'0'); //trim($data[3]);
			// $customerbusiness_name = trim($data[4]);
			// $suppliersidecustomerid = trim($data[5]);
			// $minordervalue = trim($data[6]);
			// $ordertolerancevalue = trim($data[7]);
			
			// if($cutomer_id == ''){
				// $sql = "INSERT INTO suppliercustomer(supplierid, customerid, customerbusinessname,suppliersidecustomerid, minimumordervalue, ordertolerancevalue,approve) VALUES ('$supplierid', '$customer_id', '$business_name','$suppliersidecustomerid', '$minordervalue', '$ordertolerancevalue','0')";
			// }else{
				// $sql = "UPDATE suppliercustomer SET supplierid='$supplierid', customerid='$customerid', customerbusinessname='$customerbusinessname', suppliersidecustomerid='$suppliersidecustomerid', minimumordervalue='$minimumordervalue', ordertolerancevalue='$ordertolerancevalue', approve='0' WHERE rid='$cutomer_id' "; 
			// }
			// $result = mysql_query($sql);
			// echo mysql_error();							
		// }
	// }
	
	// if($out!="")
	// {
		// // echo "<script></script>";
		// echo "<script>window.open('download_errors.php?data=".urlencode($out)."&header=".urlencode($header)."','_self','height=250,width=250');document.getElementById('msg').innerText = 'Uploaded but with some errors';</script>";
	// }
	// echo $msg;
	// fclose($handle);
	// //view upload form
// }else {

	print "Upload new csv by browsing to file and clicking on Upload";

	print "<form enctype='multipart/form-data' action='relation.php' method='post'>";

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