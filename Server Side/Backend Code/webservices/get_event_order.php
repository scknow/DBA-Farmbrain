<?php
include "dbcon.php";
$customer_id=trim($_REQUEST['customer']);

$sql="SELECT * FROM promotionaleventusage WHERE customerid='$customer_id'";


$result = mysql_query($sql);

$json = array();

while($row=mysql_fetch_assoc($result))
{	
	$json[] = $row;
}

echo json_encode($json);
?>