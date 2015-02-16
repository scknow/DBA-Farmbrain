<?php
include "dbcon.php";
include "function.php";
$pro_data =stripslashes($_POST['pro_data']);
$customer_id = trim($_POST['customer']);

$sql = "SELECT * FROM customer WHERE customerid=".$customer_id;
$result = mysql_query($sql);


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
		curl_post($supplier_email,$subject,$address,$orderId,$totalprice,$req_delevry_date,$name,$customer_id,$cust_name);
		
		for($j=0;$j<sizeof($arr[$i]['pid']);$j++)
		{
			$pid=$arr[$i]['pid'][$j];
			$qty=$arr[$i]['qty'][$j];
			$rpid=implode(",",$arr[$i]['rpid'][$j]);
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
		
		
	}

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
	function get_supplier_email($id)
	{
		$query=mysql_query("select email from supplier where supplierid='$id'");
		$row=mysql_fetch_assoc($query);
		return $row['email'];
	}
	
	function curl_post($email_to,$subject,$address,$Oid,$t_price,$date_of_deleivery,$sname,$cust_id,$customer_name)
	{
		//$email_to='jatin1414@gmail.com';
		$data_string = "address=".$address."&email_to=".$email_to."&subject=".$subject."&order_no=".$Oid."&price=".$t_price."&d_day=".$date_of_deleivery."&supplier_name=".$sname."&cust_name=".$customer_name."&cust_id=".$cust_id;
		$ch = curl_init('http://geri.in/farmly/PHPMailer-master/examples/supplier_po_email.php');                                                               
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
		//curl_setopt($ch, CURLOPT_HTTPHEADER,array("Content-Type : text","Content-lenght:".strlen($data_string)));  
		$result = curl_exec($ch);
	}

	//echo $orderId;
echo json_encode($orderjson);
?>