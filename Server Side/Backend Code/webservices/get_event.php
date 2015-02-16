<?php
include "dbcon.php";
$s_date = date("Y-m-d");
//$customer_id=trim($_REQUEST['customer_id']);
$customer_id=1;

//$sql="SELECT promotionalevent.eventid,promotionalevent.eventname,promotionalevent.startdate,promotionalevent.enddate,promotionalevent.customergiveaway,promotionalevent.supplierchargeable,promotionalevent.maxquantity FROM promotionalevent,promotionaleventusage where promotionalevent.startdate <= '$s_date' AND promotionalevent.enddate >= '$s_date' and promotionaleventusage.customerid!='$customer_id' GROUP BY promotionalevent.eventid";

$sql="SELECT promotionalevent.eventid,promotionalevent.eventname,promotionalevent.startdate,promotionalevent.enddate,promotionalevent.customergiveaway,promotionalevent.supplierchargeable,promotionalevent.maxquantity,promotionaleventusage.customerid FROM promotionalevent LEFT JOIN promotionaleventusage
ON promotionalevent.`eventid`=promotionaleventusage.eventid where promotionalevent.startdate <= NOW() AND promotionalevent.enddate >= NOW() GROUP BY promotionalevent.eventid";

$result = mysql_query($sql);

$json = array();

while($row=mysql_fetch_assoc($result))
{	
	if($row['customerid']=='' || $row['customerid']!=$customer_id)
	{
		$json[] = $row;
	}
}

echo json_encode($json);
?>