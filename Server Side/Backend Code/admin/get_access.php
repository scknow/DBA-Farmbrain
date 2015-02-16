<?php
session_start();
include "connection.php";
$id = $_GET['d'];
$sql = "SELECT * FROM access_level where salesuserid='$id'";
$result = mysql_query($sql);
$val = mysql_fetch_array($result);
echo json_encode($val);
?>