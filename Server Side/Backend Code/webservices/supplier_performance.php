<?php
include "dbcon.php";
$customer = trim($_REQUEST['customer']);

if($customer!=-1)
{
	$cutomer_id="=".$customer;
}
else
{
	$cutomer_id="!=-1";
}

$from = $_REQUEST['from'];

if($from=='0')
{
	$sql ="SELECT * FROM `order` where customerid".$cutomer_id." and creationtime>DATE_ADD(Now(), INTERVAL- 6 MONTH) and receivestatus=1";
}
else
{
	$sql ="SELECT * FROM `order` where customerid".$cutomer_id." and creationtime>DATE_ADD(Now(), INTERVAL- 12 MONTH) and receivestatus=1";
}



$array_previous[]='';

$array_ontime_deleivery=1;

$result=mysql_query($sql);
if(mysql_num_rows($result)!=0)
{
while($row=mysql_fetch_assoc($result))
	{
		$array_orderId[$row['supplierid']][$row['orderid']]=$row['orderid'];
		
			$qty_o=qty_order($row['orderid']);
			if($qty_o!=0)
			{
				if($suppiler_qty_deleivered[$row['supplierid']]=='')
				{
					$suppiler_qty_deleivered[$row['supplierid']]=1;
				}
				else
				{
					$suppiler_qty_deleivered[$row['supplierid']]+=1;
				}
			}
		
		
		
		if($suppiler_total[$row['supplierid']]=='')
			{
				$suppiler_total[$row['supplierid']]=1;
			}
		else
			{
				$suppiler_total[$row['supplierid']]+=1;
			}
		
		if($suppiler_spend_total[$row['supplierid']]=='')
			{
				$suppiler_spend_total[$row['supplierid']]=$row['totalfinal'];
			}
		else
			{
				$suppiler_spend_total[$row['supplierid']]+=$row['totalfinal'];
			}
			
		if($row['reqdeldt']==$row['receiveddeliverydate'])
		{
		
			if(!in_array($row['orderid'], $array_previous))
			{
				$array_previous[]=$row['orderid'];
				if($per_suppiler[$row['supplierid']]=='')
				{
					$per_suppiler[$row['supplierid']]=1;
				}
				else
				{
					$per_suppiler[$row['supplierid']]+=1;
				}
			}
		}
	}
}
else
{
	$suppiler_total[$row['supplierid']]=0;
	$per_suppiler[$row['supplierid']]=0;
}

/* echo "<pre>";
print_r($suppiler_total);
print_r($per_suppiler); */

$key_array=array_keys($suppiler_total);
for($i=0;$i<sizeof($key_array);$i++)
{
	$supplier_percentage['supplier_total'][]=$suppiler_total[$key_array[$i]];
	if($per_suppiler[$key_array[$i]]!='')
	{
		$supplier_percentage['supplier_id'][]=$key_array[$i];
		$total_order=$suppiler_total[$key_array[$i]];
		$ontime_delevry=$per_suppiler[$key_array[$i]];
		if($total_order!=0)	$supplier_percentage['ontime_deleviry_percentage'][]=round(($ontime_delevry*100)/$total_order,2);
		else $supplier_percentage['ontime_deleviry_percentage'][]=0;
		
	}
	else
	{
		$supplier_percentage['supplier_id'][]=$key_array[$i];
		$supplier_percentage['ontime_deleviry_percentage'][]=0;
	}
	
	if($suppiler_qty_deleivered[$key_array[$i]]!='')
	{
		
		$ontime_delevry=$suppiler_qty_deleivered[$key_array[$i]];
		$supplier_percentage['complete_delievry'][]=round(($ontime_delevry*100)/$total_order,2);
		
	}
	else
	{
		
		$supplier_percentage['complete_delievry'][]=0;
	}
	
	$supplier_percentage['supplier_total_spend'][]=$suppiler_spend_total[$key_array[$i]];
	
}

function qty_order($ordrid)
{
	$sql =mysql_query("SELECT SUM(quantity)-SUM(receivedquantity) AS remaining_receive FROM  orderdetail where orderid='$ordrid'");
	$row=mysql_fetch_assoc($sql);
	if($row['remaining_receive']==0)
	{
		return 1;
	}
	else
	{
		return 0;
	}
	
}

echo json_encode($supplier_percentage);


?>