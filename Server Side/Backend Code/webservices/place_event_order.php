<?php
include "dbcon.php";
$pro_data =stripslashes($_POST['pro_data']);
$customer_id = trim($_POST['customer']);
$event_id = $_POST['id'];
$supplier = $_POST['supplier'];

$jso = stripslashes($pro_data);
$arr = json_decode($jso, true);

$sql = "INSERT INTO promotionaleventusage(customerid, eventid, usedatetime, supplierid, orderactivestatus, confirmeddeliverydate, orderstatus, receiveddeliverydate, receiveedstatus)VALUES ('$customer_id', '$event_id', 'NOW()', '$supplier', '1', '', '0', '', '0')";
mysql_query($sql);

		$query=mysql_query("select MAX(eventusageid) from `promotionaleventusage`");
		$row=mysql_fetch_array($query);
		$orderId=$row['MAX(eventusageid)'];
		
	for($i=0;$i<sizeof($arr);$i++){
		$pid = $arr[$i]['id'];
		$qty = $arr[$i]['qty'];
		$sql = "INSERT INTO  promotionalusagedetail(usageid, productid, quantity) VALUES ('$orderId', '$pid', '$qty');";
		mysql_query($sql);
		
	}
	
echo $event_id;
?>