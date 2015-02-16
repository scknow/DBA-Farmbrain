<?php
include "dbcon.php";
include "function.php";
$pro_data =stripslashes($_POST['pro_data']);
$customer_id = trim($_REQUEST['customer']);
//$customer_id = 1;
$grp_id=get_customer_grp_id($customer_id);
$sql = "SELECT * FROM `orderprofile` WHERE (customerid='-1' OR customerid='$customer_id') AND (customergroup='-1' OR customergroup='$grp_id')";

$result = mysql_query($sql);
echo mysql_error();
$json = array();
$select_query=mysql_query("select * from profile_setting where customer_id='$customer_id'");
$count=mysql_num_rows($select_query);
while($row1=mysql_fetch_assoc($select_query))
		{
			$customer_profile_id=$row1['default_profile_id'];
			$customer_active_id=$row1['active_profile'];
			$active_profile_id=explode(",",$customer_active_id);
		}
$i=0;
while($row=mysql_fetch_assoc($result))
{
	$json[$i] = $row;
	$profile_id=$row['id'];
	if($count==0)
	{
		$json[$i]['active']=0;
		$json[$i]['defaultp']=0;	
	}
	
	else
	{
		
			if($customer_profile_id==$profile_id)
			{
				$json[$i]['defaultp']=1;
			}
			else
			{
				$json[$i]['defaultp']=0;
			}
			if (in_array($profile_id,$active_profile_id))
			{
				$json[$i]['active']=1;
			}
			else{
				$json[$i]['active']=0;
			}
	}
	$i++;
}

// echo "<pre>";
// print_r($json);
echo json_encode($json);
?>