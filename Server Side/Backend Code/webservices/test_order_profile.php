<?php
include "dbcon.php";
include "function.php";
$cutomerid = trim($_REQUEST['cutomer_id']);


//$sql = "SELECT * FROM orderprofile";
$customer_grp_id=get_customer_grp_id($cutomerid);
//$sql="SELECT * FROM `orderprofile`,`profile_setting` where (`customergroup`=-1 OR customergroup=$customer_grp_id) and (`customerid`=$cutomerid OR customerid=-1) and customer_id='$cutomerid'";

$sql="SELECT * FROM `orderprofile`,`profile_setting` where (`customergroup`=-1 OR customergroup='$customer_grp_id') and (`customerid`='$cutomerid' OR customerid=-1) and `profile_setting`.customer_id='$cutomerid'";


$result = mysql_query($sql);
$im=0;

while($row=mysql_fetch_array($result))
{
	$default_id=$row['default_profile_id'];
	$active_profile_id=explode(",",$row['active_profile']);

	if (in_array($row['id'],$active_profile_id)) 
	{
		$order_profiles_list[$row['id']]['name']=$row['name'];
		$order_profiles_list[$row['id']]['profile_id']=$row['id'];
		$order_profiles_list[$row['id']]['type']=$row['type'];
		
		if($default_id==$row['id']) $order_profiles_list[$row['id']]['defaults']=1;
		else $order_profiles_list[$row['id']]['defaults']=0;

		$final_list = array();
		$sqls = "SELECT * FROM orderprofiledetail,orderprofiledetailsupplier WHERE orderprofileid=".$row['id']." and orderprofiledetail.orderprofiledetailid=orderprofiledetailsupplier.orderprofiledetailid";
		
		$ctr = 0;
		$prod_list = array();
		$results = mysql_query($sqls);



			while($rows=mysql_fetch_array($results))
			{
				$order_profiles_list[$row['id']]['products_list'][$rows['productid']]['quantity']=$rows['defaultquantity'];			
				$prod_list[$ctr]["id"] = $rows['productid'];
				$prod_list[$ctr]["qty"] = $rows['defaultquantity'];
				$prod_list[$ctr]["subs"] = $rows['substituteproductids'];
				
				$prm = '';
				$prmv = '';
				$ktr = 0;
				$prm = $rows['supplierid'];
				$prmv = $rows['supplierpremium'];
				$order_profiles_list[$row['id']]['products_list'][$rows['productid']]['supplier_settings'][$prm]['name']=$prm;
				$order_profiles_list[$row['id']]['products_list'][$rows['productid']]['supplier_settings'][$prm]['premium']=$prmv;
							
				$prod_list[$ctr]["prem"] = $prm;
				$prod_list[$ctr]["premv"] = $prmv;
				$ctr++;
			}
		}
}

/*
	order_profiles_list[profile_id]
	.name
	.default
	.profile_id 
	.products_list[product_id]
		.quantity
		.supplier_settings[supplier_id]
			.premium
			.name 
	*/

//$final_list['orderdetails'] = $prod_list;
//echo json_encode($prod_list);

echo json_encode($order_profiles_list);
?>