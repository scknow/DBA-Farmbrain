<?php
include "dbcon.php";
//$customer_id=1;
$customer_id=trim($_REQUEST['customer']);
$aq=trim($_REQUEST['aq']);
$from=trim($_REQUEST['from']);
$to=trim($_REQUEST['to']);

$current_month=date('m');

if($aq==0){$qty_qty='quantity';}
else{$qty_qty='`orderdetail`.listedprice*quantity';}

	if($from==0)
	{	
		 if($current_month-1==0)
		{
			$query=mysql_query("select SUM($qty_qty) as product_qty,`orderdetail`.productid,`orderdetail`.quantity,productportfolio.productcategoryid,productcategoryname from `orderdetail`,productportfolio,productcategory where `orderdetail`.productid=`productportfolio`.productid and `productportfolio`.productcategoryid =productcategory.productcategoryid and  orderid IN(select orderid from `order` where YEAR(`creationtime`) = YEAR(NOW())-1 and MONTH(`creationtime`)=12 and customerid='$customer_id' and `order`.receivestatus=1) GROUP BY productcategoryname");
		}
		else
		{
			$query=mysql_query("select SUM($qty_qty) as product_qty,`orderdetail`.productid,`orderdetail`.quantity,productportfolio.productcategoryid,productcategoryname from `orderdetail`,productportfolio,productcategory where `orderdetail`.productid=`productportfolio`.productid and `productportfolio`.productcategoryid =productcategory.productcategoryid and  orderid IN(select orderid from `order` where MONTH(`creationtime`) = MONTH(NOW())-1 and customerid='$customer_id' and `order`.receivestatus=1) GROUP BY productcategoryname");
		} 
		
		// $query=mysql_query("select SUM($qty_qty) as product_qty,`orderdetail`.productid,`orderdetail`.quantity,productportfolio.productcategoryid,productcategoryname from `orderdetail`,productportfolio,productcategory where `orderdetail`.productid=`productportfolio`.productid and `productportfolio`.productcategoryid =productcategory.productcategoryid and  orderid IN(select orderid from `order` where MONTH(`creationtime`) = MONTH(NOW())-1 and customerid='$customer_id' and `order`.receivestatus=1) GROUP BY productcategoryname");
	}
	else
	{
		$query=mysql_query("select SUM($qty_qty) as product_qty,`orderdetail`.productid,`orderdetail`.quantity,productportfolio.productcategoryid,productcategoryname from `orderdetail`,productportfolio,productcategory where `orderdetail`.productid=`productportfolio`.productid and `productportfolio`.productcategoryid =productcategory.productcategoryid and  orderid IN(select orderid from `order` where YEAR(`creationtime`) = YEAR(NOW())-1 and customerid='$customer_id' and `order`.receivestatus=1) GROUP BY productcategoryname");
	}
	$i=0;
if(mysql_num_rows($query)!=0)
{
		
	while($row=mysql_fetch_array($query))
	{
			$cat_name=$row['productcategoryname'];		
			$orderids['last_month']['category_name'][$i]=$cat_name;
			$orderids['last_month']['product_qty'][$i]=$row['product_qty'];
			$i++;
		
		
	}
}
else
{
	$orderids['last_month']['category_name'][$i]='';
	$orderids['last_month']['product_qty'][$i]='';
}

	if($from==0)
	{	
		$query=mysql_query("select SUM($qty_qty) as product_qty,`orderdetail`.productid,`orderdetail`.quantity,productportfolio.productcategoryid,productcategoryname from `orderdetail`,productportfolio,productcategory where `orderdetail`.productid=`productportfolio`.productid and `productportfolio`.productcategoryid =productcategory.productcategoryid and  orderid IN(select orderid from `order` where MONTH(`creationtime`) = MONTH(NOW()) and customerid='$customer_id' and `order`.receivestatus=1) GROUP BY productcategoryname");
	}
	else
	{
		$query=mysql_query("select SUM($qty_qty) as product_qty,`orderdetail`.productid,`orderdetail`.quantity,productportfolio.productcategoryid,productcategoryname from `orderdetail`,productportfolio,productcategory where `orderdetail`.productid=`productportfolio`.productid and `productportfolio`.productcategoryid =productcategory.productcategoryid and  orderid IN(select orderid from `order` where YEAR(`creationtime`) = YEAR(NOW()) and customerid='$customer_id' and `order`.receivestatus=1) GROUP BY productcategoryname");
	}

if(mysql_num_rows($query)!=0)
{	
$i=0;
	while($row=mysql_fetch_array($query))
	{
		$cat_name=$row['productcategoryname'];
		
		/* if($orderids['current_month'][$cat_name]!='')
		{
			$orderids['current_month'][$cat_name]+=$row['product_qty'];
		}
		else
		{
			$orderids['current_month'][$cat_name]=$row['product_qty'];
		} */
		
			$orderids['current_month']['category_name'][$i]=$cat_name;
			$orderids['current_month']['product_qty'][$i]=$row['product_qty'];
			$i++;
	}
}
else
{
 
 $orderids['current_month']['category_name'][$i]='';
	$orderids['current_month']['product_qty'][$i]='';
}/* 

$query=mysql_query("select * from productcategory");
while($row=mysql_fetch_array($query))
{
	$cat_name=$row['productcategoryname'];
	$orderids['category_name'][]=$cat_name;
	for($i=0;$i<sizeof($orderids['current_month']);$i++)
		{
			if($orderids['current_month'][$cat_name]=='')
			{
				$orderids['current_month'][$cat_name]=0;
			}
			if($orderids['last_month'][$cat_name]=='')
			{
				$orderids['last_month'][$cat_name]=0;
			}
		}
} */
echo json_encode($orderids,true);

?>