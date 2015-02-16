<?php
include "dbcon.php";
$pro_data = $_POST['pro_data'];
$customer_id = trim($_POST['customer']);
$name = $_POST['name'];
$pfileid = $_POST['id'];

$sql = "SELECT * FROM customer WHERE customerid=".$customer_id;
$result = mysql_query($sql);
echo mysql_error();

$row = mysql_fetch_array($result);
$customergroup = $row['customergroupid'];

$jso = stripslashes($pro_data);
$arr = json_decode($jso, true);
	if($pfileid==0)
	{
		$sql = "INSERT INTO orderprofile(name, type, customerid, dateofcreation, customergroup)VALUES ('$name', 'personal', '$customer_id', NOW(), '$customergroup')";
		mysql_query($sql);
		echo mysql_error();
	
		$sql="SELECT MAX( id ) FROM orderprofile";
		$result=mysql_query($sql);
		$temp=mysql_fetch_array($result);
		$max_id = $temp['MAX( id )'];
	}
	else
	{
		$sql = "DELETE FROM orderprofiledetail WHERE orderprofileid='$pfileid'";
		mysql_query($sql);
		$max_id = $pfileid;
	}
	for($i=0;$i<sizeof($arr);$i++){
		$productid = $arr[$i]['id'];
		$defaultquantity = $arr[$i]['qty']; 
		$substitu = $arr[$i]['subs'];
		$substituteproductids = '';
		for($k=0;$k<sizeof($substitu);$k++){
			if($k==0){
				$substituteproductids = $substitu[$k];
			}else{
				$substituteproductids = $substituteproductids.",".$substitu[$k] ;
			}
		}
		$prem = $arr[$i]['prem']; 
		$premv = $arr[$i]['premv']; 
		$sql = "INSERT INTO orderprofiledetail(orderprofileid, productid, defaultquantity, substituteproductids)VALUES ('$max_id', '$productid', '$defaultquantity','$substituteproductids')";
		mysql_query($sql);
		echo mysql_error();
		$sql1="SELECT MAX( orderprofiledetailid ) FROM orderprofiledetail";
		$result1=mysql_query($sql1);
		$temp1=mysql_fetch_array($result1);
		$max_id1 = $temp1['MAX( orderprofiledetailid )'];
		
		for($j=0;$j<sizeof($prem);$j++){
			$supplierid = $prem[$j];
			$supplierpremium = $premv[$j];
			$sql = "INSERT INTO orderprofiledetailsupplier(orderprofiledetailid, supplierid, supplierpremium)VALUES ('$max_id1', '$supplierid', '$supplierpremium')";
			mysql_query($sql);
			echo mysql_error();
		}
	}
	$query=mysql_query("select  * from profile_setting where customer_id='$customer_id'");
	if(mysql_num_rows($query)==0)
	{
		$sql="INSERT INTO profile_setting(active_profile,customer_id) VALUES('$max_id','$customer_id')";
	}
	else
	{
		$row=mysql_fetch_array($query);
		$active=$max_id.",".$row['active_profile'];
		$sql="update profile_setting set active_profile='$active' where customer_id='$customer_id'";
	}
	mysql_query($sql);
	echo trim($max_id);
?>