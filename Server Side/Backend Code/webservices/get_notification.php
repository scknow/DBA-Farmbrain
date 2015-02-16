<?php
include "dbcon.php";
$customerid=trim($_POST['customer']);
$last=trim($_POST['last']);

//$customerid = 1;
if($last==-1)
{
	$sql = "SELECT * FROM notification WHERE notificationto='$customerid' order by notificationdatetime DESC";
}
else 
{
	$sql = "SELECT * FROM notification WHERE notificationto='$customerid' and `notificationdatetime`> DATE_ADD(Now(), INTERVAL- ".$last." day)";
}
$result=mysql_query($sql);
$json = array();
while($row=mysql_fetch_array($result)){
	$json[] = $row;
}
echo json_encode($json);
?>