<?php
session_start();
include "connection.php";
$id = $_GET['d'];
$sql = "SELECT * FROM `order` WHERE orderid='$id'";
$result = mysql_query($sql);
$val = mysql_fetch_array($result);
echo json_encode($val);
?>