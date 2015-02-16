<?php
include "connection.php";
if($_POST['action'] == 'authenticated' && isset($_POST['action'])){
	$sql = "select productsubcategoryid, productsubcategoryname from productsubcategory";
	$result = mysql_query($sql);
	$json = array();
	while($row = mysql_fetch_array($result))     
	{
	$json[]= array(
		'productsubcategoryid' => $row['productsubcategoryid'],
		'productsubcategoryname' => $row['productsubcategoryname']
	);
	}
	echo json_encode($json);
}
?>