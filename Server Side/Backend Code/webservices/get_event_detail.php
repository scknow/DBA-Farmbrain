<?php
include "dbcon.php";
$id=$_POST['eid'];

$sql = "SELECT * FROM promotionaleventdetail WHERE eventid='$id'";
$result=mysql_query($sql);
$json = array();
while($row=mysql_fetch_assoc($result)){
	$json[] = $row;
}
echo json_encode($json);

?>