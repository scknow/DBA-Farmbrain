<?php
include "connection.php";
$id=$_GET['d'];
$tbl_name = $_GET['t'];
$c = $_GET['c'];
$sql = "UPDATE $tbl_name SET approved='1' WHERE $c='$id'";
$result = mysql_query($sql);
//echo $sql;
?>