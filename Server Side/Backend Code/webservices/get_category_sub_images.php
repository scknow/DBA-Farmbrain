<?php
include "dbcon.php";
$sql = "SELECT * FROM productcategory";
$result = mysql_query($sql);
$arr = array();
$k=0;
while ($row = mysql_fetch_assoc($result))
{
	$arr[]=$row;
	$cat_id=$row['productcategoryid'];
	$result1=mysql_query("select * from productsubcategory where productcategoryid='$cat_id'");
	while($row_sub_id=mysql_fetch_array($result1))
	{
		$arr[$k]['sub_id'][]=$row_sub_id['productsubcategoryid'];
		$arr[$k]['cat_name'][]=$row_sub_id['productsubcategoryname'];
		$arr[$k]['pic'][]=$row_sub_id['productsubcategorypic'];
	}
	$k++;
}
echo json_encode($arr);

?>