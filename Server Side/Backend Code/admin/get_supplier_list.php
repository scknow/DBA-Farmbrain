<?php
include "connection.php";
if($_POST['action'] == 'authenticated' && isset($_POST['action'])){
	$sql = "select supplierid, businessname from supplier where active=1";
	$result = mysql_query($sql);
	$json = array();
	while($row = mysql_fetch_array($result))     
	{
	$json[]= array(
		'supplierid' => $row['supplierid'],
		'businessname' => $row['businessname']
	);
	}
	echo json_encode($json);
}
?>