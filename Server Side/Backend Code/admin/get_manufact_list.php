<?php
include "connection.php";
if($_POST['action'] == 'authenticated' && isset($_POST['action'])){
	$sql = "select manufid, manufname from manufacturer";
	$result = mysql_query($sql);
	$json = array();
	while($row = mysql_fetch_array($result))     
	{
	$json[]= array(
		'manufid' => $row['manufid'],
		'manufname' => $row['manufname']
	);
	}
	echo json_encode($json);
}
?>