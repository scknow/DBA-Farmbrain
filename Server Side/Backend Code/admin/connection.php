<?php
	$host="localhost"; // Host name 
	$username="root"; // Mysql username 
	$password="DBAdev1!"; // Mysql password 
	$db_name="dbadev"; // Database name 

	// Connect to server and select databse.
	$link=mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
	mysql_set_charset('utf8',$link);
	mysql_select_db("$db_name")or die("cannot select DB");
?>