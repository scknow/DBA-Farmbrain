<?php
include "dbcon.php";
require('Twilio.php');



function category_name($cat_id)
{
	$check=mysql_query("select * from productcategory where productcategoryid='$cat_id'");
	$row=mysql_fetch_array($check);
	return $row['productcategoryname'];
}
function subcategory_name($subcat_id)
{
	$check=mysql_query("select * from productsubcategory where productsubcategoryid='$subcat_id'");
	$row=mysql_fetch_array($check);
	return $row['productsubcategoryname'];
}
function manufact_name($manufact_id)
{
	$check=mysql_query("select * from manufacturer where manufid='$manufact_id'");
	$row=mysql_fetch_array($check);
	return $row['manufname'];
}
function brand_name($brand_id)
{
	$check=mysql_query("select * from brand where brandid='$brand_id'");
	$row=mysql_fetch_array($check);
	return $row['brandname'];
}
function attribute_set($p_id)
{
	$check=mysql_query("select * from productattributestable where productid='$p_id'");
	while($row=mysql_fetch_array($check))
	{
		$attribute_array['file_path']=$row['attributepic'];
		$attribute_array['type']=$row['attributetype'];
	}
	return $attribute_array;
}
function get_customer_grp_id($cus)
{
	$check=mysql_query("select * from customer where customerid='$cus'");
	$row=mysql_fetch_array($check);
	return $row['customergroupid'];
}
function get_supplier_name_for_mail($id)
	{
		$query=mysql_query("select businessname from supplier where supplierid='$id'");
		$row=mysql_fetch_assoc($query);
		return $row['businessname'];
	}
function get_customer_address($id)
{
	$query=mysql_query("select * from customer where customerid='$id'");
	$row=mysql_fetch_assoc($query);
	return '<td style="width: 100%;float: left;"><b style="width:50%; float: left; clear: both; padding-left:10px; font-weight: normal;">'.$row["businessname"].'</b></td></tr><tr><td style="width: 100%;float: left;"><b style="width: 50%; float: left; clear: both; padding-left:10px; font-weight: normal;">'.$row["shiptoaddress1"].'</b></td><td style="width: 100%;float: left;"><b style="width: 50%; float: left; clear: both; padding-left:10px; font-weight: normal;">'.$row["shiptoaddress2"].'</b></td></tr><tr><td style="width: 100%;float: left;"><b style="width: 50%; float: left; clear: both; padding-left:10px; font-weight: normal;">'.$row["shiptocity"].', '.$row["shiptostate"].' '.$row['shiptozip'].'</b></td>';
}
function get_customer_name_em($id)
{
	$query=mysql_query("select * from customer where customerid='$id'");
	$row=mysql_fetch_assoc($query);
	return $row["businessname"];
}	
function get_order_detail($id)
{
	$query=mysql_query("select customerid,receivedquantity,quantity,receiveddeliverydate,reqdeldt from orderdetail,`order` where orderdetail.orderid=$id");
	
	$row=mysql_fetch_assoc($query);
	$short_item=$row['quantity']-$row['receivedquantity'];
	
	$customer_detail=get_customer_address($row['customerid']);
	
	if($row['receiveddeliverydate']==$row['reqdeldt'])
	{
		$deleivry_status='on-time';
	}
	else
	{
		$deleivry_status='Late';
	}
	$sql=mysql_query("select * from orderdetailfeedback where orderdetailid='$id'");
	$rows=mysql_fetch_assoc($sql);
	
	return $customer_detail.'<td style="width: 100%;float: left; margin-bottom:10px;"><b style="width: 50%; float: left; clear: both; padding-left:10px; font-weight: normal;">Items shorted : '.$short_item.'</b></td><td style="width: 100%;float: left; margin-bottom:10px;"><b style="width: 50%; float: left; clear: both; padding-left:10px; font-weight: normal;">Damages :<img src="http://antloc.com/dba//webservices/uploads/'.$rows["pic"].'" /></b></td><td style="width: 100%;float: left; margin-bottom:10px;"><b style="width: 50%; float: left; clear: both; padding-left:10px; font-weight: normal;">Notes captured by customer  :'.$rows["message"].'" /></b></td><td style="width: 100%;float: left; margin-bottom:10px;"><b style="width: 50%; float: left; clear: both; padding-left:10px; font-weight: normal;">Delivery status :'.$deleivry_status.' /></b></td><td style="width: 100%;float: left; margin-bottom:10px;"><b style="width: 50%; float: left; clear: both; padding-left:10px; font-weight: normal;">Customer’s recorded amount :'.$row["receivedquantity"].' /></b></td>';
}
function get_order_detail_item($id)
{
	$query=mysql_query("select customerid,receivedquantity,quantity,receiveddeliverydate,reqdeldt from orderdetail,`order` where orderdetail.orderdetailid='$id' and orderdetail.orderid=`order`.orderid");	
	$row=mysql_fetch_assoc($query);
	$short_item=$row['quantity']-$row['receivedquantity'];
	
	$customer_detail=get_customer_address($row['customerid']);
	
	if($row['receiveddeliverydate']==$row['reqdeldt'])
	{
		$deleivry_status='on-time';
	}
	else
	{
		$deleivry_status='Late';
	}
	$sql=mysql_query("select * from orderdetailfeedback where orderdetailid='$id'");
	$rows=mysql_fetch_assoc($sql);
	
	return $customer_detail.'<td style="width: 100%;float: left; margin-bottom:10px;"><b style="width: 50%; float: left; clear: both; padding-left:10px; font-weight: normal;">Items shorted : '.$short_item.'</b></td><td style="width: 100%;float: left; margin-bottom:10px;"><b style="width: 50%; float: left; clear: both; padding-left:10px; font-weight: normal;">Damages :<img src="http://antloc.com/dba//webservices/uploads/'.$rows["pic"].'" /></b></td><td style="width: 100%;float: left; margin-bottom:10px;"><b style="width: 50%; float: left; clear: both; padding-left:10px; font-weight: normal;">Notes captured by customer  :'.$rows["message"].'" /></b></td><td style="width: 100%;float: left; margin-bottom:10px;"><b style="width: 50%; float: left; clear: both; padding-left:10px; font-weight: normal;">Delivery status :'.$deleivry_status.' /></b></td><td style="width: 100%;float: left; margin-bottom:10px;"><b style="width: 50%; float: left; clear: both; padding-left:10px; font-weight: normal;">Customer’s recorded amount :'.$row["receivedquantity"].' /></b></td>';	
}

function get_supplier_id_orderdetail($id)
{
	
}


function get_order_deatil_information($id)
{
	$total_amount=0;
	$query=mysql_query("select * from orderdetail,`order` where orderdetail.orderid=`order`.orderid and orderdetail.orderid='$id'");
	$str_line_item=$str_line_item.'<table style="width:100%;border-collapse: collapse;"><thead><tr style="border: solid 1px #000;"><th style="border-right: solid 1px #000;
border-left: solid 1px #000;">Line Item #</th><th style="border-right: solid 1px #000;
border-left: solid 1px #000;">Product</th><th style="border-right: solid 1px #000;
border-left: solid 1px #000;">Product Desc </th><th>Unit price </th><th style="border-right: solid 1px #000;
border-left: solid 1px #000;">Quantity Requested </th><th style="border-right: solid 1px #000;
border-left: solid 1px #000;">Amount </th></tr></thead>';
$ordr_id=10;
	while($row_query=mysql_fetch_array($query))
	{
		$product_information=product_name_info($row_query["productid"]);
		$product_information_array=explode("&&",$product_information);		
		$product_id=str_pad($row_query["productid"],6, '0',STR_PAD_LEFT);		
		$total_amount+=$row_query["quantity"]*$row_query["listedprice"];
		
		$str_line_item=$str_line_item.'<tr style="border-right: solid 1px #000;border-left: solid 1px #000;border-top: solid 1px #000;border-bottom: solid 1px #000;"><td style="border-right: solid 1px #000;
border-left: solid 1px #000;text-align:center;"><b style="width: 50%; float: left; clear: both; padding-left:10px; font-weight: normal;">'.$ordr_id.'</b></td>';
		$str_line_item=$str_line_item.'<td style="border-right: solid 1px #000;
border-left: solid 1px #000;text-align:center;"><b style="width: 50%; float: left; clear: both; padding-left:10px; font-weight: normal;">DBAP'.$product_id.'</b></td>';
		$str_line_item=$str_line_item.'<td style="border-right: solid 1px #000;
border-left: solid 1px #000;text-align:center;"><b style="width: 50%; float: left; clear: both; padding-left:10px; font-weight: normal;">'.$product_information_array[0].'</b></td>';
		$str_line_item=$str_line_item.'<td style="border-right: solid 1px #000;
border-left: solid 1px #000;text-align:center;"><b style="width: 50%; float: left; clear: both; padding-left:10px; font-weight: normal;">$'.$row_query["listedprice"].'</b></td>';
		$str_line_item=$str_line_item.'<td style="border-right: solid 1px #000;
border-left: solid 1px #000;text-align:center;"><b style="width: 50%; float: left; clear: both; padding-left:10px; font-weight: normal;"> '.$row_query["quantity"].'</b></td>';
		$str_line_item=$str_line_item.'<td style="border-right: solid 1px #000;
border-left: solid 1px #000;text-align:center;"><b style="width: 50%; float: left; clear: both; padding-left:10px; font-weight: normal;"> $'.format_change($row_query["quantity"]*$row_query["listedprice"]).'</b></td></tr>';

	$ordr_id=$ordr_id+10;
	}
	$str_line_item=$str_line_item."<tr style='border-right: solid 1px #000;border-left: solid 1px #000;border-top: solid 1px #000;border-bottom: solid 1px #000;'><td></td><td></td><td></td><td></td><td></td><td><b>Total amount $".format_change($total_amount)."</b></td></tr>";
	$str_line_item=$str_line_item.'</table>';
	
	return $str_line_item;
}

function get_order_receipt_deatil($id)
{
	$query=mysql_query("select * from orderdetail where orderid='$id'");
	
	$str_line_item=$str_line_item.'<br><br><table style="width:100%;border-collapse: collapse;"><thead><tr><th style="border-right: solid 1px #000;border-left: solid 1px #000;">Line Item #</th><th style="border-right: solid 1px #000;border-left: solid 1px #000;">Product</th><th style="border-right: solid 1px #000;border-left: solid 1px #000;">Item Desc </th><th style="border-right: solid 1px #000;border-left: solid 1px #000;">Ordered Qty </th><th style="border-right: solid 1px #000;border-left: solid 1px #000;">Received Qty </th><th style="border-right: solid 1px #000;border-left: solid 1px #000;">Unit price </th><th style="border-right: solid 1px #000;border-left: solid 1px #000;">Total Amount (Order value) </th><th style="border-right: solid 1px #000;border-left: solid 1px #000;">Total Amount (Received Value) </th></tr></thead>';
	
	$total_amount=0;
	while($row_query=mysql_fetch_array($query))
	{
		$product_information=product_name_info($row_query["productid"]);
		$product_information_array=explode("&&",$product_information);
		$ordr_id=10;
		$product_id=str_pad($row_query["productid"],6, '0',STR_PAD_LEFT);
		$total_amount+=$row_query["receivedquantity"]*$row_query["listedprice"];
		
		$str_line_item=$str_line_item.'<tr style="border-right: solid 1px #000;border-left: solid 1px #000;border-top: solid 1px #000;border-bottom: solid 1px #000;"><td style="border-right: solid 1px #000;
border-left: solid 1px #000;text-align:center;"><b style="width: 50%; float: left; clear: both; padding-left:10px; font-weight: normal;">'.$ordr_id.'</b></td>';
		$str_line_item=$str_line_item.'<td style="border-right: solid 1px #000;
border-left: solid 1px #000;text-align:center;"><b style="width: 50%; float: left; clear: both; padding-left:10px; font-weight: normal;">'.$product_information_array[0].'</b></td>';
		$str_line_item=$str_line_item.'<td style="border-right: solid 1px #000;
border-left: solid 1px #000;text-align:center;"><b style="width: 50%; float: left; clear: both; padding-left:10px; font-weight: normal;">'.$product_information_array[1].'</b></td>';
		
		$str_line_item=$str_line_item.'<td style="border-right: solid 1px #000;
border-left: solid 1px #000;text-align:center;"><b style="width: 50%; float: left; clear: both; padding-left:10px; font-weight: normal;">'.$row_query["quantity"].'</b></td>';

		$str_line_item=$str_line_item.'<td style="border-right: solid 1px #000;
border-left: solid 1px #000;text-align:center;"><b style="width: 50%; float: left; clear: both; padding-left:10px; font-weight: normal;">'.$row_query["receivedquantity"].'</b></td>';
		
		$str_line_item=$str_line_item.'<td style="border-right: solid 1px #000;
border-left: solid 1px #000;text-align:center;"><b style="width: 50%; float: left; clear: both; padding-left:10px; font-weight: normal;">$'.$row_query["listedprice"].'</b></td>';
		
		$str_line_item=$str_line_item.'<td style="border-right: solid 1px #000;
border-left: solid 1px #000;text-align:center;"><b style="width: 50%; float: left; clear: both; padding-left:10px; font-weight: normal;"> $'.format_change($row_query["quantity"]*$row_query["listedprice"]).'</b></td>';
		
		$str_line_item=$str_line_item.'<td style="border-right: solid 1px #000;
border-left: solid 1px #000;text-align:center;"><b style="width: 50%; float: left; clear: both; padding-left:10px; font-weight: normal;"> $'.format_change($row_query["receivedquantity"]*$row_query["listedprice"]).'</b></td></tr>';
$ordr_id=$ordr_id+10;
	}
		$str_line_item=$str_line_item."<tr style='border-right: solid 1px #000;border-left: solid 1px #000;border-top: solid 1px #000;border-bottom: solid 1px #000;'><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total amount $".format_change($total_amount)."</b></td></tr>";
		$str_line_item=$str_line_item.'</table>';
	return $str_line_item;
}


function product_name_info($product_id)
{
	$query=mysql_query("select * from productportfolio where productid='$product_id'");
	$row=mysql_fetch_array($query);
	return $row['productlabel']."&&".$row['productdescription'];
}	

function get_order_customer($order_id)
{
	$query=mysql_query("select * from `order` where orderid='$order_id'");
	$row_query=mysql_fetch_array($query);
	return $row_query['customerid'];
}	

function find_short($ordr_detailid)
{
	$row=mysql_query('select SUM(quantity)-SUM(receivedquantity) AS short_qty from orderdetail where orderid=$ordr_detailid');
	return $row['short_qty'];
}
function supplier_email($sup_id)
{
	$query=mysql_query("select email from supplier where supplierid='$id'");
	$row=mysql_fetch_assoc($query);
	return $row['email'];
}
function supplier_id_for_order($id)
{
	$query=mysql_query("select supplierid from `order` where orderid='$id'");
	$row=mysql_fetch_assoc($query);
	return $row['supplierid'];
}
function format_change($currrency)
{
	return number_format((float)$currrency, 2, '.', '');
}

?>