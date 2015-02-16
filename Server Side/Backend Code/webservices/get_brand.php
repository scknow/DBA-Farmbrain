<?php
include "dbcon.php";
$id = $_GET['mid'];
$sql = "SELECT * FROM brand WHERE manufid='$id'";
$result = mysql_query($sql);
$arr = array();
while ($row = mysql_fetch_assoc($result))
{
$arr[]=$row;
}
echo json_encode($arr);
?>