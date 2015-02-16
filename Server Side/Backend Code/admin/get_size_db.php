<? 
include "header.php";
include "connection.php";
$row= mysql_query('SELECT table_schema dbadev,Round(Sum(data_length + index_length) / 1024 / 1024, 1) "DB Size in MB" 
FROM   information_schema.tables 
GROUP  BY table_schema'); 
$count=mysql_fetch_array($row);

print_r($count['DB Size in MB']);
?>