<?php
/**
 * Database config variables
 */
	$host="localhost"; // Host name 
	$username="root"; // Mysql username 
	$password="DBAdev1!"; // Mysql password 
	$db_name="dbadev"; // Database name 

	// Connect to server and select databse.
	mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
	mysql_select_db("$db_name")or die("cannot select DB");
	$DB_HOST='dbadev.db.10575267.hostedresource.com';
	$DB_USER='dbadev';
	$DB_PASSWORD='DBAd3v3lopment!';
	$DB_DATABASE='dbadev';
/*
 * Google API Key
 AIzaSyAvea1fBjdr1NHmGAvHk9AmJyWXDqyF6CY
 */
define("GOOGLE_API_KEY", "AIzaSyBLTLly3EH0nr1tjKPSw560nJYmbLTdO6Q"); // Place your Google API Key
?>