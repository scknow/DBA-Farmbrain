<?php
session_start();
include "connection.php";
$id = $_GET['d'];
// $pieces = explode("$$", $id);
$id=ltrim(substr(trim($id),-5),'0');
$sql = "SELECT * FROM help_support WHERE id='$id'";
$result = mysql_query($sql);
$val = mysql_fetch_assoc($result);
echo json_encode($val);
?>