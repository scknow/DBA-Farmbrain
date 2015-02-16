<?php
include "connection.php";
$zip = $_GET['code'];
$sql = "SELECT * FROM zipcodes WHERE ZIP=".$zip;
$result = mysql_query($sql);
$arr = array();
while($row=mysql_fetch_array($result)){
	$arr[] = $row;
}
echo json_encode($arr);
?>