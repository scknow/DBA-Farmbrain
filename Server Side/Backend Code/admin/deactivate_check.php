<?php

include "connection.php";

$tablename = $_POST['table'];
$pryid = $_POST['column'];
$json = $_POST['local'];
$json = stripslashes($json);
$poheader = json_decode($json, true);

for($i=0;$i<sizeof($poheader);$i++){
	$roe = $poheader[$i]['row'];
	$sql= "update $tablename set active='0' WHERE $pryid='$roe'";
	$result = mysql_query($sql);
}
echo 1;
?>






