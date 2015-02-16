<?php
include "dbcon.php";
$json=stripslashes($_POST['jsn']);
$json_array=json_decode($json,true);
for($i=0;$i<sizeof($json_array);$i++)
{
	$notification_id=$json_array[$i]['notificationid'];
	mysql_query("update notification SET readstatus=1 where notificationid=$notification_id");
}
?>