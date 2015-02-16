<?php
include "dbcon.php";
$customer_id=$_REQUEST['customer_id'];

$sql = "SELECT * FROM supplier,suppliercustomer where `suppliercustomer`.customerid=$customer_id and suppliercustomer.supplierid=supplier.supplierid";
$result = mysql_query($sql);
$arr = array();
if(mysql_num_rows($result)!=0)
{
	while ($row = mysql_fetch_assoc($result))
	{
		$row['mov']=$row['minimumordervalue'];
		$row['mov']=$row['minimumordervalue'];
		$arr[]=$row;		
	}
}
else
{
	$arr['supplierid']=0;
}
echo json_encode($arr);
?>