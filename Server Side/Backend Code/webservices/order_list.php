<?php
include "dbcon.php";
$pro_data =stripslashes($_REQUEST['pro_data']);
$customer_id = trim($_REQUEST['customer']);
// $customer_id = 1;
$sql = "SELECT * FROM `order` WHERE customerid='$customer_id' ORDER BY orderid DESC";

$result = mysql_query($sql);
echo mysql_error();
$json = array();
$k=0;
while($row=mysql_fetch_assoc($result))
{
	$json[$k] = $row;
	$ordr_id=$row['orderid'];
	
	if($row['receivestatus']==1)
	{
		$sql1 = mysql_query("SELECT sum(receivedquantity),sum(quantity),sum(receivedquantity*listedprice) AS total_order_final FROM `orderdetail` WHERE orderid='$ordr_id'");
		$row1=mysql_fetch_assoc($sql1);
		$json[$k]['total_received_for_list'] = $row1['sum(receivedquantity)'];
		$json[$k]['short_for_list'] = $row1['sum(quantity)']-$row1['sum(receivedquantity)'];		
		$json[$k]['totalfinal'] = $row1['total_order_final'];		
	}
	
	
	$sql=mysql_query("select * from orderdetail where orderid='$ordr_id'");
	if(mysql_num_rows($sql)==0)	
	{		
		$json[$k]['qty'].="0,";
		$json[$k]['pid'].="0,";		
		$json[$k]['u_price'].="0,";
		$json[$k]['brand'].="0,";
		$json[$k]['manufact'].="0,";
		$json[$k]['jsn_recive'].="0,";
	}
	
	while($rowss=mysql_fetch_assoc($sql))
	{
		$pid_fetch=$rowss['productid'];
		if($row['receivestatus']==1)
		{
			$json[$k]['qty'].=$rowss['quantity'].",";
		}
				
		else if($rowss['confirmedstatus']==1)
		{
			$json[$k]['qty'].=$rowss['confirmedquantity'].",";
		}		
		else
		{
			$json[$k]['qty'].=$rowss['quantity'].",";
		}
		
		$json[$k]['pid'].=$rowss['productid'].",";
		$json[$k]['u_price'].=$rowss['listedprice'].",";
		$json[$k]['brand'].=get_product_brand($pid_fetch).",";		
		$json[$k]['manufact'].=get_product_manuf($pid_fetch).",";
		$json[$k]['jsn_recive'].=$rowss['receivedquantity'].",";		
	}
	
	$k++;
}

echo json_encode($json);

function get_product_brand($pid)
{
	$row=mysql_query("select brandname from productportfolio,brand where productportfolio.brand=`brand`.brandid and productportfolio.productid='$pid'");
	$query=mysql_fetch_array($row);
	return $query[0];
}
function get_product_manuf($pid)
{
	$row=mysql_query("select manufname from productportfolio,manufacturer where productportfolio.productmanufacturer=`manufacturer`.manufid and productportfolio.productid='$pid'");
	$query=mysql_fetch_array($row);
	return $query[0];
}
?>