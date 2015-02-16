<?php
include "connection.php";
$supplierid=$_REQUEST['supplierid'];
$query=mysql_query("select mov,otv from supplier where supplierid='$supplierid'");
$row=mysql_fetch_assoc($query);
echo $row['mov']."&&".$row['otv'];
?>