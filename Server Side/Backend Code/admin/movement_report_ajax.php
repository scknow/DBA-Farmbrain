<?
	include "connection.php";
	$grp_id=$_POST['group_id'];
	$customer_id=$_POST['customer_id'];
	$category_id=$_POST['category_name'];
	$manufact_id=$_POST['manufact_name'];
	if($grp_id==-1)
			{
				$for_customer_grp=" !=-1";	
			}
			else
			{
				$for_customer_grp="=".$grp_id;
			}
			if($customer_id==-1)
			{
				$for_customer=" !=-1";
			}
			else
			{
				$for_customer="=".$customer_id;
			}
			if($category_id==-1)
			{
				$productcategory=" !=-1";
			}
			else
			{
				$productcategory="=".$category_id;
			}
			if($manufact_id==-1)
			{
				$manfucat_id=" !=-1";
				
			}
			else
			{
				$manfucat_id="=".$manufact_id;
			}

$str='';
$querys=mysql_query("select productid from orderdetail,`order` where order.customerid=1 group by productid");
while($row_productId=mysql_fetch_array($querys))
{
	$p_id=$row_productId['productid'];
	if(!isset($_SESSION['supplierid']))
	{
		if($grp_id==-1 && $customer_id==-1 && $category_id==-1 && $manufact_id==-1)
		{
			$query = mysql_query("select orderdetail.productid,productcategoryname,productlabel,productmanufacturer,brand,SUM(confirmedfinalprice) AS price ,AVG(confirmedfinalprice) AS AVG_PRICE,SUM(quantity) AS QTY,manufname,brandname,customer.businessname,supplier.businessname As supplier_name from `order`,orderdetail,productportfolio,productcategory,manufacturer,brand,customer,supplier where `order`.customerid=1 and `order`.orderid=orderdetail.orderid and orderdetail.productid=$p_id and productportfolio.productid=$p_id and productcategory.productcategoryid=productportfolio.productcategoryid and productportfolio.productmanufacturer=manufacturer.manufid and `order`.customerid=customer.customerid and `order`.supplierid=supplier.supplierid  and `order`.`creationtime` > CURDATE() - INTERVAL 1 MONTH GROUP BY productid");

			$query1 = mysql_query("select orderdetail.productid,productcategoryname,productlabel,productmanufacturer,brand,SUM(confirmedfinalprice) AS price ,AVG(confirmedfinalprice) AS AVG_PRICE,SUM(quantity) AS QTY,manufname,brandname,customer.businessname,supplier.businessname As supplier_name from `order`,orderdetail,productportfolio,productcategory,manufacturer,brand,customer,supplier where `order`.customerid=1 and `order`.orderid=orderdetail.orderid and orderdetail.productid=$p_id and productportfolio.productid=$p_id and productcategory.productcategoryid=productportfolio.productcategoryid and productportfolio.productmanufacturer=manufacturer.manufid and `order`.customerid=customer.customerid and `order`.supplierid=supplier.supplierid  and month(creationtime)=month(NOW()) GROUP BY productid");
		}		
		else
		{
			
			$query = mysql_query("select orderdetail.productid,productcategoryname,productlabel,productmanufacturer,brand,SUM(confirmedfinalprice) AS price ,AVG(confirmedfinalprice) AS AVG_PRICE,SUM(quantity) AS QTY,manufname,brandname,customer.businessname,supplier.businessname As supplier_name from `order`,orderdetail,productportfolio,productcategory,manufacturer,brand,customer,supplier where `order`.customerid=1 and `order`.orderid=orderdetail.orderid and orderdetail.productid=$p_id and productportfolio.productid=$p_id and productcategory.productcategoryid=productportfolio.productcategoryid  and productportfolio.productcategoryid".$productcategory." and customer.customergroupid".$for_customer_grp." and productportfolio.productmanufacturer=manufacturer.manufid and manufacturer.manufid".$manfucat_id." and `order`.customerid=customer.customerid and `order`.customerid".$for_customer." and `order`.supplierid=supplier.supplierid  and `order`.`creationtime` > CURDATE() - INTERVAL 1 MONTH GROUP BY productid");

			$query1 = mysql_query("select orderdetail.productid,productcategoryname,productlabel,productmanufacturer,brand,SUM(confirmedfinalprice) AS price ,AVG(confirmedfinalprice) AS AVG_PRICE,SUM(quantity) AS QTY,manufname,brandname,customer.businessname,supplier.businessname As supplier_name from `order`,orderdetail,productportfolio,productcategory,manufacturer,brand,customer,supplier where `order`.customerid=1 and `order`.orderid=orderdetail.orderid and orderdetail.productid=$p_id and productportfolio.productid=$p_id and manufacturer.manufid".$manfucat_id." and productcategory.productcategoryid=productportfolio.productcategoryid and productportfolio.productcategoryid".$productcategory." and productportfolio.productmanufacturer=manufacturer.manufid and `order`.customerid".$for_customer." and `order`.customerid=customer.customerid and `order`.supplierid=supplier.supplierid  and month(creationtime)=month(NOW()) GROUP BY productid");
		}
		
	}
	else
	{
		
		$supplierid = $_SESSION['supplierid'];
		$query = mysql_query("select orderdetail.productid,productcategoryname,productlabel,productmanufacturer,brand,SUM(confirmedfinalprice) AS price ,AVG(confirmedfinalprice) AS AVG_PRICE,SUM(quantity) AS QTY,manufname,brandname,customer.businessname,supplier.businessname As supplier_name from `order`,orderdetail,productportfolio,productcategory,manufacturer,brand,customer,supplier where `order`.customerid=1 and `order`.orderid=orderdetail.orderid and orderdetail.productid=$p_id and productportfolio.productid=$p_id and productcategory.productcategoryid=productportfolio.productcategoryid and productportfolio.productmanufacturer=manufacturer.manufid and `order`.customerid=customer.customerid and `order`.supplierid=supplier.supplierid  and `order`.`creationtime` > CURDATE() - INTERVAL 1 MONTH GROUP BY productid");

		$query1 = mysql_query("select orderdetail.productid,productcategoryname,productlabel,productmanufacturer,brand,SUM(confirmedfinalprice) AS price ,AVG(confirmedfinalprice) AS AVG_PRICE,SUM(quantity) AS QTY,manufname,brandname,customer.businessname,supplier.businessname As supplier_name from `order`,orderdetail,productportfolio,productcategory,manufacturer,brand,customer,supplier where `order`.customerid=1 and `order`.orderid=orderdetail.orderid and orderdetail.productid=$p_id and productportfolio.productid=$p_id and productcategory.productcategoryid=productportfolio.productcategoryid and productportfolio.productmanufacturer=manufacturer.manufid and `order`.customerid=customer.customerid and `order`.supplierid=supplier.supplierid  and month(creationtime)=month(NOW()) GROUP BY productid");

	}

	if(mysql_num_rows($query)!=0 || mysql_num_rows($query1)!=0)
	{
		$row=mysql_fetch_array($query);									
		$row1=mysql_fetch_array($query1);

		if(mysql_num_rows($query)!=0)
		{
			
			$str.= "<tr>";
			$str.= "<td>".$row['businessname']."</td>";
			$str.= "<td>".$row['manufname']."</td>";
			$str.= "<td>".$row['supplier_name']."</td>";
			$str.= "<td>".$row['productcategoryname']."</td>";
			$str.= "<td>".$row['businessname']."</td>";
			$str.= "<td>".$row['brandname']."</td>";
			$str.= "<td>".$row['productlabel']."</td>";

		}
		else
		{
			$str.= "<tr>";
			$str.= "<td>".$row['businessname']."</td>";
			$str.= "<td>".$row['manufname']."</td>";
			$str.= "<td>".$row['supplier_name']."</td>";
			$str.= "<td>".$row['productcategoryname']."</td>";
			$str.= "<td>".$row['businessname']."</td>";
			$str.= "<td>".$row['brandname']."</td>";
			$str.= "<td>".$row['productlabel']."</td>";

		}


		if(mysql_num_rows($query)!=0)
		{	
			$str.= "<td>".$current_qty=$row['QTY']."</td>";
			$str.= "<td>".$current_price=$row['price']."</td>";
			$str.= "<td>".$current_avg_price=round($row['AVG_PRICE'], 2)."</td>";
		}
		else									
		{
			$current_qty=0;
			$current_price=0;
			$current_avg_price=0;
			
			$str.= "<td>".$prev_qty."</td>";
			$str.= "<td>".$prev_price."</td>";
			$str.= "<td>".$prev_avg_price."</td>";

		}
		if(mysql_num_rows($query1)!=0)
		{
			$str.= "<td>".$prev_qty=$row1['QTY']."</td>";
			$str.= "<td>".$prev_price=$row1['price']."</td>";
			$str.= "<td>".$prev_avg_price=round($row1['AVG_PRICE'], 2)."</td>";
		}
		else
		{
			$prev_qty=0;
			$prev_price=0;
			$prev_avg_price=0;
			
			$str.= "<td>".$prev_qty."</td>";
			$str.= "<td>".$prev_price."</td>";
			$str.= "<td>".$prev_avg_price."</td>";
		}

			$mom_qty=abs($prev_qty-$current_qty);
			$mom_price=abs($prev_price-$current_price);
			$mom_avg_price=abs($prev_avg_price-$current_avg_price);
			
			$str.= "<td>".$mom_qty."</td>";
			$str.= "<td>".$mom_price."</td>";
			$str.= "<td>".round($mom_avg_price, 2)."</td>";
			$str.= "</tr>";
		}
}		
echo $str;												
?>