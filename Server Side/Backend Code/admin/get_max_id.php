<?php
	include "connection.php";
	$tbl_name="help_support";
	$sql="SELECT MAX( id ) FROM $tbl_name";
	$result=mysql_query($sql);
	$temp=mysql_fetch_array($result);
	$max_id = $temp['MAX( id )'] +1;
	echo $TINUM="TCKT".($max_id+100000);
?>