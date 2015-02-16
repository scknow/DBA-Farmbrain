<?php
include "dbcon.php";
include "function.php";

$id = $_GET['notification_id'];
$action = $_GET['update'];
if($action==1)
{
	mysql_query("update notification set readstatus=1 where notificationid='$id'");
}
else if($action==2)
{
	mysql_query("delete from notification where notificationid='$id'");
}	

?>