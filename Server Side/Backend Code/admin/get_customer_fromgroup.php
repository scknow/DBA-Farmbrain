 <?php
	include "connection.php";
	$gid = $_GET['id'];

	if($gid!='-1')
	{
		$sql = "SELECT * FROM customer WHERE customergroupid='$gid' ";
	}
	else
	{
		$sql = "SELECT * FROM customer";
	}
	$str= "<option value='-1'>All</option>";
	$result = mysql_query($sql);
	while($row=mysql_fetch_array($result)){
		$str.= "<option value='".$row['customerid']."'>".$row['businessname']."</option>";
	}
	echo $str;
?>