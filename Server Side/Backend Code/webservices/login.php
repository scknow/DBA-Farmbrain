<?php
include "dbcon.php";
$user = $_POST['username'];
$password = $_POST['password'];
$sql = "SELECT * FROM user WHERE username = '".$user."' AND password = '".$password."'";
$res = mysql_query($sql);
if (mysql_num_rows($res)!=0)
{
	$row=mysql_fetch_array($res);
	$customerid=$row['customerid'];
	$userid=$row['userid'];
	echo $customerid."#$".$userid."#$".$row['firstname']." ".$row['lastname'];
}else{
	$sql = "SELECT * FROM admin WHERE username = '".$user."' AND password = '".$password."'";
	$res = mysql_query($sql);
	$res = mysql_query($sql);
	if (mysql_num_rows($res)!=0)
	{
		echo 1;
	}else{
		echo 0;
	}
}

?>