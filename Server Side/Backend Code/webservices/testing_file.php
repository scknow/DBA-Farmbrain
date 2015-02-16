<?php

$datefroms= date('Y/m/d',strtotime('-1 day',strtotime('2014-12-11')));
$curdate_n=date('Y/m/d');
$curdate=strtotime($curdate_n);
$mydate=strtotime($datefroms);

if($curdate > $mydate)
{
	echo "date has expired";
}
else
{
	echo "this is future date";
}
?>