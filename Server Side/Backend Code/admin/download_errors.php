<?php
$header = urldecode($_REQUEST["header"]);
$out = urldecode($_REQUEST["data"]);
header("Content-type: text/x-csv");
header("Content-Disposition: attachment; filename=Error_cat_".time().".csv");
echo $header."\n".$out;// output
exit;
?>