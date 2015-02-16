<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Upload page</title>

</head>
<body>
<div id='container'>
<div id='form'>
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
	// fgetcsv($handle, 1000, ",");
	// $msg = "";
	// $line_no = 2;
	// $out="";
	// //$out .= "productcategoryname" . ', ' . "Error" . '\n';
	// while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
	// {
		// //$phone = $data[2];
		// $sql_cnt = "select * from productcategory where productcategoryname='$data[1]'";
		// $res = mysql_query($sql_cnt);

		// if(trim($data[1])=="")
		// {
			// $msg = "Some field is missing. Not uploading.<br> ";
			
			// $out .= $data[0] . ', ';
			// $out .= $data[1] . ', ';
			// $out .= "Some field is missing at line - " . $line_no . ', ';
			// $out .= "\n";
		// }
		// else
		// {
			// if(mysql_num_rows($res)>0){
				// $productcategoryid=ltrim(substr(trim($data[0]),-6),'0');
				// $sql = "UPDATE productcategory SET productcategorypic='$productcategorypic' WHERE productcategoryid='$productcategoryid'";		
				// mysql_query($sql);
			// }
			// else
			// {
				// $mname = trim($data[0]);			
					// $import = "INSERT into productcategory(productcategoryname) values('$data[1]')";
					// mysql_query($import) or die(mysql_error());
					// $msg="Upload successfully";
			// }
		// }
		// $line_no += 1;
	// }
	// if($out!=""){
		// // echo "<script></script>";
		// echo "<script>window.open('download_errors.php?data=".urlencode($out)."','_self','height=250,width=250');document.getElementById('msg').innerText = 'Uploaded but with some errors';</script>";
	// }
	// echo $msg;
	// fclose($handle);
// }else {

	
	print "Upload new csv by browsing to file and clicking on Upload";

	print "<form enctype='multipart/form-data' action='create_prod_cat.php' method='post'>";

	print "<label>File name to import:</label>";

	print "<input size='50' type='file' name='filename'>";
	print "<div class='close-up'>   <input type='submit' name='upload_csv' value='Upload'>
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