 <?
	include "connection.php";
	$catid = $_GET['id'];
	$sql = "SELECT * FROM brand WHERE manufid='$catid' ";
	echo "<option value=''>Select</option>";
	$result = mysql_query($sql);
	while($row=mysql_fetch_array($result)){
		echo "<option value='".$row['brandid']."'>".$row['brandname']."</option>";
	}
?>