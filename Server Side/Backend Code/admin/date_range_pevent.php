<?php
	include "connection.php";
	$s_date=$_POST['sd'];
	$e_date=$_POST['ed'];
	$sql="SELECT manufid, manufname FROM manufacturer";
	$result = mysql_query($sql);
	$pro_arr = array();
	while ($row = mysql_fetch_array($result))
	{
		$manu_arr[$row['manufid']] = $row['manufname'];
	}
	if(($s_date!='')&&($e_date!=''))
	{
		$sql="SELECT * FROM promotionalevent where startdate >= '$s_date' AND enddate <= '$e_date';";
	}
	else if(($s_date!='')&&($e_date==''))
	{
		$sql="SELECT * FROM promotionalevent where startdate >= '$s_date'";
	}
	else if(($s_date=='')&&($e_date!=''))
	{
		$sql="SELECT * FROM promotionalevent where enddate <= '$e_date'";
	}
	else
	{
		$sql="SELECT * FROM promotionalevent";
	}
	// $sql="SELECT * FROM promotionalevent";
	//echo $sql;
	$result = mysql_query($sql);
	while ($row = mysql_fetch_array($result))
	{
		$id=$row['eventid']."$$"."eventid"."$$".'promotionalevent';
		$line_id=$row['eventid'];
		echo "<tr id='$line_id'>";
		echo "<td onclick=checked_entries('".$row['eventid']."')><input type='checkbox'/></td>";
		$max_id=str_pad($row['eventid'],6, '0',STR_PAD_LEFT);
		echo "<td><a href='#' onclick=product_edit('$id')>DBAEM{$max_id}</a></td>";
		echo "<td>{$row['eventname']}</td>";
		echo "<td>".$row['startdate']."</td>";
		echo "<td>{$row['enddate']}</td>";
		echo "<td>".$row['customergiveaway']."</td>";
		echo "<td>".$row['maxquantity']."</td>";
		echo "<td>".$manu_arr[$row['supplierchargeable']]."</td>";
		echo "<td style='display:none;'>{$row['supplierchargeable']}</td>";
		echo "</tr>";
							}
?>