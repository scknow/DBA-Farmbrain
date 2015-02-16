<?php
include "connection.php";
if($_POST['action'] == 'authenticated' && isset($_POST['action'])){
	$sql = "select customerid, businessname from customer";
	$result = mysql_query($sql);
	$json = array();
	while($row = mysql_fetch_array($result))     
	{
	$json[]= array(
		'customerid' => $row['customerid'],
		'businessname' => $row['businessname']
	);
	}
	echo json_encode($json);
}
?>