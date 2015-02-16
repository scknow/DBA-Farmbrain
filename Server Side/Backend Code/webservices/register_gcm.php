<?php
include "dbcon.php";
$gcm_id = $_POST['gcm'];
$usrid = $_POST['usr'];
$os = $_POST['os'];

$sql = "UPDATE user SET notifyid='$gcm_id', deviceOs='$os' WHERE userid='$usrid'";

$result = mysql_query($sql);
//echo $gcm_id."---------".$usrid;

?>