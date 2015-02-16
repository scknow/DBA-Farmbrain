<?
include "connection.php";

if($_POST['action']=='sup'&& $_POST['action1']=='city')
{
	$row=mysql_query("select DISTINCT(city) from supplier");
}
else if($_POST['action']=='sup'&& $_POST['action1']=='state')
{
	$row=mysql_query("select DISTINCT(state) from supplier");
}
else if($_POST['action']=='custome'&& $_POST['action1']=='state')
{
	$row=mysql_query("select DISTINCT(shiptostate) from customer");
}
else if($_POST['action']=='custome'&& $_POST['action1']=='city')
{
	$row=mysql_query("select DISTINCT(shiptocity) from customer");
}
while($ro=mysql_fetch_assoc($row))
{
	$arr[]=$ro;
}
echo json_encode($arr);
?>
