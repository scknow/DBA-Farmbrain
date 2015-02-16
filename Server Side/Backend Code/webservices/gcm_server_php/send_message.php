<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

	include "config.php";
    include_once './GCM.php';
	//$regId = 'APA91bH4Pk7_uNfdAmD7u6zzs4hiKRDVFKB4SEtM9oEa1s8xQYIVwjiZpV1JC-X-3avJQxAPHTa_K8rLbpg2P6dlEqYVvv5I4BzDGFyP__63gnt9z6-hM4dXCPfl3wzvpwVbeW_fiHvtPX17KLzw01d-KJf5HKXEjdtPwyt9mI7RdM9qgmOl5pA';
	$message = $_REQUEST['msg'];
	$customerida = $_REQUEST['customerId_by'];    
	//echo "select notifyid from user where customerid=".$_POST['customerId_by'];	
	//echo "select notifyid,deviceOs from user where customerid=$customerida";
	$query=mysql_query("select notifyid,deviceOs from user where customerid=$customerida");
	while($row=mysql_fetch_array($query))
	{
		if($row['notifyid']!='' && $row['deviceOs']=='android')
		{
			$registatoin_ids[]=$row['notifyid'];
			//$registatoin_ids = array($regId);
			$gcm = new GCM();
			$message = array("message" => $_REQUEST['msg'],"title"=>'DBA');
			$result = $gcm->send_notification($registatoin_ids, $message); 
		}
		if($row['notifyid']!='' && $row['deviceOs']=='ios')
		{
				$deviceToken = $row['notifyid'];    
				//$deviceToken = $_POST['reg_id'];
				
				// Put your private key's passphrase here:
				$passphrase = 'satdmac2';
				
				
				// Put your alert message here:
				//$message = mysql_real_escape_string($_POST['message']);
				//$message="notification for phonegap";
				////////////////////////////////////////////////////////////////////////////////
				
				$ctx = stream_context_create();
				stream_context_set_option($ctx, 'ssl', 'local_cert', 'dbatestdeveck.pem');
				stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
				
				// Open a connection to the APNS server
				$fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err,
										   $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
				
				
				if (!$fp)
				exit("Failed to connect: $err $errstr" . PHP_EOL);
				
				
				//echo 'Connected to APNS' . PHP_EOL;
				
				// Create the payload body
				$body['aps'] = array(
									 'alert' => $message,
									 'sound' => 'default',
									 'from_user'=>'user',
									 'action'=>'subscribe',
									 'farmly_id'=>'1956504082'
									 );
				
				//openssl s_client -connect gateway.sandbox.push.apple.com:2195  -cert PushChatCert.pem -key PushChatKey.pem
				// Encode the payload as JSON
				$payload = json_encode($body);
				
				// Build the binary notification
				$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
				//$result = fwrite($fp, $msg, strlen($msg)); to: $result = fwrite($fp, $msg);
				
				// Send it to the server
				$result = fwrite($fp, $msg, strlen($msg));
				
				if (!$result)
				echo 'Message not delivered' . PHP_EOL;
				else
				echo 'Message successfully delivered' . PHP_EOL;
				echo $result;
				
				// Close the connection to the server
				fclose($fp);
		}
	}
    
    

?>
