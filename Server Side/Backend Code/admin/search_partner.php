<?php 
include "connection.php";
$term=$_GET["term"];

$query2=mysql_query("SELECT * FROM salesuser where username LIKE '$term%'");
$sql = "SELECT * FROM user where username LIKE '$term%'";
$query1=mysql_query($sql);

if(mysql_num_rows($query2)!=0 || mysql_num_rows($query1)!=0)
{
    echo 1;
}
else{
	echo 0;
}

?>