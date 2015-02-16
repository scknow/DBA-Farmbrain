<?php
include "dbcon.php";
include "function.php";
$pro_data =stripslashes($_POST['pro_data']);
$customer_id = trim($_POST['customer']);

$sql = "SELECT * FROM customer WHERE customerid=".$customer_id;
$result = mysql_query($sql);
$str_line_item='';

$row = mysql_fetch_array($result);
$customergroup = $row['customergroupid'];

$jso = stripslashes($pro_data);
$arr = json_decode($jso, true);

for($i=0;$i<sizeof($arr);$i++)
{
	$supplierid = $arr[$i]['supplier'];
	$totalprice = $arr[$i]['price'];
	$discount = $arr[$i]['discount'];
	$req_delevry_date = $arr[$i]['rqdlt'];
	$t_saving = $arr[$i]['saving'];
	
	// $req_date=explode("/",$req_delevry_date_slash);		
	// $req_delevry_date=$req_date[2].'-'.$req_date[0].'-'.$req_date[1];
	
	$supplier_email=get_supplier_email($supplierid);
	$phone_number=get_supplier_phone_number($supplierid);
	$query=mysql_query("select MAX(orderid) from `order`");
	$row=mysql_fetch_array($query);
	$orderId=($row['MAX(orderid)'])+1;
	$orderjson[]=$orderId;
	
	$sql = "INSERT INTO `order`(orderid,supplierid, suppliername, creationtime, customerid, customername, reqdeldt, notes, active, totalprice,totalfinal, confirmeddeliverydate, confirmationstatus, totalpriceconfirmed, totaldiscountconfirmed, totalfinalordered, receiveddeliverydate, receivestatus,totaldiscount,total_saving) VALUES('$orderId','$supplierid','',NOW(), '$customer_id', '','$req_delevry_date', 'notes', '1', '$totalprice','$totalprice', '$req_delevry_date', '0', '0', '0', '', '', '0','$discount','$t_saving')";
	mysql_query($sql);
	echo mysql_error();
	
	$subject='#DBAO'.$orderId.' has  been placed to you';
	$messgage_to_supplier="New order has been placed to you";
	$name=get_supplier_name_for_mail($supplierid);
	$address=get_customer_address($customer_id);
	$cust_name=get_customer_name_em($customer_id);
	//$default_notification=get_supplier_notification($supplierid);
	
	
	for($j=0;$j<sizeof($arr[$i]['pid']);$j++)
	{
		$pid=$arr[$i]['pid'][$j];
		$qty=$arr[$i]['qty'][$j];
		$rpid=implode(",",$arr[$i]['rpid']);
		$price=$arr[$i]['pris'][$j];
		$rebate=$arr[$i]['rebate'][$j];
		$discount=$arr[$i]['idisc'][$j];
		
		$sql="INSERT INTO `orderdetail` (`orderid`, `productid`, `quantity`, `substituteproductids`, `listedprice`,`discount`, `finalprice`, `confirmedquantity`, `substitutewithproductid`, `confirmedstatus`, `confirmedcomments`, `confirmedlistedprice`, `confirmeddiscount`, `confirmedfinalprice`, `receivedquantity`) VALUES ('$orderId','$pid','$qty','$rpid', '$price','$discount','$price', '0', '0', '0', '0', '0', '0', '0', '0')";
		mysql_query($sql);
		echo mysql_error();			
		if($rebate!=0)
		{
			$value=$price*$qty;
			$rebate_value=get_rebate_value($rebate,$value);
			$sql=mysql_query("INSERT INTO `rebate` (`orderid`,`productid`,`supplierid`,`customerid`,`quantity`,`rebatevalue`,`rebatedate`) VALUES ('$orderId','$pid','$supplierid','$customer_id','$qty','$rebate_value',NOW())");
		}
	
	}
	$line_item_detail=get_order_deatil_information($orderId);
	
	// Phone number of supplier	
	preg_match_all('!\d+!', $phone_number, $sup_number);				
	send_msg($sup_number,$subject);
	// Send email to supplier here
	curl_post($supplier_email,$subject,$address,$orderId,$totalprice,$req_delevry_date,$name,$customer_id,$cust_name,$line_item_detail);
	send_order_alert_supUser($supplierid,$supplier_email,$subject,$address,$orderId,$totalprice,$req_delevry_date,$name,$customer_id,$cust_name,$line_item_detail)
	
	
}

//For getting rebate values
function get_rebate_value($id,$value)
{
	$query=mysql_query("select * from promotion where promotionid='$id'");
	$row=mysql_fetch_assoc($query);
	if($row['percentageoff']!=0)
	{
		$percent_off=$row['percentageoff'];
		return ($value*$percent_off)/100;
	}
	else
	{
		return $row['value_off'];
	}
	
}
//THis is for getting supplier email for sending email
function get_supplier_email($id)
{
	$query=mysql_query("select email from supplier where supplierid='$id'");
	$row=mysql_fetch_assoc($query);
	return $row['email'];
}

// Here is curl for sending email from mailer
function curl_post($email_to,$subject,$address,$Oid,$t_price,$date_of_deleivery,$sname,$cust_id,$customer_name,$line_item_detail)
{
	//$email_to='jatin1414@gmail.com';
	$data_string = "address=".$address."&email_to=".$email_to."&subject=".$subject."&order_no=".$Oid."&price=".$t_price."&d_day=".$date_of_deleivery."&supplier_name=".$sname."&cust_name=".$customer_name."&cust_id=".$cust_id."&line_item=".$line_item_detail;
	$ch = curl_init('http://104.131.176.201/PHPMailer-master/examples/supplier_po_email.php');                                
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
	//curl_setopt($ch, CURLOPT_HTTPHEADER,array("Content-Type : text","Content-lenght:".strlen($data_string)));  
	$result = curl_exec($ch);
}
// This is twillo program for sending SMS to customer when order placed.
function send_msg($phone_number,$subject)
{
	$account_sid = 'AC035561d467465542452222e1ab001ede'; 
	$auth_token = '3b32a3112bd6fd0cb45ac946e864ec05';
	$client = new Services_Twilio($account_sid, $auth_token); 
	
	
	$client->account->messages->create(array( 
	'To' => $phone_number, 
	'From' => "+18624389895", 
	'Body' => $subject,   
	));
}
// Getting phone number for supplier
function get_supplier_phone_number($sup_id)
{
	$query=mysql_query("select phone from supplier where supplierid='$id'");
	$row=mysql_fetch_assoc($query);
	return $row['phone'];
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

//echo $orderId;
echo json_encode($orderjson);
?>