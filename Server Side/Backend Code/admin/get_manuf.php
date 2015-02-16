<?php
include "connection.php";
$sql = "SELECT manufid FROM manufacturer";
$result=mysql_query($sql);
$arr = array();
while($row=mysql_fetch_array($result)){
	$arr[] = $row;
}
echo json_encode($arr);
?>