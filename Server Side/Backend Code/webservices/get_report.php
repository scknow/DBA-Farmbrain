<?php
include "dbcon.php";
$customer = trim($_POST['customer']);
$ti = $_POST['t'];



if($ti==1)
{
	$sql = "SELECT SUM(orderdetail.receivedquantity*orderdetail.listedprice) AS total_spend,SUM(`order`.`total_saving`) AS Tdiscount,supplierid  FROM `order`,orderdetail WHERE customerid='$customer' AND `order`.active=1 and `order`.orderid=orderdetail.orderid and  `order`.receivestatus=1 AND month(creationtime)=month(NOW())";
}
else
{
	$sql = "SELECT SUM(orderdetail.receivedquantity*orderdetail.listedprice) AS total_spend,SUM(`order`.`total_saving`) AS Tdiscount,supplierid  FROM `order`,orderdetail WHERE customerid='$customer' AND `order`.active=1 and `order`.orderid=orderdetail.orderid and  `order`.receivestatus=1 AND year(creationtime)=year(NOW())";
}
$result = mysql_query($sql);
echo mysql_error();
$sid = "";
$ts = 0;
$tsar = array();
$report = array();

if(mysql_num_rows($result)!=0)
{	
	while($row=mysql_fetch_assoc($result))
	{
		
		
		$report['total_spend']= round($row['total_spend'],2);
		$report['t_saving']=round($row['Tdiscount'],2);
	}
}
else
{
	$report['max_supplier'] = 0;
	$report['max_supplierid'] = 0;
	$report['total_spend']= 0;
	$report['t_saving']=0;
}
//here i am finding supplier on which max spend
if($ti==1)
{
	$sql_qu=mysql_query("SELECT `supplierid`,totalprice FROM `order` where customerid = '$customer'  and `order`.active=1  and `order`.receivestatus=1 AND month(creationtime)=month(NOW()) ORDER BY totalprice DESC LIMIT 0,1");
	
}
else
{
	$sql_qu=mysql_query("SELECT `supplierid`,totalprice FROM `order` where customerid = '$customer'  and `order`.active=1  and `order`.receivestatus=1 AND year(creationtime)=year(NOW()) ORDER BY totalprice DESC LIMIT 0,1");
}
if(mysql_num_rows($sql_qu)!=0)
{
	$row_qu=mysql_fetch_assoc($sql_qu);
	$report['max_supplier'] = round($row_qu['totalprice'],2);
	$report['max_supplierid'] = $row_qu['supplierid'];
}
else
{
	$report['max_supplier'] = 0;
	$report['max_supplierid'] = 0;
}

// $sql = mysql_query("SELECT *  FROM `order` AS f  JOIN (SELECT productid,orderid,SUM(confirmedfinalprice) AS Max_spend FROM orderdetail GROUP BY productid) AS s ON f.orderid= s.orderid and  f.customerid='1' ORDER BY s.Max_spend DESC LIMIT 0,1");
if($ti==1)
{
	$sql=mysql_query("SELECT productid,SUM(orderdetail.receivedquantity*orderdetail.listedprice) as total_product_spend FROM orderdetail WHERE orderid IN (SELECT orderid FROM `order` WHERE customerid = '$customer' and `order`.active=1  and `order`.receivestatus=1 AND month(creationtime)=month(NOW())) GROUP BY productid ORDER BY total_product_spend DESC LIMIT 0,1");
}
else
{
	$sql=mysql_query("SELECT productid,SUM(orderdetail.receivedquantity*orderdetail.listedprice) as total_product_spend FROM orderdetail WHERE orderid IN (SELECT orderid FROM `order` WHERE customerid = '$customer' and `order`.active=1 and `order`.receivestatus=1 AND year(creationtime)=year(NOW())) GROUP BY productid ORDER BY total_product_spend DESC LIMIT 0,1");
}
if(mysql_num_rows($sql)!=0)
{	
	$row=mysql_fetch_assoc($sql);
	$report['max_pro_spend']=round($row['total_product_spend'],2);
	$report['max_pro_id']=$row['productid'];
}
else
{
	$report['max_pro_spend']=0;
	$report['max_pro_id']=0;
}

echo json_encode($report);

?>