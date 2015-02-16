<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Upload page</title>
<style>

</style>
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
	
	// // Import uploaded file to Database
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
	// $now =time();
	// while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
	// {
		
		// if ((trim($data[1])=="")||(trim($data[2])=="")||(trim($data[3])=="")||(trim($data[4])=="")||(trim($data[5])=="")||(trim($data[6])=="")||(trim($data[7])==""))
		// {
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
		// else if((strtotime($data[2]) < $now)||(strtotime($data[3]) < strtotime($data[2])))
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
			// $out .= "Event start Date can't be less than or equal to today's date OR end date can't be less than start date". ', ';
			// $out .= "\n";
		// }
		// else
		// {
			// $evenId = ltrim(substr(trim($data[0]),-6),'0'); //trim($data[0]);
			// $eventname = trim($data[1]);
			// $startdate = trim($data[2]);
			// $enddate = trim($data[3]);
			// $customergiveaway = trim($data[4]);
			// $supplierchargeable = trim($data[5]);
			// $maxquantity = trim($data[6]);
			// if($dateto=='')
			// {
				// $dateto='9999-01-01';
			// }
			// $product_id = trim($data[7]);
			// if($data[0]=='')
			// {
				// $sql = "INSERT INTO promotionalevent(eventname, startdate, enddate, customergiveaway, supplierchargeable, maxquantity) VALUES ('$eventname', '$startdate', '$enddate', '$customergiveaway', '$supplierchargeable', '$maxquantity')";	
				// mysql_query($sql);
				
					// $sql="SELECT MAX( eventid ) FROM promotionalevent";
					// $result=mysql_query($sql);
					// $temp=mysql_fetch_array($result);
					// $max_id = $temp['MAX( eventid )'];
					
				// $productid=explode("&",$product_id);
				// for($i=0;$i<sizeof($productid);$i++)
				// {
					// $sql = "INSERT INTO 	promotionaleventdetail(eventid,productid)VALUES('$max_id','$productid[$i]')";
					// $result=mysql_query($sql);
				// }
			// }
			// else
			// {
				// $sql = "UPDATE promotionalevent set eventname='$eventname', startdate='$startdate', enddate='$enddate', customergiveaway='$customergiveaway', supplierchargeable='$supplierchargeable', maxquantity='$maxquantity' where eventid='$evenId'";
				
				// mysql_query($sql);
				
				// mysql_query("delete from promotionaleventdetail where eventid='$eventId'");
				
				// $productid=explode("&",$product_id);
				// for($i=0;$i<sizeof($productid);$i++)
				// {
					// $sql = "INSERT INTO 	promotionaleventdetail(eventid,productid)VALUES('$eventId','$productid[$i]')";
					// $result=mysql_query($sql);
				// }

			// }
		// }
	// }
	// if($out!=""){
		// // echo "<script></script>";
		// echo "<script>window.open('download_errors.php?data=".urlencode($out)."&header=".urlencode($header)."','_self','height=250,width=250');document.getElementById('msg').innerText = 'Uploaded but with some errors';</script>";
	// }
	// echo $msg;
	// fclose($handle);
	//view upload form
// }else {




print "Upload new csv by browsing to file and clicking on Upload";

	print "<form enctype='multipart/form-data' action='promotional_event.php' method='post'>";

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