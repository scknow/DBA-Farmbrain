<?php
session_start();
include "connection.php";
$id = $_GET['d'];
$div_str='';
$pieces = explode("$$", $id);
$sql = "SELECT * FROM $pieces[2] WHERE $pieces[1]='$pieces[0]'";
$result = mysql_query($sql);
while($val = mysql_fetch_array($result))
{	
	$data['name'][]=$val['attributetype'];
	$data['attributeId'][]=$val['attributeId'];
	$data['attributepic'][]=$val['attributepic'];
}
echo json_encode($data);
?>