<?php
	include "connection.php";
	$customer_id=$_POST['customer'];
	$row=mysql_query("select * from customer where customerid='$customer_id'");
	$rows=mysql_fetch_array($row);
	$name=$rows['businessname'];
	echo $name;
?>