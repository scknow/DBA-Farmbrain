<?php
include "dbcon.php";
//$pro_data =stripslashes($_POST['pro_data']);
$customer_id = $_POST['orderid'];
//$customer_id = 1;
$sql = "SELECT * FROM `orderdetail` WHERE orderid=".$customer_id;

$result = mysql_query($sql);
echo mysql_error();
$json = array();
while($row=mysql_fetch_array($result))
{
	$json[] = $row;
}
echo json_encode($json);
//echo $customer_id;
?>