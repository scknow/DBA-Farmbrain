<?php
include "connection.php";
$id = trim($_GET['d']);
$sql = "SELECT * FROM orderprofile WHERE id='$id'";
$result = mysql_query($sql);
$row=mysql_fetch_array($result);
$final_list = array();
$final_list["head"] = $row; 

$sql = "SELECT * FROM orderprofiledetail WHERE orderprofileid=".$row['id'];

$ctr = 0;
$prod_list = array();
$result = mysql_query($sql);
while($row=mysql_fetch_array($result)){
	$prod_list[$ctr]["id"] = $row['productid'];
	$prod_list[$ctr]["qty"] = $row['defaultquantity'];
	$prod_list[$ctr]["subs"] = $row['substituteproductids'];
	$sql = "SELECT * FROM orderprofiledetailsupplier WHERE orderprofiledetailid=".$row['orderprofiledetailid'];
	$result2=mysql_query($sql);
	$prm = '';
	$prmv = '';
	$ktr = 0;
	while($row2=mysql_fetch_array($result2)){
		if($ktr==0){
			$prm = $row2['supplierid'];
			$prmv = $row2['supplierpremium'];
		}else{
			$prm = $prm.",".$row2['supplierid'];
			$prmv = $prmv.",".$row2['supplierpremium']; 
		}
		$ktr++;
	}
	$prod_list[$ctr]["prem"] = $prm;
	$prod_list[$ctr]["premv"] = $prmv;
	$ctr++;
}
$final_list['orderdetails'] = $prod_list;
echo json_encode($final_list);
?>