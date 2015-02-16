<?php
	include "connection.php";
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
?>