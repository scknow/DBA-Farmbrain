<?php
include "dbcon.php";
include "function.php";
$sql = "SELECT * FROM productportfolio";
$result = mysql_query($sql);
$arr = array();
$i=0;
while ($row = mysql_fetch_assoc($result))
{
	$arr[$i]=$row;
	$arr[$i]['cat_name']=category_name($cat_id);
	$i++;
}
echo json_encode($arr);
?>