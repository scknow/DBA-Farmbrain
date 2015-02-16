<?php
include "connection.php";

$data = $_POST['d'];
$data = json_decode($json, true);

echo $data;

?>