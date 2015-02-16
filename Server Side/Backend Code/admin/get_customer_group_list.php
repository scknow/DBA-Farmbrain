<?php
include "connection.php";
if($_POST['action'] == 'authenticated' && isset($_POST['action'])){
	$sql = "select customergroupid, customergroupname from customergroup";
	$result = mysql_query($sql);
	$json = array();
	while($row = mysql_fetch_array($result))     
	{
	$json[]= array(
		'customergroupid' => $row['customergroupid'],
		'customergroupname' => $row['customergroupname']
	);
	}
	echo json_encode($json);
}
?>