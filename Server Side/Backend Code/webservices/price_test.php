<?php
include "dbcon.php";
$pid = $_GET['pid'];
$cid = $_GET['customer'];
$gid = 3;
$json = array();
$s_date = date("Y-m-d");
$k=0;
$sql = "SELECT supplierid, price, productid, minodrqty, incrementodrqty FROM pricing WHERE datefrom <= NOW() AND dateto >= DATE_SUB(NOW(), INTERVAL 7 DAY) ORDER BY price ASC";
$result = mysql_query($sql);
echo json_encode($json);
?>
