<?php
include "dbcon.php";
$cp = $_GET['cp'];
$np = $_GET['np'];
$usrid = $_GET['id'];

$sql = "SELECT * FROM user WHERE userid='$usrid' AND password='$cp'";
$result = mysql_query($sql);

if(mysql_num_rows($result)!=0){
	$sql = "UPDATE user SET password='$np' WHERE userid='$usrid'";
	mysql_query($sql);
	echo mysql_error();
	echo 1;
}else{
	echo 0;
}

?>