<?php
include "dbcon.php";
$sql = "SELECT * FROM productcategory";
$result = mysql_query($sql);
$arr = array();
while ($row = mysql_fetch_assoc($result))
{
$arr[]=$row;
}
echo json_encode($arr);
?>