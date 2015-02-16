<?php
include "dbcon.php";
$cid = $_GET['customer'];
//$cid = 1;
$sql = "SELECT * FROM  suppliercustomer WHERE customerid='$cid'";
$result = mysql_query($sql);
$json = array();

while($row=mysql_fetch_array($result)){
	$json[] = $row;
}
echo json_encode($json);
//echo $cid;
?>