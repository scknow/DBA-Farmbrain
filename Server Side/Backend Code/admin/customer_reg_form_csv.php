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
	// $status = "true";
	// $msg = "";
	// while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
	// {
		
		// if ((trim($data[1])=="")||(trim($data[2])=="")||(trim($data[3])=="")||(trim($data[4])=="")||(trim($data[5])=="")||(trim($data[6])=="")||(trim($data[7])=="")||(trim($data[8])=="")||(trim($data[9])=="")||(trim($data[10])=="")||(trim($data[11])=="")||(trim($data[12])=="")||(trim($data[13])=="")||(trim($data[14])=="")||(trim($data[15])=="")||(trim($data[16])=="")||(trim($data[17])=="")||(trim($data[18])=="")||(trim($data[19])=="")||(trim($data[20])=="")||(trim($data[21])=="")||(trim($data[22])=="")||(trim($data[23])=="")||(trim($data[24])=="")||(trim($data[25])=="")||(trim($data[26])=="")||(trim($data[27])=="")||(trim($data[28])=="")||(trim($data[29])=="")||(trim($data[30])=="")||(trim($data[31])=="")||(trim($data[32])=="")||(trim($data[33])=="")||(trim($data[34])=="")||(trim($data[35])=="")||(trim($data[36])=="")||(trim($data[37])=="")||(trim($data[38])==""))
		// {
			// // $msg = "<br> ";
			// $out .= trim($data[0]) . ', ';
				// $out .= trim($data[1]) . ', ';
				// $out .= trim($data[2]) . ', ';
				// $out .= trim($data[3]) . ', ';
				// $out .= trim($data[4]) . ', ';
				// $out .= trim($data[5]) . ', ';
				// $out .= trim($data[6]) . ', ';
				// $out .= trim($data[7]) . ', ';
				// $out .= trim($data[8]) . ', ';
				// $out .= trim($data[9]) . ', ';
				// $out .= trim($data[10]) . ', ';
				// $out .= trim($data[11]) . ', ';
				// $out .= trim($data[12]) . ', ';
				// $out .= trim($data[13]) . ', ';
				// $out .= trim($data[14]) . ', ';
				// $out .= trim($data[15]) . ', ';
				// $out .= trim($data[16]) . ', ';
				// $out .= trim($data[17]) . ', ';
				// $out .= trim($data[18]) . ', ';
				// $out .= trim($data[19]) . ', ';
				// $out .= trim($data[20]) . ', ';
				// $out .= trim($data[21]) . ', ';
				// $out .= trim($data[22]) . ', ';
				// $out .= trim($data[23]) . ', ';
				// $out .= trim($data[24]) . ', ';
				// $out .= trim($data[25]) . ', ';
				// $out .= trim($data[26]) . ', ';
				// $out .= trim($data[27]) . ', ';
				// $out .= trim($data[28]) . ', ';
				// $out .= trim($data[29]) . ', ';
				// $out .= trim($data[30]) . ', ';
				// $out .= trim($data[31]) . ', ';
				// $out .= trim($data[32]) . ', ';
				// $out .= trim($data[33]) . ', ';
				// $out .= trim($data[34]) . ', ';
				// $out .= trim($data[35]) . ', ';
				// $out .= trim($data[36]) . ', ';
				// $out .= trim($data[37]) . ', ';
				// $out .= trim($data[38]) . ', ';
				// $out .= trim($data[39]) . ', ';
				// $out .= "Some field is missing. Not uploading." . ', ';
				// $out .= "\n";
		// }		
		// else
		// {
			// $cutomer_id = ltrim(substr(trim($data[0]),-6),'0'); //trim($data[0]);
			// $name = trim($data[1]);
			// $businessownername = trim($data[2]);
			// $bill_to_address1 = trim($data[3]);
			// $bill_to_address2 = trim($data[4]);
			// $billTocity = trim($data[5]);
			// $billtostate = trim($data[6]);
			// $billtocountry = trim($data[7]);
			// $billtozip = trim($data[8]);
			// $billtophone= trim($data[9]);
			// $billtofax = trim($data[10]);
			// $billtoemail = trim($data[11]);
			// $billtocellphone = trim($data[12]);
			// $shiptoaddress1 = trim($data[13]);
			// $shiptoaddress2 = trim($data[14]);
			// $shiptocity = trim($data[15]);			
			// $shiptostate = trim($data[16]);
			// $shiptocountry = trim($data[17]);
			// $shiptozip = trim($data[18]);
			// $shiptophone = trim($data[19]);
			// $shiptofax = trim($data[20]);
			// $shiptoemail = trim($data[21]);
			// $shiptocellphone = trim($data[22]);
			// $defaultnotification = trim($data[23]);
			// $DUNS = trim($data[24]);
			// $federalidnumber = trim($data[25]);
			// $hoursofoperation1 = trim($data[26]);
			// $hoursofoperation2 = trim($data[27]);
			// $daysofoperation = trim($data[28]);
			// $website = trim($data[29]);
			// $customergroupid= ltrim(substr(trim($data[30]),-6),'0'); //trim($data[30]);
			// $approved = 0; //trim($data[31]);			
			// $totalcmsn = trim($data[32]);
			// $agentcmsn = trim($data[33]);
			// $repcmsn = trim($data[34]);
			// $seccmsn = trim($data[35]);
			// $othercmsn= trim($data[36]);
			// $netcmsn = trim($data[37]);
			// $ddays = trim($data[38]);
			// $nhrs = trim($data[39]);
			
			// $count=mysql_query("select * from customergroup where customergroupid='$customergroupid'");
			
			// if(mysql_num_rows($count)!=0)
			// {
				// $row=mysql_fetch_array($count);
				// $customergroupid=$row['customergroupid'];
			// }
			// else
			// {
				// $out .= trim($data[0]) . ', ';
				// $out .= trim($data[1]) . ', ';
				// $out .= trim($data[2]) . ', ';
				// $out .= trim($data[3]) . ', ';
				// $out .= trim($data[4]) . ', ';
				// $out .= trim($data[5]) . ', ';
				// $out .= trim($data[6]) . ', ';
				// $out .= trim($data[7]) . ', ';
				// $out .= trim($data[8]) . ', ';
				// $out .= trim($data[9]) . ', ';
				// $out .= trim($data[10]) . ', ';
				// $out .= trim($data[11]) . ', ';
				// $out .= trim($data[12]) . ', ';
				// $out .= trim($data[13]) . ', ';
				// $out .= trim($data[14]) . ', ';
				// $out .= trim($data[15]) . ', ';
				// $out .= trim($data[16]) . ', ';
				// $out .= trim($data[17]) . ', ';
				// $out .= trim($data[18]) . ', ';
				// $out .= trim($data[19]) . ', ';
				// $out .= trim($data[20]) . ', ';
				// $out .= trim($data[21]) . ', ';
				// $out .= trim($data[22]) . ', ';
				// $out .= trim($data[23]) . ', ';
				// $out .= trim($data[24]) . ', ';
				// $out .= trim($data[25]) . ', ';
				// $out .= trim($data[26]) . ', ';
				// $out .= trim($data[27]) . ', ';
				// $out .= trim($data[28]) . ', ';
				// $out .= trim($data[29]) . ', ';
				// $out .= trim($data[30]) . ', ';
				// $out .= trim($data[31]) . ', ';
				// $out .= trim($data[32]) . ', ';
				// $out .= trim($data[33]) . ', ';
				// $out .= trim($data[34]) . ', ';
				// $out .= trim($data[35]) . ', ';
				// $out .= trim($data[36]) . ', ';
				// $out .= trim($data[37]) . ', ';
				// $out .= trim($data[38]) . ', ';
				// $out .= trim($data[39]) . ', ';
				// $out .= "No Customer group of this name available" . ', ';
				// $out .= "\n";
				// // die;
			// }
			
			// if($cutomer_id != ''){
				// $sql = "UPDATE customer SET businessname='$name', businessownername='$businessownername', billtoaddress1='$bill_to_address1', billtoaddress2='$bill_to_address2', billtocity='$billTocity', billtostate='$billtostate', billtocountry='$billtocountry', billtozip='$billtozip', billtophone='$billtophone', billtofax='$billtofax', billtoemail='$billtoemail', billtocellphone='$billtocellphone', shiptoaddress1='$shiptoaddress1', shiptoaddress2='$shiptoaddress2', shiptocity='$shiptocity', shiptostate='$shiptostate', shiptocountry='$shiptocountry', shiptozip='$shiptozip', shiptophone='$shiptophone', shiptofax='$shiptofax', shiptoemail='$shiptoemail', shiptocellphone='$shiptocellphone', defaultnotification='$defaultnotification', DUNS='$DUNS', federalidnumber='$federalidnumber', hoursofoperation1='$hoursofoperation1', hoursofoperation2='$hoursofoperation2', daysofoperation='$daysofoperation', website='$website', customergroupid='$customergroupid', approved='$approved',totalcmsn='$totalcmsn', agentcmsn='$agentcmsn', repcmsn='$repcmsn', seccmsn='$seccmsn', othercmsn='$othercmsn', netcmsn='$netcmsn', ddays='$ddays', nhrs='$nhrs' WHERE customerid='$cutomer_id'";
				// //echo $sql;
				// $result = mysql_query($sql);
				
				// echo mysql_error();
			// }else{
				// $sql = "INSERT INTO customer(businessname, businessownername, billtoaddress1, billtoaddress2, billTocity, billtostate, billtocountry, billtozip, billtophone, billtofax, billtoemail, billtocellphone, shiptoaddress1, shiptoaddress2, shiptocity, shiptostate, shiptocountry, shiptozip, shiptophone, shiptofax, shiptoemail, shiptocellphone, defaultnotification, DUNS, federalidnumber, hoursofoperation1, hoursofoperation2, daysofoperation, website,customergroupid, approved, totalcmsn, agentcmsn, repcmsn, seccmsn, othercmsn, netcmsn, ddays, nhrs) VALUES ('$name', '$businessownername', '$bill_to_address1', '$bill_to_address2', '$billtocity', '$billtostate', '$billtocountry', '$billtozip', '$billtophone', '$billtofax', '$billtoemail', '$billtocellphone', '$shiptoaddress1', '$shiptoaddress2', '$shiptocity', '$shiptostate', '$shiptocountry', '$shiptozip', '$shiptophone', '$shiptofax', '$shiptoemail', '$shiptocellphone', '$defaultnotification', '$DUNS', '$federalidnumber', '$hoursofoperation1', '$hoursofoperation2', '$daysofoperation', '$website','$customergroupid', '$approved','$totalcmsn', '$agentcmsn', '$repcmsn', '$seccmsn', '$othercmsn', '$netcmsn', '$ddays', '$nhrs')";
				// mysql_query($sql);
				// mysql_error();
				
				// $sql="SELECT MAX( customerid  ) FROM customer";
				// $result=mysql_query($sql);
				// $temp=mysql_fetch_array($result);
				// $max_id = $temp['MAX( customerid  )'];
			
				// $sql = "SELECT * FROM supplier";
				// $result = mysql_query($sql);
				// while($row=mysql_fetch_array($result))
				// {
					// $supplierid = $row['supplierid'];
					// $sql1 = "INSERT INTO suppliercustomer(supplierid, customerid, customerbusinessname, salesuserid, salesfirstname, saleslastname, suppliersidecustomerid, minimumordervalue, ordertolerancevalue, approve) VALUES ('$supplierid', '$max_id', '$name', '', '', '', '', '0', '0', 0)";
					// $result1 = mysql_query($sql1);
					// echo mysql_error();
				// }
			
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
	// //view upload form
// }else {

print "Upload new csv by browsing to file and clicking on Upload";

	print "<form enctype='multipart/form-data' action='customer_reg_form.php' method='post'>";

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