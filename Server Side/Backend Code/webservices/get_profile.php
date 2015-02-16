<?php
include "dbcon.php";
include "function.php";
$cutomerid = trim($_REQUEST['cutomer_id']);

//$sql = "SELECT * FROM orderprofile";
$customer_grp_id=get_customer_grp_id($cutomerid);
$sql="SELECT * FROM `orderprofile` where (`customergroup`=-1 OR customergroup=$customer_grp_id) and (`customerid`=$cutomerid OR customerid=-1)";

$result = mysql_query($sql);
$im=0;
$mysql_query=mysql_query("SELECT * from profile_setting where customer_id='$cutomerid'");
$fetch_default=mysql_fetch_array($mysql_query);
$default_id=$fetch_default['default_profile_id'];
$active_profile_id=explode(",",$fetch_default['active_profile']);

while($row=mysql_fetch_array($result))
{
	if (in_array($row['id'],$active_profile_id)) 
	{
		$order_profiles_list[$row['id']]['name']=$row['name'];
		$order_profiles_list[$row['id']]['profile_id']=$row['id'];
		$order_profiles_list[$row['id']]['type']=$row['type'];
		
		if($default_id==$row['id']) $order_profiles_list[$row['id']]['defaults']=1;
		else $order_profiles_list[$row['id']]['defaults']=0;

		$final_list = array();
		$sqls = "SELECT * FROM orderprofiledetail WHERE orderprofileid=".$row['id'];
		$ctr = 0;
		$prod_list = array();
		$results = mysql_query($sqls);



			while($rows=mysql_fetch_array($results))
			{
				$order_profiles_list[$row['id']]['products_list'][$rows['productid']]['quantity']=$rows['defaultquantity'];
			
			
			$prod_list[$ctr]["id"] = $rows['productid'];
			$prod_list[$ctr]["qty"] = $rows['defaultquantity'];
			$prod_list[$ctr]["subs"] = $rows['substituteproductids'];
			
			
			$sql = "SELECT * FROM orderprofiledetailsupplier WHERE orderprofiledetailid=".$rows['orderprofiledetailid'];
			
			$result2=mysql_query($sql);
			$prm = '';
			$prmv = '';
			$ktr = 0;
			while($row2=mysql_fetch_array($result2))
			{
					
					$prm = $row2['supplierid'];
					$prmv = $row2['supplierpremium'];
					
					$order_profiles_list[$row['id']]['products_list'][$rows['productid']]['supplier_settings'][$prm]['name']=$prm;
					$order_profiles_list[$row['id']]['products_list'][$rows['productid']]['supplier_settings'][$prm]['premium']=$prmv;
				
			}
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