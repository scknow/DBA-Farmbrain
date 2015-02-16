<?php
include "connection.php";
if($_POST['action'] == 'authenticated' && isset($_POST['action'])){
	$sql = "select brandid, brandname from brand";
	$result = mysql_query($sql);
	$json = array();
	while($row = mysql_fetch_array($result))     
	{
	$json[]= array(
		'brandid' => $row['brandid'],
		'brandname' => $row['brandname']
	);
	}
	echo json_encode($json);
}
?>