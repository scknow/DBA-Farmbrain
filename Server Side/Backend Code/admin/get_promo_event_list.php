<?php
include "connection.php";
if($_POST['action'] == 'authenticated' && isset($_POST['action'])){
	$sql = "select eventid, eventname from promotionalevent";
	$result = mysql_query($sql);
	$json = array();
	while($row = mysql_fetch_array($result))     
	{
	$json[]= array(
		'eventid' => $row['eventid'],
		'eventname' => $row['eventname']
	);
	}
	echo json_encode($json);
}
?>