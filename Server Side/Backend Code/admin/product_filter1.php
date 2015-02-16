<?php
include "connection.php";
$event_id = $_GET['event_id'];
$sql1=mysql_query("SELECT * FROM promotionaleventdetail where eventid='$event_id'");
$i=0;
while($row1=mysql_fetch_array($sql1))
{
	$pid=$row1['productid'];
	$sql = "SELECT * FROM productportfolio where productid='$pid'";
	$result = mysql_query($sql);
	$row=mysql_fetch_assoc($result);
	$arr[$i] = $row;
	$i++;
}

echo json_encode($arr);
?>