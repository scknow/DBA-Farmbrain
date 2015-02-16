<?php
	include "dbcon.php";
	
	$base64img=$_POST['img'];
	$message=$_POST['mg'];
	$detailId=$_POST['id'];
	
	$image_name=upload_file($base64img);
	$orderid=get_order_id($detailId);
	mysql_query("INSERT INTO orderdetailfeedback (pic,message,orderdetailid,orderid) VALUES('$image_name','$message',$detailId,$orderid)");
	function upload_file($base64img)
	{
		$image_name=rand(1,100000);
		$image_name_new = $image_name;
		define('UPLOAD_DIR', 'uploads/');
		$base64img = str_replace('data:image/jpeg;base64,', '', $base64img);
		$data = base64_decode($base64img);
		$file = UPLOAD_DIR . $image_name_new.'.jpg';
		file_put_contents($file, $data);		
		return $image_name_new.'.jpg';
	}
	
	function get_order_id($detail_id)
	{
		$query=mysql_query("select orderid from orderdetail where orderdetailid='$detail_id'");
		$query_resp=mysql_fetch_array($query);
		return $query_resp['orderid'];
	}
?>