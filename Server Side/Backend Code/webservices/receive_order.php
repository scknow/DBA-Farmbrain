<?php
include "dbcon.php";
include "function.php";

$id = $_GET['oid'];
$action = $_GET['action'];

if($action=='whole')
{
	$jsn_all=stripslashes($_GET['jsn']);
	$jsn_coming=json_decode($jsn_all,true);
	$dname=$_REQUEST['dname'];
	for($i=0;$i<sizeof($jsn_coming);$i++)
	{
		$detailid=$jsn_coming[$i]['id'];
		$qty_updated=$jsn_coming[$i]['qty'];
		$sql_query=mysql_query("select * from orderdetail where orderdetailid='$detailid' and receivedquantity=0");
		if(mysql_num_rows($sql_query)!=0)
		{
			$sql = "UPDATE `orderdetail` SET receivedquantity='$qty_updated' WHERE orderdetailid='$detailid' ";
			mysql_query($sql);
		}				
	}
	
	$sql = "UPDATE `order` SET receivestatus='1', receiveddeliverydate=NOW(),drivername='$dname' WHERE orderid='$id' ";
	mysql_query($sql);
	$sup_id=supplier_id_for_order($id);
	$sup_email=supplier_email($sup_id);
	$ordr_id_fo=str_pad($id,6, '0',STR_PAD_LEFT);
	$subject='Customer Delivery Receipt Confirmation for PO# DBAO'.$ordr_id_fo;
	$msg=get_receipt_detail_of_order($id);
	curl_post($sup_email,$subject,$id,$msg);
	send_order_alert_supUser($sup_id,$sup_email,$subject,$id,$msg);
	
	$name=get_supplier_name_for_mail($sup_id);
	$cust_name=get_customer_name_em($customer_id);
	echo $name;
	
}

else if($action=='item')
{
	$qty = $_GET['qty'];
	$sql = "UPDATE `orderdetail` SET receivedquantity='$qty' WHERE orderdetailid='$id'";
	mysql_query($sql);
	$receipt_detail=get_order_detail_item($id);
	$subject='Customer Delivery Receipt Confirmation for PO'.$id;
	//curl_post('jatin1414@gmail.com',$subject,$id,$receipt_detail);
}

else if($action=='cancel')
{
	$sql = "UPDATE `order` SET active='0' WHERE orderid='$id' ";
	mysql_query($sql);
}



function get_receipt_detail_of_order($id)
{
	$query=mysql_query("select customerid,receivedquantity,quantity,receiveddeliverydate,reqdeldt,totalfinalordered,drivername,totalfinal from orderdetail,`order` where orderdetail.orderid=$id AND orderdetail.orderid =  `order`.orderid ");
	
	
	$row=mysql_fetch_assoc($query);
	$short_item=find_short($id);
	
	$custm_id=$row['customerid'];
	$supplier_name=get_supplier_name_for_mail($row['supplierid']);
	
	
	if($row['receiveddeliverydate']==$row['reqdeldt'])
	{
		$deleivry_status='on-time';
	}
	else
	{
		$deleivry_status='Late';
	}
	$sql=mysql_query("select * from orderdetailfeedback where orderid='$id'");
	$rows=mysql_fetch_assoc($sql);
	
	$querys=mysql_query("select * from customer where customerid='$custm_id'");
	$rows_query=mysql_fetch_assoc($querys);
	
	$ordr_id=str_pad($id,6, '0',STR_PAD_LEFT);
	
	$line_detail=get_order_receipt_deatil($id);
	
	$msg='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>DBA Farmbrain</title><style>*{margin:0px;}*{padding:0px;}body {margin: 0; padding: 0; min-width: 100%!important; font-family:calibri; font-size:14px;}</style></head><body><table style="width: 100%; float: left; background: #f3f3f3; box-shadow: 0 1px 2px rgb(160, 160, 160);"><tr><td><img src="images/fb.png" style="padding: 12px 6px; float: left; width: 80px;"/><h1 style="width: auto; float:left; padding-top: 31px; font-size: 30px; color: #707070;">DBA</h1></td></tr></table><table class="table-full" style="width: 100%; float: left; margin-top: 25px;"><tr><td><big style="font-size: 14px; padding: 0 0 0 10px; font-weight: bold; color: black; display: block;">'.$supplier_name.'</big><p style="padding: 10px;">We are contacting you to let you know that PO #DBAO'.$ordr_id.'  has been processed. The details are listed below for your convenience.</p></td></tr></table><table class="table-full" style="width: 94%;float: left;margin: 25px 3% 0;background: #F1F6CA;border: 1px solid silver;"><tr><td><h2 style="padding:10px; border-bottom: 1px solid silver;">'.$rows_query["businessname"].' </h2></td></tr><tr><td><h3 style="padding:10px;">Delivery location:</h3></td></tr><tr><td style="width: 100%;float: left;"><b style="width:50%; float: left; clear: both; padding-left:10px; font-weight: normal;">'.$rows_query["businessname"].'</b></td></tr><tr><td style="width: 100%;float: left;"><b style="width: 50%; float: left; clear: both; padding-left:10px; font-weight: normal;">'.$rows_query["billtoaddress1"].'</b></td></tr><tr><td style="width: 100%;float: left;"><b style="width: 50%; float: left; clear: both; padding-left:10px; font-weight: normal;">'.$rows_query["billtocity"].','.$rows_query["billtostate"].' '.$rows_query["billtozip"].'</b></td></tr><tr><td><h3 style="padding:10px;">Receipt Details:</h3></td></tr><tr><td style="width: 100%;float: left;"><b style="width: 50%; float: left; clear: both; padding-left:10px; font-weight: normal;">Items shorted: '.$short_item.'</b></td></tr><tr><td style="width: 100%;float: left;"><b style="width: 50%; float: left; clear: both; padding-left:10px; font-weight: normal;">Damages<img src="antloc.com/dba/webservices/uploads/'.$rows['pic'].'" style="width:30px; float:left;" /> </b></td></tr><tr><td style="width: 100%;float: left;"><b style="width: 50%; float: left; clear: both; padding-left:10px; font-weight: normal;">Notes captured by customer:'.$rows['message'].'</b></td></tr><tr><td style="width: 100%;float: left;"><b style="width: 50%; float: left; clear: both; padding-left:10px; font-weight: normal;">Delivery Status : '.$deleivry_status.'</b></td></tr><tr><td style="width: 100%;float: left;"><b style="width: 50%; float: left; clear: both; padding-left:10px; font-weight: normal;">Customer"s recorded amount:$'.format_change($row['totalfinal']).'</b></td></tr><tr><td style="width: 100%;float: left;"><b style="width: 50%; float: left; clear: both; padding-left:10px; font-weight: normal;">Driver signature:'.$row['drivername'].'</b></td></tr><br><br><tr>'.$line_detail.'</tr><tr><td><p style="width:98%; float:left; margin-top:25px; padding-left:10px;">If you have any questions, please contact '.$rows_query["businessname"].'</p></td></tr><tr><td><img src="../images/fb.png" style="float:left; width:50px; padding:12px 6px;" /></td></tr><tr><td><p style="padding:10px;">Technical issue? We"re here to help! <b>Contact us anytime.</b><a href="#">SKC Support contact</a></p></td></tr><table style="width: 100%; float: left; margin: 20px 0 10px;"><tr><td style="text-align: center; font-size: 12px; font-weight: 700; color: rgb(33, 32, 32);">Legal / technical / contact info required?</td></tr></table><table style="width: 100%; background: rgb(71, 71, 71);"><tr><td style="padding: 10px; color: white; font-size: 11px;">The email address linked to your DBA account is <namename123@internets.com>. <u>Update your email preferences</u> or <u>unsubscribe</u>. Note that even if you unsubscribe, we will send certain account-related emails, such as purchase details or requests for password resets. Have questions? We"re here to help! <u>Contact us anytime</u></td></tr></table></body></html>';
	
	return $msg;
}

//echo mysql_error();

function curl_post($email_to,$subject,$Oid,$de_tail)
	{
		//$email_to='jatin1414@gmail.com';		
		$data_string = "email_to=".$email_to."&subject=".$subject."&order_no=".$Oid."&detail_re=".$de_tail;
		
		$ch = curl_init('http://104.131.176.201/PHPMailer-master/examples/receive_ordr_mail.php');                                                               
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
		//curl_setopt($ch, CURLOPT_HTTPHEADER,array("Content-Type : text","Content-lenght:".strlen($data_string)));  
		$result = curl_exec($ch);
	}

function send_order_alert_supUser($sup_id,$email_to,$subject,$Oid,$de_tail)
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
			curl_post($email_to,$subject,$Oid,$de_tail);		
		}
	}	
}

?>