<?php
include "dbcon.php";
$sql = "SELECT * FROM productsubcategory";
$result = mysql_query($sql);
$arr = array();
$k=0;
while ($row = mysql_fetch_assoc($result))
{
	$arr[$k]['id']=$row['productsubcategoryid'];
	$arr[$k]['name']=$row['productsubcategoryname'];
	$arr[$k]['cat_id']=$row['productcategoryid'];
	$k++;
}
echo json_encode($arr);
?>