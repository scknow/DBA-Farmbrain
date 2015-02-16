<?php
include "dbcon.php";
$name = $_GET['name'];
$id = $_GET['pid'];
$action = $_GET['action'];
$customer_id = trim($_GET['customer_id']);
if($action=='update'){
$sql = "UPDATE orderprofile SET name='$name' WHERE id='$id' ";
}elseif($action=='delete'){
	$sql = "DELETE FROM orderprofile WHERE id='$id' ";
}elseif($action=='active'){
	$act = $_GET['active'];
	$sql = "UPDATE orderprofile SET active='$act' WHERE id='$id' ";
}elseif($action=='defaultp'){
	$act = $_GET['customer'];
	$sql = "UPDATE orderprofile SET defaultp='0' WHERE customerid='$act' ";
	mysql_query($sql);
	$sql = "UPDATE orderprofile SET defaultp='1' WHERE id='$id' ";
}
elseif($action=='active_new')
{
	$select_query=mysql_query("select * from profile_setting where customer_id='$customer_id'");
	$count=mysql_num_rows($select_query);
	$active=$_GET['active_array'];
	$active=implode(",",$active);
	if($count==0)
	{
		$sql="INSERT INTO profile_setting(active_profile,customer_id) VALUES('$active','$customer_id')";
	}
	else
	{
		$sql="update profile_setting set active_profile='$active' where customer_id='$customer_id'";
	}
}
elseif($action=='default_new')
{
	$select_query=mysql_query("select * from profile_setting where customer_id='$customer_id'");
	$count=mysql_num_rows($select_query);
	$default_profile_id=$_GET['default_profile_id'];
	
	$active=$_GET['active_array'];
	$active=implode(",",$active);
	
	if($count==0)
	{
		$sql="INSERT INTO profile_setting(default_profile_id,customer_id,active_profile) VALUES('$default_profile_id','$customer_id','$active')";
	}
	else
	{
		$sql="update profile_setting set default_profile_id='$default_profile_id',active_profile='$active' where customer_id='$customer_id'";
	}
}
mysql_query($sql);
echo $customer_id;
//echo $action;
//echo mysql_error();
?>