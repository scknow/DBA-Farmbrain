<?php
	session_start();
	//retrieve session data
	include "connection.php";
	$cid=$_SESSION['id'];
	$tbl_name='help_support';
	$s_date=$_POST['sd'];
	$e_date=$_POST['ed'];
	
	if($_SESSION["superadmin"]==1)
	{
		if(($s_date!='')&&($e_date!=''))
		{
			$sql="SELECT * FROM $tbl_name where CRDAT >= '$s_date' AND CRDAT<='$e_date'";
		}
		else if(($s_date!='')&&($e_date==''))
		{
			$sql="SELECT * FROM $tbl_name where CRDAT >= '$s_date'";
		}
		else if(($s_date=='')&&($e_date!=''))
		{
			$sql="SELECT * FROM $tbl_name where CRDAT<='$e_date'";
		}
		else
		{
			$sql="SELECT * FROM $tbl_name";
		}
	}
	else
	{
		if(($s_date!='')&&($e_date!=''))
		{
			$sql="SELECT * FROM $tbl_name where CRDAT >= '$s_date' AND CRDAT<='$e_date' and CRTD_BY_ID='$cid'";
		}
		else if(($s_date!='')&&($e_date==''))
		{
			$sql="SELECT * FROM $tbl_name where CRDAT >= '$s_date' and CRTD_BY_ID='$cid'";
		}
		else if(($s_date=='')&&($e_date!=''))
		{
			$sql="SELECT * FROM $tbl_name where CRDAT<='$e_date' and CRTD_BY_ID='$cid'";
		}
		else
		{
			$sql="SELECT * FROM $tbl_name WHERE CRTD_BY_ID='$cid'";
		}
		
	}
	
	$str='';
	if($tbl_name=="help_support")
	{						
		$result = mysql_query($sql);
		//echo $sql;
		$i=1;
		while ($row = mysql_fetch_array($result))
		{
			$TINUM="TCKT".($row['id']+100000);
			$line_id=$row['id'];
			$str.="<tr id='$line_id'>";
			$str.="<td onclick=checked_entries('".$row['id']."')><input type='checkbox'/></td>";
			
			$str.="<td onclick=update_records('".$row['id']."');><a href='#'>".$TINUM."</a></td>";
			$str.="<td>".$row['CRTBY']."</td>";
			$str.="<td>".$row['CRDAT']."</td>";
			$str.="<td>".$row['TIDEC']."</td>";
			$str.="<td>".$row['TISTA']."</td>";
			$str.="<td>".$row['TIATO']."</td>";
			$str.="<td>".$row['TIPRI']."</td>";
			if($row['resolved_on']!=-1)
			{
				$str.= "<td>".$row['resolved_on']."</td>";
			}
			else
			{
				$str.="<td> </td>";
			}
			$str.="</tr>";
		}
	}
	echo $str;
?>
							
	
					  