<?php
include "connection.php";
if($_POST['action'] == 'authenticated' && isset($_POST['action'])){
	$sql = "select productcategoryid, productcategoryname from productcategory";
	$result = mysql_query($sql);
	$json = array();
	while($row = mysql_fetch_array($result))     
	{
	$json[]= array(
		'productcategoryid' => $row['productcategoryid'],
		'productcategoryname' => $row['productcategoryname']
	);
	}
	echo json_encode($json);
}
?>