<?php
	include "connection.php";
	//declare array to hold result
	$arr_names = array();
	
	//get zip
	$zipcode=$_GET['zip'];
	
	//$length=strlen($zipcode);
	$length=preg_match('/\d{5}/', $zipcode);
	
	if($length != 1)
	{
		echo 0;
	}
	else
	{
		//get data from database
		$sql="SELECT * from zipcodes where ZIP='$zipcode'";
		$retval = mysql_query($sql);
		if(! $retval )
		{
			die('Could not enter data: ' . mysql_error());
		}
		
		else if(mysql_num_rows($retval) >= 1)
		{
			while($row = mysql_fetch_array($retval))
			{
				array_push($arr_names,$row['ZIP']);
				array_push($arr_names,$row['City']);
				array_push($arr_names,$row['State']);
			}
			$sending_json = json_encode($arr_names);
			echo $sending_json;
		}
		else
		{
			echo "2";		
		}
	}
	
	
?>