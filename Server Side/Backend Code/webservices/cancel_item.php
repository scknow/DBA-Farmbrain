<?php
include "dbcon.php";
include "function.php";
$action=$_GET['action'];
$ordr_id=trim($_GET['order']);
$email_supplier=get_supplier_email($ordr_id);

if($action=='item')
{
	$id=$_GET['odid'];
	$sql="DELETE FROM orderdetail WHERE orderdetailid='$id'";
	mysql_query($sql);
}
else if($action=='edit')
{
	$json=stripslashes($_GET['jsn']);
	$jsn_arr=json_decode($json,true);
	$req_date=$_REQUEST['date'];
	for($i=0;$i<sizeof($jsn_arr);$i++)
	{
		$qty=$jsn_arr[$i]['qty'];
		$id=$jsn_arr[$i]['id'];
		
		// Here i am getting unit price of an product
		$qu=mysql_query("select listedprice,quantity from orderdetail where orderdetailid=$id");
		$row_fetch=mysql_fetch_array($qu);
		$price_unit_listed_prev=$row_fetch['listedprice']*$row_fetch['quantity'];
		$price_unit_listed_now=$row_fetch['listedprice']*$qty;
		
		//Here is i am finding if price is increasing or decreasing
		$price_change=$price_unit_listed_now-$price_unit_listed_prev;
		//Here is qty updateding on orderdeatil
		$sql='UPDATE orderdetail SET confirmedstatus=0,quantity='.$qty.' WHERE orderdetailid='.$id;
		mysql_query($sql);		
		
		$qu=mysql_query("select totalfinal,supplierid from `order` where orderid='$ordr_id'");
		$row_fetch=mysql_fetch_array($qu);
		$total_order_cost_now=$row_fetch['totalfinal']+$price_change;
		//Updating price in parent order table
		
		mysql_query("update `order` set totalfinal='$total_order_cost_now',reqdeldt='$req_date',confirmeddeliverydate='$req_date',totalprice='$total_order_cost_now',confirmationstatus='0' where orderid='$ordr_id'");
		
	}	
	$ordr_id=str_pad($ordr_id,6, '0',STR_PAD_LEFT);
	$message="your order DBAO".$ordr_id." has been updated";
	$subject='DBAO'.$ordr_id.' order has been update';
	
	
	//curl_post($email_supplier,$subject,$message);
	$customer_id=get_order_customer($ordr_id);
	$address=get_customer_address($customer_id);
	$name=get_supplier_name_for_mail($row_fetch['supplierid']);
	$cust_name=get_customer_name_em($customer_id);
	$line_item_detail=get_order_deatil_information($ordr_id);
	echo $name."^^^".$req_date."^^^".$cust_name;
	curl_post($email_supplier,$subject,$address,$ordr_id,$total_order_cost_now,$req_date,$name,$customer_id,$cust_name,$line_item_detail);
	$sup_id=$row_fetch['supplierid'];
	send_order_alert_supUser($sup_id,$email_supplier,$subject,$address,$ordr_id,$total_order_cost_now,$req_date,$name,$customer_id,$cust_name,$line_item_detail);
	
}

function curl_post($email_to,$subject,$address,$Oid,$t_price,$date_of_deleivery,$sname,$cust_id,$customer_name,$line_item_detail)
	{
		
		$data_string = "address=".$address."&email_to=".$email_to."&subject=".$subject."&order_no=".$Oid."&price=".$t_price."&d_day=".$date_of_deleivery."&supplier_name=".$sname."&cust_name=".$customer_name."&cust_id=".$cust_id."&line_item=".$line_item_detail;
		$ch = curl_init('http://104.131.176.201/PHPMailer-master/examples/supplier_po_email.php');                                                               
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
		//curl_setopt($ch, CURLOPT_HTTPHEADER,array("Content-Type : text","Content-lenght:".strlen($data_string)));  
		$result = curl_exec($ch);
	}

function get_supplier_email($id)
{
	$query=mysql_query("select email from supplier where supplierid=(SELECT supplierid FROM `order` where orderid=$id)");
	$row=mysql_fetch_assoc($query);
	return $row['email'];
}

function send_order_alert_supUser($sup_id,$email_to,$subject,$address,$Oid,$t_price,$date_of_deleivery,$sname,$cust_id,$customer_name,$line_item_detail)
{
	//Here is query for getting sales user of supplier
	$query_result=mysql_query("select salesuser.username,`user`.defaultnotification,`user`.phone from salesuser,user where supplierid='$sup_id' and `salesuser`.userid=`user`.userid");
	
	// Check if there is sales user for this supplier
	if(mysql_num_rows($query_result)!=0)
	{	
		//loop for sending mail/push notification according to preferences
		while($row=mysql_fetch_assoc($query_result))
		{
			//Check preferences if phone
			$email_to=$row['username'];
			curl_post($email_to,$subject,$address,$Oid,$t_price,$date_of_deleivery,$sname,$cust_id,$customer_name,$line_item_detail);		
		}
	}	
}

?>