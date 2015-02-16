<?php
		include "connection.php";
		$s_date=$_POST['sd'];
		$e_date=$_POST['ed'];
		$sql="SELECT supplierid, businessname FROM supplier";
		$result = mysql_query($sql);
		$sup_arr = array();
		while ($row = mysql_fetch_array($result))
		{
			$sup_arr[$row['supplierid']] = $row['businessname'];
		}
		$sql="SELECT productid, productlabel FROM productportfolio";
		$result = mysql_query($sql);
		$pro_arr = array();
		while ($row = mysql_fetch_array($result))
		{
			$pro_arr[$row['productid']] = $row['productlabel'];
		}
		if(!isset($_SESSION['supplierid'])){
			// $sql="SELECT * FROM promotion";
			if(($s_date!='')&&($e_date!=''))
			{
				$sql="SELECT * FROM promotion where datefrom >= '$s_date' AND dateto<='$e_date';";
			}
			else if(($s_date!='')&&($e_date==''))
			{
				$sql="SELECT * FROM promotion where datefrom >= '$s_date'";
			}
			else if(($s_date=='')&&($e_date!=''))
			{
				$sql="SELECT * FROM promotion where dateto <='$e_date'";
			}
			else
			{
				$sql="SELECT * FROM promotion";
			}
		}else{
			$supplierid = $_SESSION['supplierid'];
			$sql="SELECT * FROM promotion WHERE supplierid=".$supplierid;
		}
		$result = mysql_query($sql);
		while ($row = mysql_fetch_array($result))
		{
			$id=$row['promotionid']."$$"."promotionid"."$$".'promotion';
			$line_id=$row['promotionid'];
			echo "<tr id='$line_id'>";
			echo "<td onclick=checked_entries('".$row['promotionid']."')><input type='checkbox'/></td>";
			$max_id=str_pad($row['promotionid'],6, '0',STR_PAD_LEFT);
			echo "<td><a href='#' onclick=product_edit('$id')>DBAES{$max_id}</a></td>";
			echo "<td>{$pro_arr[$row['productid']]}</td>";
			echo "<td>".$sup_arr[$row['supplierid']]."</td>";
			echo "<td>{$row['type']}</td>";
			echo "<td>".$row['datefrom']."</td>";
			echo "<td>".$row['dateto']."</td>";
			echo "<td>".$row['minimumorderquantity']."</td>";
			echo "<td>".$row['percentageoff']."</td>";
			echo "<td>".$row['valueoff']."</td>";
			echo "<td>".$row['promotiontext']."</td>";
			echo "<td style='display:none;'>{$row['supplierid']}</td>";
			echo "<td style='display:none;'>{$row['productid']}</td>";
			echo "</tr>";
		}
?>