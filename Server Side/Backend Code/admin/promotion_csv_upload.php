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
		
		// if ((trim($data[1])=="")||(trim($data[2])=="")||(trim($data[3])=="")||(trim($data[4])=="")||(trim($data[5])=="")||(trim($data[6])=="")||(trim($data[7])=="")||(trim($data[8])=="")||(trim($data[9])==""))
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
			
			// $out .= "Some field is missing at line - " . $line_no . ', ';
			// $out .= "\n";
		// }	
		// else if((strtotime($data[4]) < $now)||(strtotime($data[5])<(strtotime($data[4]))))	
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
			// $out .=', ';
			// $out .= "Date from can't be less than or equal to today's date or  Date to can't be less than date from". ', ';
			// $out .= "\n";
		// }
		// else
		// {
			// $promotion_id = ltrim(substr(trim($data[0]),-6),'0'); //trim($data[0]);
			// $productid = ltrim(substr(trim($data[1]),-6),'0'); //trim($data[1]);
			// $supplierid = ltrim(substr(trim($data[2]),-6),'0'); //trim($data[2]);
			// $type = trim($data[3]);
			// $datefrom = trim($data[4]);
			// $dateto = trim($data[5]);
			// $minordervalue = trim($data[6]);
			// $percentageoff = trim($data[7]);
			// $valueoff = trim($data[8]);
			// $promotionText = trim($data[9]);
			
			// if($dateto=='')
			// {
				// $dateto='9999-01-01';
			// }
			// if($promotion_id == ''){
				// $sql = "INSERT INTO promotion(productid, supplierid, type, datefrom, dateto, minimumorderquantity, percentageoff, valueoff, promotiontext) VALUES ( '$productid', '$supplierid', '$type', '$datefrom', '$dateto', '$minordervalue', '$percentageoff', '$valueoff', '$promotiontext')"; 			
				// mysql_query($sql);
				
					// $sql = "SELECT * FROM promotion WHERE supplierid='$supplier_id' AND productid='$productid' AND datefrom<'$datefrom' AND dateto>'$datefrom'";
					// $result = mysql_query($sql);
					// while($row=mysql_fetch_array($result)){
						// $sql1 = "UPDATE promotion SET dateto='$datefrom' WHERE promotionid=".$row['promotionid'];
						// mysql_query($sql1);
					// }
			// }else{
				// $sql = "update promotion set productid=$productid, supplierid=$supplierid, type=$type, datefrom=$datefrom, dateto=$dateto, minimumorderquantity=$minimumorderquantity, percentageoff=$percentageoff, valueoff=$valueoff, promotiontext=$promotionText where promotionid=$promotion_id"; //  VALUES ( '$productid', '$supplierid', '$type', '$datefrom', '$dateto', '$minordervalue', '$percentageoff', '$valueoff', '$promotiontext')"; 			
				// mysql_query($sql);
			// }
		// }
	// }
	// if($out!=""){
		// echo "<script>window.open('download_errors.php?data=".urlencode($out)."&header=".urlencode($header)."','_self','height=250,width=250');document.getElementById('msg').innerText = 'Uploaded but with some errors';</script>";
	// }
	// echo $msg;
	// fclose($handle);
	//view upload form
// }else {
print "Upload new csv by browsing to file and clicking on Upload";

	print "<form enctype='multipart/form-data' action='promotion.php' method='post'>";

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