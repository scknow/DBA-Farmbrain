<?php
include "dbcon.php";
$id = $_GET['cid'];
if($id==""){
	$sql = "SELECT * FROM productsubcategory";
}else{
	$sql = "SELECT * FROM productsubcategory WHERE productcategoryid='$id'";
}
$result = mysql_query($sql);
$arr = array();
while ($row = mysql_fetch_assoc($result))
{
$arr[]=$row;
}
echo json_encode($arr);
?>