 <?
	include "connection.php";
	$catid = $_GET['id'];
	$str='';
	$sql = "SELECT * FROM brand WHERE brandid='$catid' ";
	$str=$str."<option value=''>Select</option>";
	$result = mysql_query($sql);
	while($row=mysql_fetch_array($result)){
		$str=$str."<option value='".$row['brandid']."'>".$row['brandname']."</option>";
	}
	echo $str;
?>