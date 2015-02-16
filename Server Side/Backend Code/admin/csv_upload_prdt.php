<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Upload page</title>

<script>
$(".close-n").on("click", function(e){
						$("#upload_hover").css("display","none");
						$("#overlay").css("display","none");
						});
</script>
</head>
<body>
<div id="container">
<div id="form">
<span id="msg"><span>
<?php
//Create connection
include "connection.php";

//Upload File
if (!isset($_POST['upload_csv']))
{
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
		// //if(trim($h)!="")
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
		// //echo trim($data[0])." ".trim($data[1]);
		// if ( (trim($data[2])=="")||(trim($data[3])=="")||(trim($data[4])=="")||(trim($data[5])=="")||(trim($data[6])=="")||(trim($data[7])=="")||(trim($data[8])=="")||(trim($data[9])=="")||(trim($data[10])=="")||(trim($data[11])=="")||(trim($data[12])=="")||(trim($data[13])=="")||(trim($data[14])=="")||(trim($data[15])==""))
		// {
			// $msg .= "Some field is missing. Not uploading.<br> ";
			// $status = "true";
			// //$out .= $data[0] . ', ';
			// //$out .= "Some field is missing ,";
			// //$out .= "\n";
		// }		
		// else
		// {
			// $productid = ltrim(substr(trim($data[0]),-6),'0'); //trim($data[0]);
			// $productname = trim($data[1]);
			// $productdesc = trim($data[2]);
			// $product_catName = trim($data[3]);
			// $product_subCat_name = trim($data[4]);
			// $product_manufatcur_name = trim($data[5]);
			// $brand_name = trim($data[6]);
			// $unitofmeasure = trim($data[7]);
			// $packquantity = trim($data[8]);
			// $skuupc = trim($data[9]);
			// $casequantity = trim($data[10]);
			// $caseweight= trim($data[11]);
			// $casegtin = trim($data[12]);
			// $palletquantity = trim($data[13]);
			// $shelflife= trim($data[14]);
			// $suggestedretailshelflife = trim($data[15]);
			
			// $count=mysql_query("select * from productcategory where productcategoryname='$product_catName'");
			// if(mysql_num_rows($count)!=0)
			// {
				// $row=mysql_fetch_array($count);
				// $productcategoryid=$row['productcategoryid'];
				// $status = "true";
			// }
			// else
			// {
				// // echo "No such category available";
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
				// $out .= $data[13] . ', ';
				// $out .= $data[14] . ', ';
				// $out .= $data[15] . ', ';
				// $out .= "No such category available,";
				// $out .= "\n";
				// $status = "false";
			// }
			
			// $count = mysql_query("select * from productsubcategory where productcategoryid='$productcategoryid' and productsubcategoryname	='$product_subCat_name'");
			
			// if(mysql_num_rows($count)!=0)
			// {
				// $row=mysql_fetch_array($count);
				// $productsubcategoryid=$row['productsubcategoryid'];
				// $status = "true";
			// }
			// else
			// {
				// // echo "No subCategory available for this category";
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
				// $out .= $data[13] . ', ';
				// $out .= $data[14] . ', ';
				// $out .= $data[15] . ', ';
				// $out .= "No subCategory available for this category";
				// $out .= "\n";
				// $status = "false";
				// // $status = "false";
			// }
			
			// $count=mysql_query("select * from manufacturer where manufname='$product_manufatcur_name'");
			// if(mysql_num_rows($count)!=0)
			// {
				// $row=mysql_fetch_array($count);
				// $productmanufacturer=$row['manufid'];
				// $status = "true";
			// }
			// else
			// {
				// foreach($data as $h)
				// {
					// //if(trim($h)!="")
						// $out .= trim($h) . ', ';
				// }
				// $out .= "No such manufacture added" . ', ';
				// //$out .= $data[5] . ', ';
				// //$out .= "No such manufacture added ,";
				// $out .= "\n";
				// $status = "false";
			// }
			
			// $count=mysql_query("select * from brand where brandname='$brand_name' and manufid ='$productmanufacturer'");
			
			
			
			// if(mysql_num_rows($count)!=0)
			// {
				// $row=mysql_fetch_array($count);
				// $brand_id=$row['brandid'];
				// $status = "true";
			// }
			// else
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
				// $out .= $data[13] . ', ';
				// $out .= $data[14] . ', ';
				// $out .= $data[15] . ', ';
				// $out .= "No such brand regarding this  manufacture";
				// $out .= "\n";
				// $status = "false";
				// // echo "No such brand regarding this  manufacture";
				// //$out .= $data[6] . ', ';
				// //$out .= "No such brand available ,";
				// //$out .= "\n";
				// // $status = "false";
			// }
			
			// if($status == "true")
			// {
				// if($productid == ''){
					// $sql = "INSERT INTO productportfolio( productlabel, productdescription, productcategoryid, productsubcategoryid, brand, unitofmeasure, packquantity, skuupc, casequantity, caseweight, casegtin, palletquantity,shelflife, suggestedretailshelflife, productmanufacturer) VALUES ('$productname', '$productdesc', '$productcategoryid', '$productsubcategoryid', '$brand_id', '$unitofmeasure', '$packquantity', '$skuupc', '$casequantity', '$caseweight', '$casegtin', '$palletquantity', '$shelflife', '$suggestedretailshelflife','$productmanufacturer')";
				// }else{
					// $sql = "UPDATE productportfolio SET productlabel='$productname', productdescription='$productdesc', productcategoryid='$productcategoryid', productsubcategoryid='$productsubcategoryid', brand='$brand_id', unitofmeasure='$unitofmeasure', packquantity='$packquantity', skuupc='$skuupc', casequantity='$casequantity', caseweight='$caseweight', casegtin='$casegtin', palletquantity='$palletquantity',  shelflife='$shelflife', suggestedretailshelflife='$suggestedretailshelflife', productmanufacturer='$productmanufacturer' WHERE productid='$productid' ";
				// }
				// mysql_query($sql);
			// }
			// else
			// {
				// $out .= "Error at row - ". $line_no;
				// $out .= "\n";
			// }
		// }
		// $line_no++;
	// }
	// if($out!="")
	// {
		// // echo "<script></script>";
		// echo "<script>window.open('download_errors.php?data=".urlencode($out)."&header=".urlencode($header)."','_self','height=250,width=250');document.getElementById('msg').innerText = 'Uploaded but with some errors';</script>";
	// }else{
		// echo "document.getElementById('msg').innerText = 'Uploaded but with some errors';</script>";
	// }
	// echo $msg;
	// fclose($handle);
	//view upload form
// }else {

	print "Upload new csv by browsing to file and clicking on Upload";

	print "<form enctype='multipart/form-data' action='create_edit_prod.php' method='post'>";

	print "<label>File name to import:</label>";

	print "<input size='50' type='file' name='filename'>";
	print "<div class='close-up'>   <input type='submit' name='upload_csv' value='Upload'>
	<a href='#' class='btn close-n'>Close</a>  </div>";

	print "</form>";
	

}

?>