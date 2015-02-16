<?php
include "connection.php";
$catid = $_GET['cat'];
$subid = $_GET['sub'];
$srch = $_GET['srch'];

$sql = "SELECT * FROM productportfolio where active='1'";
if($catid=="" && $subid=="" && $srch==""){
	$sql = "SELECT * FROM productportfolio ";
}elseif($catid!="" && $subid=="" && $srch==""){
	$sql = "SELECT * FROM productportfolio WHERE productcategoryid='$catid' and active='1'";
}elseif($catid!="" && $subid!="" && $srch==""){
	$sql = "SELECT * FROM productportfolio WHERE productcategoryid='$catid' AND productsubcategoryid='$subid' and active='1'";
}elseif($catid=="" && $subid=="" && $srch!=""){
	$sql = "SELECT * FROM productportfolio WHERE productlabel LIKE '%$srch%' and active='1'";
}elseif($catid!="" && $subid=="" && $srch!=""){
	$sql = "SELECT * FROM productportfolio WHERE productcategoryid='$catid' AND productlabel LIKE '%$srch%' and active='1'";
}elseif($catid!="" && $subid!="" && $srch!=""){
	$sql = "SELECT * FROM productportfolio WHERE productcategoryid='$catid' AND productsubcategoryid='$subid' AND productlabel LIKE '%$srch%' and active='1' ";
}
//echo $catid." ".$subid." ".$srch." ".$sql;
$result = mysql_query($sql);
$arr = array();
while($row=mysql_fetch_array($result))
{
	$arr[] = $row;
}
echo json_encode($arr);
?>