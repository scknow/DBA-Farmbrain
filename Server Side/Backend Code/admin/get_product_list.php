<?php
include "connection.php";
if($_POST['action'] == 'authenticated' && isset($_POST['action'])){
	$sql = "select productid, productlabel from productportfolio";
	$result = mysql_query($sql);
	$json = array();
	while($row = mysql_fetch_array($result))     
	{
	$json[]= array(
		'productid' => $row['productid'],
		'productlabel' => $row['productlabel']
	);
	}
	echo json_encode($json);
}
?>