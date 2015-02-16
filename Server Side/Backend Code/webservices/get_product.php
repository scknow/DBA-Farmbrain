<?php
include "dbcon.php";
include "function.php";

$cid = $_GET['cat'];
$sid = $_GET['sub'];
$mid = $_GET['manu'];
$bid = $_GET['brand'];

$sql = "SELECT * FROM productportfolio WHERE active=1";

if($cid!="" && $sid=="" && $mid=="" && $bid==""){
	$sql = "SELECT * FROM productportfolio WHERE active=1 AND productcategoryid='$cid'";
}else if($cid=="" && $sid=="" && $mid!="" && $bid==""){
	$sql = "SELECT * FROM productportfolio WHERE active=1 AND productmanufacturer='$mid'";
}else if($cid!="" && $sid!="" && $mid=="" && $bid==""){
	$sql = "SELECT * FROM productportfolio WHERE active=1 AND productcategoryid='$cid' AND productsubcategoryid='$sid'";
}else if($cid=="" && $sid=="" && $mid!="" && $bid!=""){
	$sql = "SELECT * FROM productportfolio WHERE active=1 AND productmanufacturer='$mid' AND brand='$bid'";
}else if($cid!="" && $sid=="" && $mid!="" && $bid==""){
	$sql = "SELECT * FROM productportfolio WHERE active=1 AND productmanufacturer='$mid' AND productcategoryid='$cid'";
}else if($cid!="" && $sid!="" && $mid!="" && $bid==""){
	$sql = "SELECT * FROM productportfolio WHERE active=1 AND productmanufacturer='$mid' AND productcategoryid='$cid' AND productsubcategoryid='$sid'";
}else if($cid!="" && $sid=="" && $mid!="" && $bid!=""){
	$sql = "SELECT * FROM productportfolio WHERE active=1 AND productmanufacturer='$mid' AND productcategoryid='$cid' AND brand='$bid'";
}else if($cid!="" && $sid!="" && $mid!="" && $bid!=""){
	$sql = "SELECT * FROM productportfolio WHERE active=1 AND productmanufacturer='$mid' AND productcategoryid='$cid' AND brand='$bid' AND productsubcategoryid='$sid'";
}else if($cid=="" && $sid!="" && $mid=="" && $bid==""){
	$sql = "SELECT * FROM productportfolio WHERE active=1 AND productsubcategoryid='$sid'";
}

$result = mysql_query($sql);
$arr = array();
$i=0;
while ($row = mysql_fetch_assoc($result))
{
	$arr[$i]=$row;
	$p_id=$row['productid'];
	$cat_id=$row['productcategoryid'];
	$subcat_id=$row['productsubcategoryid'];
	$brand_id=$row['brand'];
	$manu_id=$row['productmanufacturer'];
	$category_name=category_name($cat_id);
	$sub_cat_name=subcategory_name($subcat_id);
	$manu_name=manufact_name($manu_id);
	$brand_name=brand_name($brand_id);
	
	$arr[$i]['cat_name']=$category_name;
	$arr[$i]['sub_cat_name']=$sub_cat_name;
	$arr[$i]['manuf_name']=$manu_name;
	$arr[$i]['brand_name']=$brand_name;
	$arr[$i]['attribute']=attribute_set($p_id);	
	$i++;
}

echo json_encode($arr);
?>