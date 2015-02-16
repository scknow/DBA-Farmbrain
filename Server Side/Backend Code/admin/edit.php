<?php
session_start();
include "connection.php";
$id = $_GET['d'];
$pieces = explode("$$", $id);
$sql = "SELECT * FROM $pieces[2] WHERE $pieces[1]='$pieces[0]'";
$result = mysql_query($sql);
$val = mysql_fetch_array($result);
echo json_encode($val);
?>