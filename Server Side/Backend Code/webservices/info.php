<?php
error_reporting(E_ALL);
require('Twilio.php');
$account_sid = 'AC035561d467465542452222e1ab001ede'; 
$auth_token = '3b32a3112bd6fd0cb45ac946e864ec05'; 
$client = new Services_Twilio($account_sid, $auth_token); 
 
echo $client->account->messages->create(array( 
	'To' => "+16617273766", 
	'From' => "+18624389895", 
	'Body' => "Hello! Test message.",   
));

echo phpinfo();
?>
