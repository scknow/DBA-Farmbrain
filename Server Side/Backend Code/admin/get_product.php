<?php
include "connection.php";
$sql = "SELECT * FROM productportfolio where active='1'";
$result = mysql_query($sql);
$arr = array();
while ($row = mysql_fetch_assoc($result))
{
	$arr[]=$row;
}
echo json_encode($arr);
?>