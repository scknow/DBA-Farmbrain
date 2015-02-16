<?php
include "dbcon.php";
include "function.php";
$pid = $_GET['pid'];
$cid = trim($_GET['customer']);
$gid=get_customer_grp_id($cid);

$json = array();
$s_date = date("Y-m-d");
$k=0;
for($i=0;$i<sizeof($pid);$i++)
{

$sql = "SELECT * FROM pricing WHERE (customerid='".$cid."' OR customerid='-1') AND  (customergroup='-1' OR customergroup='".$gid."') AND productid='".$pid[$i]."' and datefrom <= '$s_date' AND dateto >= '$s_date' ORDER BY price ASC";

$result = mysql_query($sql);
echo mysql_error();
if(mysql_num_rows($result)==0)
{	
	While($row=mysql_fetch_assoc($result))
	{
		$supplierid=$row['supplierid'];
		$json[$k] = $row;
		$price_id=$row['id'];
		$sql_query=mysql_query("select * from promotion where datefrom <= '$s_date' AND dateto >= '$s_date' and productid='$pid[$i]' and supplierid='$supplierid'");
		
		$price_adn_date=get_price_product($cid,$gid,$pid[$i],$supplierid,$price_id,$price_actual);
		$last_o=last_order_deatil($cid,$gid,$pid[$i],$supplierid);
		$price_actual=$row['price'];
		$price_after_week=explode("&&",$price_adn_date);
		$json[$k]['price_change_after_week']=$price_after_week[0];
		$json[$k]['LOD']=$last_o;
		$json[$k]['price_change_date']=$price_adn_date;
		
		if(mysql_num_rows($sql_query)==0)
		{
			$json[$k]['offinvoice'] =0;
			$json[$k]['valueoff'] =0;
			$json[$k]['precentageoff'] =0;
			$json[$k]['rebate'] =0;
			$json[$k]['pro_min_qty'] =0;
		}
		else
		{
			
			while($query_r=mysql_fetch_assoc($sql_query))
			{
				if($query_r['type']=='OFFINVOICE')
				{
					$json[$k]['offinvoice'] =1;
					if($json[$k]['rebate']!='')$json[$k]['rebate']=0;
				}
				else
				{
					$json[$k]['rebate'] =$query_r['promotionid'];
					if($json[$k]['offinvoice']!='')$json[$k]['offinvoice'] =0;
				}
			
			$json[$k]['valueoff'] =$query_r['valueoff'];
			$json[$k]['precentageoff'] =$query_r['percentageoff'];
			$json[$k]['pro_min_qty'] =$query_r['minimumorderquantity'];
			}
			
		}
		$k++;
	}
	
		
}
else
{
	While($row=mysql_fetch_assoc($result)){
		$json[$k] = $row;
		$supplierid=$row['supplierid'];
		$price_id=$row['id'];
		$price_actual=$row['price'];
		
		$sql_query=mysql_query("select * from promotion where datefrom <= '$s_date' AND dateto >= '$s_date' AND productid='$pid[$i]' AND supplierid='$supplierid'");	
		$price_adn_date=get_price_product($cid,$gid,$pid[$i],$supplierid,$price_id,$price_actual);
		$last_o=last_order_deatil($cid,$gid,$pid[$i],$supplierid);
		$price_after_week=explode("&&",$price_adn_date);
		$json[$k]['price_change_after_week']=$price_after_week[0];
		$json[$k]['price_change_date']=$price_adn_date;
		$json[$k]['LOD']=$last_o;
		if(mysql_num_rows($sql_query)==0)
		{
			
			$json[$k]['offinvoice'] =0;
			$json[$k]['valueoff'] =0;
			$json[$k]['precentageoff'] =0;
			$json[$k]['rebate'] =0;
			$json[$k]['pro_min_qty'] =0;
		}
		else
		{
			while($query_r=mysql_fetch_assoc($sql_query))
			{			
				if($query_r['type']=='OFFINVOICE')
				{
					$json[$k]['offinvoice'] =1;
					if($json[$k]['rebate']=='')$json[$k]['rebate']=0;
				}
				else
				{
					$json[$k]['rebate'] =$query_r['promotionid'];
					if($json[$k]['offinvoice']=='')$json[$k]['offinvoice'] =0;
				}

				
				$json[$k]['valueoff'] =$query_r['valueoff'];
				$json[$k]['precentageoff'] =$query_r['percentageoff'];
				$json[$k]['pro_min_qty'] =$query_r['minimumorderquantity'];
			}
		}
		$k++;
	}
}

}

echo json_encode($json); 

function get_price_product($cid,$Cgroup_id,$pp_id,$supplierid,$price_id,$price_actual)
{	
	
	$sql_qurey=mysql_query("SELECT * FROM pricing WHERE (customerid='-1' OR customerid='$cid') AND (customergroup='-1' OR customergroup='$Cgroup_id')  AND productid='$pp_id' AND id!='$price_id' AND supplierid='$supplierid' AND datefrom > NOW() AND dateto >= DATE_SUB(NOW(), INTERVAL 7 DAY) LIMIT 0,1");
	
	
	if(mysql_num_rows($sql_qurey)==0)
	{
		return "0";	
	}
	else
	{
		$row=mysql_fetch_array($sql_qurey);
		if($price_actual==$row['price'])
		{
				return 0;	
		}
		else{
		return $row['price']."&&".$row['datefrom'];	}
	}
}
function last_order_deatil($cid,$Cgroup_id,$pp_id,$supplierid)
{
	$sql_qureys=mysql_query("SELECT * FROM `order`,orderdetail where `order`.orderid=orderdetail.orderid and `order`.customerid='$cid' and orderdetail.productid='$pp_id' and `order`.supplierid!='0' and `order`.supplierid='$supplierid' ORDER BY `order`.creationtime DESC LIMIT 0,1");
	if(mysql_num_rows($sql_qureys)==0)
	{
		return 'N&#47;a && N&#47;a';
	}
	else
	{
		while($row_query=mysql_fetch_assoc($sql_qureys))
		{
			$orderid=$row_query['orderid'];
			$date_time=$row_query['creationtime'];
			$date_time=explode(" ",$date_time);
			$newDate = date("m-d-Y", strtotime($date_time[0]));
			return $row_query['quantity']."&&".$newDate;
			
		}
	}
}
?>
