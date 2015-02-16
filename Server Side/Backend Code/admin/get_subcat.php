 <?
	include "connection.php";
	$catid = $_GET['id'];
	$sql = "SELECT * FROM productsubcategory WHERE productcategoryid='$catid' ";
	//echo $sql;
	$str = "<option value=''>Select</option>";
	$result = mysql_query($sql);
	while($row=mysql_fetch_array($result)){
		$str = $str."<option value='".$row['productsubcategoryid']."'>".$row['productsubcategoryname']."</option>";
	}
	echo $str;
?>