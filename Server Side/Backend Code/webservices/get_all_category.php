<?php
include "dbcon.php";
$sql = "SELECT * FROM productcategory";
$result = mysql_query($sql);
$arr = array();
$k=0;
while ($row = mysql_fetch_assoc($result))
{
	$arr[$k]['id']=$row['productcategoryid'];
	$arr[$k]['name']=$row['productcategoryname'];
	$k++;
}
echo json_encode($arr);
?>