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
	// $now =time();
	// while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
	// {
		
		// if ((trim($data[1])=="")||(trim($data[2])=="")||(trim($data[3])=="")||(trim($data[4])=="")||(trim($data[5])=="")||(trim($data[6])=="")||(trim($data[7])=="")||(trim($data[8])=="")||(trim($data[10])=="")||(trim($data[11])==""))
		// {
			// $out .= $data[0] . ', ';
			// $out .= $data[1] . ', ';
			// $out .= $data[2] . ', ';
			// $out .= $data[3] . ', ';
			// $out .= $data[4] . ', ';
			// $out .= $data[5] . ', ';
			// $out .= $data[6] . ', ';
			// $out .= $data[7] . ', ';
			// $out .= $data[8] . ', ';
			// $out .= $data[9] . ', ';
			// $out .= $data[10] . ', ';
			// $out .= $data[11] . ', ';
			// $out .= $data[12] . ', ';
			// $out .= "Some field is missing at line - " . $line_no . ', ';
			// $out .= "\n";
		// }	
		// else if((strtotime($data[8]) < $now)||(strtotime($data[9]) < strtotime($data[8])))
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
			// $out .= $data[8] . ', ';
			// $out .= $data[9] . ', ';
			// $out .= $data[10] . ', ';
			// $out .= $data[11] . ', ';
			// $out .= $data[12] . ', ';
			// $out .=', ';
			// $out .= "Date from can't be less than or equal to today's date". ', ';
			// $out .= "\n";
		// }
		// else
		// {
			// $price_id = ltrim(substr(trim($data[0]),-6),'0'); //trim($data[0]);
			// $productid = ltrim(substr(trim($data[1]),-6),'0'); //trim($data[1]);
			// $upc = trim($data[2]);
			// $supplier_id = ltrim(substr(trim($data[3]),-6),'0'); //trim($data[3]);
			// $productname = trim($data[4]);
			// $customergroup = trim($data[5]);
			// $customerid = ltrim(substr(trim($data[6]),-6),'0'); //trim($data[6]);
			// $minodrqty = trim($data[7]);
			// $datefrom = trim($data[8]);
			// $dateto= trim($data[9]);
			// $incrementodrqty = trim($data[10]);
			// $price = trim($data[11]);
			
			// if($dateto=='')
			// {
				// $dateto='9999-01-01';
			// }
			// if($price_id == ''){
				// $sql = "INSERT INTO pricing(productid, upc, supplierid, productname, customergroup, customerid, minodrqty, datefrom, dateto, incrementodrqty, price, active) VALUES ('$productid', '$upc', '$supplier_id', '$productname', '$customergroup', '$customerid', '$minodrqty', '$datefrom', '$dateto', '$incrementodrqty', '$price', '0')";
				// mysql_query($sql);
				
				// $sql = "SELECT * FROM pricing WHERE supplierid='$supplier_id' AND customergroup='$customergroup' AND productid='$productid' AND datefrom<'$datefrom' AND dateto>'$datefrom'";
					// $result = mysql_query($sql);
					// while($row=mysql_fetch_array($result)){
						// $sql1 = "UPDATE pricing SET dateto='$datefrom' WHERE id=".$row['id'];
						// mysql_query($sql1);
					// }
			// }else{
				// $sql = "update pricing set productid=$productid,upc=$upc, supplierid=$supplier_id, productname=$productname, customergroup=$customergroup, customerid=$customerid, minodrqty=$minodrqty, datefrom=$datefrom, dateto=$dateto, incrementodrqty=$incrementodrqty, price=$price, active='0' where id=$price_id";
				// mysql_query($sql);
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

	print "<form enctype='multipart/form-data' action='pricing.php' method='post'>";

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